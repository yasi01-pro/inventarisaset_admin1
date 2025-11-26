@extends('layouts.main')

@section('title','Kategori Aset')

@section('content')
<div class="content-wrapper p-3">

    {{-- HEADER + ACTION --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">Kategori Aset</h3>
            <small class="text-muted">
                Kelola kategori aset yang digunakan dalam sistem Inventaris & Aset
            </small>
        </div>
        <a href="{{ route('kategori-aset.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- FLASH SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- ROW STATISTIK KECIL --}}
    @php
        $total = $kategori->count();
    @endphp
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="badge badge-secondary p-3">
                            <i class="fas fa-tags fa-lg"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase">Total Kategori</div>
                        <div class="h4 mb-0">{{ $total }}</div>
                        <small class="text-muted">
                            @if($total > 0)
                                Kategori aset terdaftar.
                            @else
                                Belum ada kategori, tambahkan sekarang.
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="badge badge-secondary p-3">
                            <i class="fas fa-layer-group fa-lg"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase">Status Data</div>
                        <div class="h6 mb-0">
                            @if($total > 0)
                                Siap digunakan
                            @else
                                Menunggu konfigurasi
                            @endif
                        </div>
                        <small class="text-muted">
                            Gunakan kategori untuk mengelompokkan aset.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="badge badge-secondary p-3">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase">Tips Penggunaan</div>
                        <small class="text-muted d-block">
                            Gunakan kode singkat & konsisten, misalnya:
                            <strong>ATK</strong> (Alat Tulis), <strong>ELEK</strong> (Elektronik),
                            <strong>FURN</strong> (Furniture).
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD TABEL + SEARCH --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Daftar Kategori Aset</span>

            {{-- SEARCH SEDERHANA (OPSIONAL) --}}
            <form action="{{ route('kategori-aset.index') }}" method="GET" class="form-inline">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control form-control-sm mr-2"
                       placeholder="Cari nama / kode...">
                <button class="btn btn-outline-secondary btn-sm" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Nama Kategori</th>
                            <th style="width:140px;">Kode</th>
                            <th>Deskripsi</th>
                            <th class="text-right" style="width:170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <strong>{{ $row->nama }}</strong>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-secondary">
                                        {{ $row->kode }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    {{ $row->deskripsi ?: '-' }}
                                </td>
                                <td class="text-right align-middle">
                                    <a href="{{ route('kategori-aset.edit', $row->kategori_id) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <form action="{{ route('kategori-aset.destroy', $row->kategori_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada kategori aset yang terdaftar.
                                    <br>
                                    <a href="{{ route('kategori-aset.create') }}" class="btn btn-link btn-sm mt-2">
                                        + Tambah kategori pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION (JIKA PAKAI PAGINATE DI CONTROLLER) --}}
        @if(method_exists($kategori,'links'))
            <div class="card-footer bg-white py-2">
                <div class="d-flex justify-content-end">
                    {{ $kategori->links() }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
