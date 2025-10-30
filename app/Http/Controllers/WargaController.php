<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::orderBy('id','desc')->get();
        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:wargas',
            'alamat' => 'required'
        ]);

        Warga::create($request->only(['nama','nik','alamat']));
        return redirect()->route('warga.index')->with('success','Warga berhasil ditambahkan');
    }

    public function edit(Warga $warga)
    {
        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:wargas,nik,'.$warga->id,
            'alamat' => 'required'
        ]);

        $warga->update($request->only(['nama','nik','alamat']));
        return redirect()->route('warga.index')->with('success','Warga berhasil diperbarui');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('success','Warga berhasil dihapus');
    }
}
