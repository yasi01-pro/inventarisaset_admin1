@extends('layouts.main')

@section('title','Data Aset')

@section('content')
<div class="content-wrapper p-3">

    {{-- HEADER + ACTION --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0 fw-bold">Data Aset</h3>
            <small class="text-muted">
                Kelola daftar aset beserta kategori, nilai perolehan, dan kondisinya.
            </small>
        </div>
        <a href="{{ route('aset.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Tambah Aset
        </a>
    </div>

    {{-- INFO KECIL --}}
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="badge badge-secondary p-3">
                            <i class="fas fa-box-open fa-lg"></i>
                        </span>
                    </div>
                    <div>
                        <div class="text-muted text-uppercase small">Total Aset</div>
                        <div class="h4 mb-0">{{ $aset->total() ?? $aset->count() }}</div>
                        <small class="text-muted">Aset yang terdaftar dalam sistem.</small>
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
                        <div class="text-muted text-uppercase small">Filter & Pencarian</div>
                        <small class="text-muted">
                            Gunakan kolom pencarian di kanan untuk menemukan aset berdasarkan
                            nama atau kode aset.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD TABEL --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Daftar Aset</span>

            {{-- SEARCH --}}
            <form action="{{ route('aset.index') }}" method="GET" class="form-inline">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       class="form-control form-control-sm mr-2"
                       placeholder="Cari nama / kode aset...">
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
                            <th style="width: 60px;">No</th>
                            <th>Foto</th>
                            <th>Kode / Nama Aset</th>
                            <th>Kategori</th>
                            <th>Tgl Perolehan</th>
                            <th class="text-right">Nilai Perolehan</th>
                            <th>Kondisi</th>
                            <th class="text-right" style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aset as $row)
                            @php
                                $foto = $row->media->first();
                            @endphp
                            <tr>
                                <td>{{ ($aset->currentPage() - 1) * $aset->perPage() + $loop->iteration }}</td>

                                {{-- FOTO --}}
                                <td class="align-middle">
                                    @if($foto && $foto->file_url)
                                        <img src="{{ asset('storage/'.$foto->file_url) }}"
                                             alt="Foto Aset"
                                             class="img-thumbnail"
                                             style="width:60px;height:60px;object-fit:cover;">
                                    @else
                                        <span class="text-muted small">Tidak ada</span>
                                    @endif
                                </td>

                                {{-- KODE & NAMA --}}
                                <td class="align-middle">
                                    <div class="fw-semibold">{{ $row->nama_aset }}</div>
                                    <small class="text-muted">Kode: {{ $row->kode_aset }}</small>
                                </td>

                                {{-- KATEGORI --}}
                                <td class="align-middle">
                                    {{ $row->kategori->nama ?? '-' }}
                                </td>

                                {{-- TGL PEROLEHAN --}}
                                <td class="align-middle">
                                    {{ $row->tgl_perolehan ? $row->tgl_perolehan->format('d M Y') : '-' }}
                                </td>

                                {{-- NILAI --}}
                                <td class="align-middle text-right">
                                    Rp {{ number_format($row->nilai_perolehan, 0, ',', '.') }}
                                </td>

                                {{-- KONDISI --}}
                                <td class="align-middle">
                                    @php
                                        $kondisi = strtolower($row->kondisi);
                                        $badgeClass = 'badge-secondary';
                                        if (str_contains($kondisi, 'baik')) $badgeClass = 'badge-success';
                                        elseif (str_contains($kondisi, 'ringan')) $badgeClass = 'badge-warning';
                                        elseif (str_contains($kondisi, 'berat')) $badgeClass = 'badge-danger';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($row->kondisi) }}</span>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-right align-middle">
                                    <a href="{{ route('aset.edit', $row->aset_id) }}"
                                       class="btn btn-sm btn-outline-secondary mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('aset.destroy', $row->aset_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada aset yang terdaftar.
                                    <br>
                                    <a href="{{ route('aset.create') }}" class="btn btn-link btn-sm mt-2">
                                        + Tambah aset pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if(method_exists($aset, 'links'))
            <div class="card-footer bg-white py-2">
                <div class="d-flex justify-content-end">
                    {{ $aset->appends(['q' => request('q')])->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- SweetAlert untuk flash success --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: "{{ session('success') }}",
    timer: 1800,
    showConfirmButton: false
});
</script>
@endif

@endsection
