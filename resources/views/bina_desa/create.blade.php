@extends('layouts.main')
@section('title','Tambah Program Bina Desa')
@section('content')
<div class="card"><div class="card-body">
  <form action="{{ route('bina-desa.store') }}" method="post">
    @csrf
    <div class="form-group">
      <label>Nama Program</label>
      <input type="text" name="nama_program" class="form-control" value="{{ old('nama_program') }}">
      @error('nama_program')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
    </div>
    <button class="btn btn-success">Simpan</button>
  </form>
</div></div>
@endsection
