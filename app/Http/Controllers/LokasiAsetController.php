<?php

namespace App\Http\Controllers;

use App\Models\LokasiAset;
use App\Models\Aset;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokasiAsetController extends Controller
{
    // LIST LOKASI (bisa difilter per aset)
    public function index(Request $request)
    {
        $query = LokasiAset::with(['aset', 'media'])->orderBy('created_at', 'desc');

        if ($request->filled('aset_id')) {
            $query->where('aset_id', $request->aset_id);
        }

        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%$search%")
                  ->orWhere('lokasi_text', 'like', "%$search%");
            });
        }

        $lokasi = $query->paginate(10);
        $asetList = Aset::orderBy('nama_aset')->get(); // untuk dropdown filter di view

        return view('lokasi_aset.index', compact('lokasi', 'asetList'));
    }

    // FORM TAMBAH
    public function create()
    {
        $asetList = Aset::orderBy('nama_aset')->get();
        return view('lokasi_aset.create', compact('asetList'));
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'aset_id'     => 'required|exists:aset,aset_id',
            'keterangan'  => 'nullable|string|max:255',
            'lokasi_text' => 'nullable|string',
            'rt'          => 'nullable|string|max:10',
            'rw'          => 'nullable|string|max:10',
            'denah'       => 'nullable|image|max:2048',     // foto/denah
            'caption'     => 'nullable|string|max:255',
        ]);

        $lokasi = LokasiAset::create($request->only([
            'aset_id',
            'keterangan',
            'lokasi_text',
            'rt',
            'rw',
        ]));

        // simpan denah/foto ke tabel media
        if ($request->hasFile('denah')) {
            $this->saveMediaLokasi($lokasi, $request->file('denah'), $request->input('caption'));
        }

        return redirect()
            ->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil ditambahkan.');
    }

    // DETAIL (opsional)
    public function show($id)
    {
        $lokasi = LokasiAset::with(['aset', 'media'])->findOrFail($id);
        return view('lokasi_aset.show', compact('lokasi'));
    }

    // FORM EDIT
    public function edit($id)
    {
        $lokasi   = LokasiAset::with('media', 'aset')->findOrFail($id);
        $asetList = Aset::orderBy('nama_aset')->get();
        $denah    = $lokasi->media()->first(); // denah utama

        return view('lokasi_aset.edit', compact('lokasi', 'asetList', 'denah'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $lokasi = LokasiAset::findOrFail($id);

        $request->validate([
            'aset_id'     => 'required|exists:aset,aset_id',
            'keterangan'  => 'nullable|string|max:255',
            'lokasi_text' => 'nullable|string',
            'rt'          => 'nullable|string|max:10',
            'rw'          => 'nullable|string|max:10',
            'denah'       => 'nullable|image|max:2048',
            'caption'     => 'nullable|string|max:255',
        ]);

        $lokasi->update($request->only([
            'aset_id',
            'keterangan',
            'lokasi_text',
            'rt',
            'rw',
        ]));

        // jika ada denah baru → ganti yang lama
        if ($request->hasFile('denah')) {
            $this->replaceMediaLokasi($lokasi, $request->file('denah'), $request->input('caption'));
        } else {
            // kalau hanya caption diganti
            if ($request->filled('caption')) {
                $media = $lokasi->media()->orderBy('sort_order')->first();
                if ($media) {
                    $media->update(['caption' => $request->input('caption')]);
                }
            }
        }

        return redirect()
            ->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $lokasi = LokasiAset::with('media')->findOrFail($id);

        // hapus file fisik + baris media
        foreach ($lokasi->media as $media) {
            if ($media->file_url && Storage::disk('public')->exists($media->file_url)) {
                Storage::disk('public')->delete($media->file_url);
            }
            $media->delete();
        }

        $lokasi->delete();

        return redirect()
            ->route('lokasi-aset.index')
            ->with('success', 'Lokasi aset berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER MEDIA LOKASI_ASET
    |--------------------------------------------------------------------------
    */

    protected function saveMediaLokasi(LokasiAset $lokasi, $file, ?string $caption = null, int $sortOrder = 0): void
    {
        // Simpan file ke storage/app/public/lokasi_aset
        $path = $file->store('lokasi_aset', 'public');

        Media::create([
            'ref_table' => 'lokasi_aset',
            'ref_id'    => $lokasi->lokasi_id,
            'file_url'  => $path,
            'caption'   => $caption,
            'mime_type' => $file->getClientMimeType(),
            'sort_order'=> $sortOrder,
        ]);
    }

    protected function replaceMediaLokasi(LokasiAset $lokasi, $file, ?string $caption = null): void
    {
        $oldMedia = $lokasi->media()->orderBy('sort_order')->first();

        if ($oldMedia) {
            if ($oldMedia->file_url && Storage::disk('public')->exists($oldMedia->file_url)) {
                Storage::disk('public')->delete($oldMedia->file_url);
            }
            $oldMedia->delete();
        }

        $this->saveMediaLokasi($lokasi, $file, $caption, 0);
    }
}
