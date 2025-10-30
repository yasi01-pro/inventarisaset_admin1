@extends('layouts.main')
@section('title','Tambah Warga')
@section('content')
<div class="card"><div class="card-body">
  <form action="{{ route('warga.store') }}" method="post">
    @csrf
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
      @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>NIK</label>
      <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
      @error('nik')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>Alamat</label>
      <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}">
      @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <button class="btn btn-success">Simpan</button>
  </form>
</div></div>
@endsection
