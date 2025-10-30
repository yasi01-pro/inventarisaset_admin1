@extends('layouts.main')
@section('title','Manajemen User')
@section('content')
<div class="mb-3">
  <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a>
</div>
<div class="card">
  <div class="card-body">
    <table class="table table-bordered">
      <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
      <tbody>
      @foreach($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->role }}</td>
          <td>
            <a href="{{ route('user.edit',$u->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('user.destroy',$u->id) }}" method="post" style="display:inline-block">
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
