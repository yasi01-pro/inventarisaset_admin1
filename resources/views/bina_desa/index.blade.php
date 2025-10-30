@extends('layouts.main')
@section('title','Bina Desa')
@section('content')
<div class="mb-3">
  <a href="{{ route('bina-desa.create') }}" class="btn btn-primary">Tambah Program</a>
</div>
<div class="card"><div class="card-body">
  <table class="table">
    <thead><tr><th>#</th><th>Nama Program</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
    <tbody>
      @foreach($programs as $p)
      <tr>
        <td>{{ $p->id }}</td>
        <td>{{ $p->nama_program }}</td>
        <td>{{ Str::limit($p->deskripsi,60) }}</td>
        <td>
          <a href="{{ route('bina-desa.edit',$p->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('bina-desa.destroy',$p->id) }}" method="post" style="display:inline-block">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div></div>
@endsection
