@extends('layouts.main')

@section('title', 'Edit Kategori Aset')

@section('content')
<div class="container-fluid py-3">
    <div class="mb-3">
        <h4 class="mb-0">Edit Kategori Aset</h4>
        <small class="text-muted">Perbarui data kategori aset</small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('kategori-aset.update', $kategori->kategori_id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('kategori_aset._form', ['kategori' => $kategori])

            </form>
        </div>
    </div>
</div>
@endsection
