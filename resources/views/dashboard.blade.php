@extends('layouts.main')

@section('title','Dashboard')
@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="info-box bg-white p-3">
      <h5>Users</h5>
      <h3>{{ $users }}</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="info-box bg-white p-3">
      <h5>Warga</h5>
      <h3>{{ $wargas }}</h3>
    </div>
  </div>
  <div class="col-md-4">
    <div class="info-box bg-white p-3">
      <h5>Bina Desa Programs</h5>
      <h3>{{ $programs }}</h3>
    </div>
  </div>
</div>
@endsection
