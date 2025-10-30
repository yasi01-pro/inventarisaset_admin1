@extends('layouts.main')
@section('title','Edit Program')
@section('content')
<div class="card"><div class="card-body">
  <form action="{{ route('bina-desa.update',$program->id) }}" method="post">
    @csrf @method('PUT')
    <div class="form-group">
      <label>Nama Program</label>
      <input type="text" name="nama_program" class="form-control" value="{{ old('nama_program', $program->nama_program) }}">
      @error('nama_program')<small class="text-danger">{{ $message }}</small>@enderror
    </div>
    <div class="form-group">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $program->deskripsi) }}</textarea>
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
</div></div>
@endsection
