<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Media;
use App\Models\KategoriAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    // LIST ASET
    public function index(Request $request)
    {
        $query = Aset::with(['kategori', 'media'])->orderByDesc('created_at');

        // optional: search sederhana
        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_aset', 'like', "%$search%")
                  ->orWhere('kode_aset', 'like', "%$search%");
            });
        }

        $aset = $query->paginate(10);

        return view('aset.index', compact('aset'));
    }

    // FORM TAMBAH
    public function create()
    {
        $kategori = KategoriAset::orderBy('nama')->get();
        return view('aset.create', compact('kategori'));
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'     => 'required|exists:kategori_aset,kategori_id',
            'kode_aset'       => 'required|unique:aset,kode_aset',
            'nama_aset'       => 'required|string|max:255',
            'tgl_perolehan'   => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi'         => 'required|string|max:50',
            'foto'            => 'nullable|image|max:2048',
            'caption'         => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'kategori_id',
            'kode_aset',
            'nama_aset',
            'tgl_perolehan',
            'nilai_perolehan',
            'kondisi',
        ]);

        $aset = Aset::create($data);

        // simpan foto ke tabel media (ref_table = 'aset')
        if ($request->hasFile('foto')) {
            $this->saveMediaAset($aset, $request->file('foto'), $request->input('caption'));
        }

        return redirect()
            ->route('aset.index')
            ->with('success', 'Aset berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit($id)
    {
        $aset     = Aset::with('media')->findOrFail($id);
        $kategori = KategoriAset::orderBy('nama')->get();

        // foto utama (kalau ada)
        $foto = $aset->media()->first();

        return view('aset.edit', compact('aset', 'kategori', 'foto'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $request->validate([
            'kategori_id'     => 'required|exists:kategori_aset,kategori_id',
            'kode_aset'       => 'required|unique:aset,kode_aset,' . $aset->aset_id . ',aset_id',
            'nama_aset'       => 'required|string|max:255',
            'tgl_perolehan'   => 'nullable|date',
            'nilai_perolehan' => 'nullable|numeric|min:0',
            'kondisi'         => 'required|string|max:50',
            'foto'            => 'nullable|image|max:2048',
            'caption'         => 'nullable|string|max:255',
        ]);

        $aset->update($request->only([
            'kategori_id',
            'kode_aset',
            'nama_aset',
            'tgl_perolehan',
            'nilai_perolehan',
            'kondisi',
        ]));

        // kalau ada foto baru → ganti foto lama (1 utama)
        if ($request->hasFile('foto')) {
            $this->replaceMediaAset($aset, $request->file('foto'), $request->input('caption'));
        } else {
            // kalau hanya caption diubah (tanpa ganti foto)
            if ($caption = $request->input('caption')) {
                $media = $aset->media()->orderBy('sort_order')->first();
                if ($media) {
                    $media->update(['caption' => $caption]);
                }
            }
        }

        return redirect()
            ->route('aset.index')
            ->with('success', 'Aset berhasil diperbarui.');
    }

    // HAPUS ASET + FOTO
    public function destroy($id)
    {
        $aset = Aset::with('media')->findOrFail($id);

        // hapus file fisik & row media
        foreach ($aset->media as $media) {
            if ($media->file_url && Storage::disk('public')->exists($media->file_url)) {
                Storage::disk('public')->delete($media->file_url);
            }
            $media->delete();
        }

        $aset->delete();

        return redirect()
            ->route('aset.index')
            ->with('success', 'Aset berhasil dihapus.');
    }

    // DETAIL (opsional)
    public function show($id)
    {
        $aset = Aset::with(['kategori', 'media'])->findOrFail($id);
        return view('aset.show', compact('aset'));
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER MEDIA
    |--------------------------------------------------------------------------
    */

    protected function saveMediaAset(Aset $aset, $file, ?string $caption = null, int $sortOrder = 0): void
    {
        // simpan file ke storage/app/public/aset
        $path = $file->store('aset', 'public');

        Media::create([
            'ref_table' => 'aset',
            'ref_id'    => $aset->aset_id,
            'file_url'  => $path,
            'caption'   => $caption,
            'mime_type' => $file->getClientMimeType(),
            'sort_order'=> $sortOrder,
        ]);
    }

    protected function replaceMediaAset(Aset $aset, $file, ?string $caption = null): void
    {
        // ambil media utama pertama
        $oldMedia = $aset->media()->orderBy('sort_order')->first();

        if ($oldMedia) {
            if ($oldMedia->file_url && Storage::disk('public')->exists($oldMedia->file_url)) {
                Storage::disk('public')->delete($oldMedia->file_url);
            }
            $oldMedia->delete();
        }

        $this->saveMediaAset($aset, $file, $caption, 0);
    }
}
