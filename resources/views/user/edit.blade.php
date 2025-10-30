@extends('layouts.main')
@section('title','Edit User')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('user.update',$user->id) }}" method="post">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <div class="form-group">
        <label>Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="form-control">
        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
          <option value="user" {{ old('role', $user->role)=='user'?'selected':'' }}>User</option>
          <option value="admin" {{ old('role', $user->role)=='admin'?'selected':'' }}>Admin</option>
        </select>
        @error('role')<small class="text-danger">{{ $message }}</small>@enderror
      </div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>
@endsection
