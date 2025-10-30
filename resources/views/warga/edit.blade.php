@extends('layouts.main')
@section('title','Edit Warga')
@section('content')
<div class="card"><div class="card-body">
  <form action="{{ route('warga.update',$warga->id) }}" method="post">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" value="{{ old('nama', $warga->nama) }}">
      @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>NIK</label>
      <input type="text" name="nik" class="form-control" value="{{ old('nik', $warga->nik) }}">
      @error('nik')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>Alamat</label>
      <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $warga->alamat) }}">
      @error('alamat')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
</div></div>
@endsection
