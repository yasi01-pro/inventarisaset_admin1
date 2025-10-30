@extends('layouts.main')
@section('title','Warga')
@section('content')
<div class="mb-3">
  <a href="{{ route('warga.create') }}" class="btn btn-primary">Tambah Warga</a>
</div>
<div class="card">
  <div class="card-body">
    <table class="table">
      <thead><tr><th>#</th><th>Nama</th><th>NIK</th><th>Alamat</th><th>Aksi</th></tr></thead>
      <tbody>
        @foreach($wargas as $w)
        <tr>
          <td>{{ $w->id }}</td>
          <td>{{ $w->nama }}</td>
          <td>{{ $w->nik }}</td>
          <td>{{ $w->alamat }}</td>
          <td>
            <a href="{{ route('warga.edit',$w->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('warga.destroy',$w->id) }}" method="post" style="display:inline-block">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
