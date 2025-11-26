<?php

namespace App\Http\Controllers;

use App\Models\KategoriAset;
use Illuminate\Http\Request;

class KategoriAsetController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = KategoriAset::latest()->get();
        return view('kategori-aset.index', compact('kategori'));
    }

    // Form tambah
    public function create()
    {
        return view('kategori-aset.create');
    }

    // Proses simpan
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:kategori_aset,kode',
            'deskripsi' => 'nullable'
        ]);

        KategoriAset::create($request->all());

        return redirect()->route('kategori-aset.index')->with('success','Kategori berhasil ditambahkan');
    }

    // Form edit
    public function edit($id)
    {
        $kategori = KategoriAset::findOrFail($id);
        return view('kategori-aset.edit', compact('kategori'));
    }

    // Proses update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => "required|unique:kategori_aset,kode,$id,kategori_id",
        ]);

        KategoriAset::findOrFail($id)->update($request->all());

        return redirect()->route('kategori-aset.index')->with('success','Kategori berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        KategoriAset::findOrFail($id)->delete();
        return redirect()->route('kategori-aset.index')->with('success','Kategori berhasil dihapus');
    }
}
