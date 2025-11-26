<?php

namespace App\Http\Controllers;

use App\Models\PemeliharaanAset;
use App\Models\Aset;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemeliharaanAsetController extends Controller
{
    // LIST PEMELIHARAAN
    public function index(Request $request)
    {
        $query = PemeliharaanAset::with(['aset', 'media'])
            ->orderBy('tanggal', 'desc');

        // filter by aset
        if ($request->filled('aset_id')) {
            $query->where('aset_id', $request->aset_id);
        }

        // search by tindakan/pelaksana
        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('tindakan', 'like', "%$search%")
                  ->orWhere('pelaksana', 'like', "%$search%");
            });
        }

        $pemeliharaan = $query->paginate(10);
        $asetList     = Aset::orderBy('nama_aset')->get();

        return view('pemeliharaan_aset.index', compact('pemeliharaan', 'asetList'));
    }

    // FORM TAMBAH
    public function create()
    {
        $asetList = Aset::orderBy('nama_aset')->get();
        return view('pemeliharaan_aset.create', compact('asetList'));
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'aset_id'   => 'required|exists:aset,aset_id',
            'tanggal'   => 'required|date',
            'tindakan'  => 'required|string|max:255',
            'biaya'     => 'nullable|numeric|min:0',
            'pelaksana' => 'required|string|max:255',
            'bukti'     => 'nullable|file|max:4096', // bisa image/pdf, dll
            'caption'   => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'aset_id',
            'tanggal',
            'tindakan',
            'biaya',
            'pelaksana',
        ]);

        $pem = PemeliharaanAset::create($data);

        // simpan bukti ke tabel media
        if ($request->hasFile('bukti')) {
            $this->saveMediaPemeliharaan($pem, $request->file('bukti'), $request->input('caption'));
        }

        return redirect()
            ->route('pemeliharaan-aset.index')
            ->with('success', 'Data pemeliharaan aset berhasil ditambahkan.');
    }

    // DETAIL (opsional)
    public function show($id)
    {
        $pem = PemeliharaanAset::with(['aset', 'media'])->findOrFail($id);
        return view('pemeliharaan_aset.show', compact('pem'));
    }

    // FORM EDIT
    public function edit($id)
    {
        $pem      = PemeliharaanAset::with('media', 'aset')->findOrFail($id);
        $asetList = Aset::orderBy('nama_aset')->get();
        $bukti    = $pem->media()->first();

        return view('pemeliharaan_aset.edit', compact('pem', 'asetList', 'bukti'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $pem = PemeliharaanAset::findOrFail($id);

        $request->validate([
            'aset_id'   => 'required|exists:aset,aset_id',
            'tanggal'   => 'required|date',
            'tindakan'  => 'required|string|max:255',
            'biaya'     => 'nullable|numeric|min:0',
            'pelaksana' => 'required|string|max:255',
            'bukti'     => 'nullable|file|max:4096',
            'caption'   => 'nullable|string|max:255',
        ]);

        $pem->update($request->only([
            'aset_id',
            'tanggal',
            'tindakan',
            'biaya',
            'pelaksana',
        ]));

        // jika upload bukti baru → ganti bukti lama
        if ($request->hasFile('bukti')) {
            $this->replaceMediaPemeliharaan($pem, $request->file('bukti'), $request->input('caption'));
        } else {
            // kalau cuma caption diubah
            if ($request->filled('caption')) {
                $media = $pem->media()->orderBy('sort_order')->first();
                if ($media) {
                    $media->update(['caption' => $request->input('caption')]);
                }
            }
        }

        return redirect()
            ->route('pemeliharaan-aset.index')
            ->with('success', 'Data pemeliharaan aset berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $pem = PemeliharaanAset::with('media')->findOrFail($id);

        // hapus file fisik + baris media
        foreach ($pem->media as $media) {
            if ($media->file_url && Storage::disk('public')->exists($media->file_url)) {
                Storage::disk('public')->delete($media->file_url);
            }
            $media->delete();
        }

        $pem->delete();

        return redirect()
            ->route('pemeliharaan-aset.index')
            ->with('success', 'Data pemeliharaan aset berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER MEDIA PEMELIHARAAN_ASET
    |--------------------------------------------------------------------------
    */

    protected function saveMediaPemeliharaan(PemeliharaanAset $pem, $file, ?string $caption = null, int $sortOrder = 0): void
    {
        // simpan ke storage/app/public/pemeliharaan_aset
        $path = $file->store('pemeliharaan_aset', 'public');

        Media::create([
            'ref_table' => 'pemeliharaan_aset',
            'ref_id'    => $pem->pemeliharaan_id,
            'file_url'  => $path,
            'caption'   => $caption,
            'mime_type' => $file->getClientMimeType(),
            'sort_order'=> $sortOrder,
        ]);
    }

    protected function replaceMediaPemeliharaan(PemeliharaanAset $pem, $file, ?string $caption = null): void
    {
        $oldMedia = $pem->media()->orderBy('sort_order')->first();

        if ($oldMedia) {
            if ($oldMedia->file_url && Storage::disk('public')->exists($oldMedia->file_url)) {
                Storage::disk('public')->delete($oldMedia->file_url);
            }
            $oldMedia->delete();
        }

        $this->saveMediaPemeliharaan($pem, $file, $caption, 0);
    }
}
