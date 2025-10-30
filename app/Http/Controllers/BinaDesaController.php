<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinaDesa;

class BinaDesaController extends Controller
{
    public function index()
    {
        $programs = BinaDesa::orderBy('id','desc')->get();
        return view('bina_desa.index', compact('programs'));
    }

    public function create()
    {
        return view('bina_desa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'nullable'
        ]);

        BinaDesa::create($request->only(['nama_program','deskripsi']));
        return redirect()->route('bina-desa.index')->with('success','Program berhasil ditambahkan');
    }

    public function edit(BinaDesa $bina_desa)
    {
        return view('bina_desa.edit', ['program' => $bina_desa]);
    }

    public function update(Request $request, BinaDesa $bina_desa)
    {
        $request->validate([
            'nama_program' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $bina_desa->update($request->only(['nama_program','deskripsi']));
        return redirect()->route('bina-desa.index')->with('success','Program berhasil diperbarui');
    }

    public function destroy(BinaDesa $bina_desa)
    {
        $bina_desa->delete();
        return redirect()->route('bina-desa.index')->with('success','Program berhasil dihapus');
    }
}
