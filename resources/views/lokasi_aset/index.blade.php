@extends('layouts.main')
@section('title','Lokasi Aset')

@section('content')
<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h3 class="fw-bold text-dark">📍 Daftar Lokasi Aset</h3>
            <small class="text-muted">Kelola denah/foto lokasi setiap aset secara terstruktur.</small>
        </div>
        <a href="{{ route('lokasi-aset.create') }}" class="btn btn-primary btn-sm shadow">
            + Tambah Lokasi
        </a>
    </div>

    {{-- FILTER --}}
    <div class="card shadow-sm border-0 mb-3" style="background:#e9ecef;">
        <div class="card-body">
            <form method="GET" action="{{ route('lokasi-aset.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="fw-semibold">Filter Berdasarkan Aset</label>
                    <select name="aset_id" class="form-control form-control-sm">
                        <option value="">Semua Aset</option>
                        @foreach($asetList as $aset)
                        <option value="{{ $aset->aset_id }}" {{ request('aset_id') == $aset->aset_id ? 'selected':'' }}>
                            {{ $aset->nama_aset }} ({{ $aset->kode_aset }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="fw-semibold">Cari Lokasi</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                           placeholder="Keterangan lokasi / teks lokasi...">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-sm w-100">🔍 Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card shadow-sm border-0" style="background:#f2f2f2;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-dark text-light">
                    <tr>
                        <th class="text-center" width="50">No</th>
                        <th>Aset</th>
                        <th>Lokasi / RT-RW</th>
                        <th>Denah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lokasi as $row)
                    @php $foto = $row->media->first(); @endphp

                    <tr>
                        <td class="text-center">{{ ($lokasi->currentPage()-1) * $lokasi->perPage() + $loop->iteration }}</td>

                        <td>
                            <strong>{{ $row->aset->nama_aset }}</strong>
                            <br><small class="text-muted">{{ $row->aset->kode_aset }}</small>
                        </td>

                        <td>
                            {{ $row->keterangan ?: '-' }}<br>
                            <small class="text-muted">RT {{ $row->rt ?? '-'}} / RW {{$row->rw ?? '-'}}</small>
                        </td>

                        <td>
                            @if($foto)
                                <img src="{{ asset('storage/'.$foto->file_url) }}"
                                     style="width:75px;height:75px;object-fit:cover;border-radius:5px;"
                                     class="shadow-sm">
                            @else
                                <span class="text-muted small">Tidak ada foto</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('lokasi-aset.edit',$row->lokasi_id) }}"
                               class="btn btn-sm btn-outline-primary">Edit</a>

                            <form action="{{ route('lokasi-aset.destroy',$row->lokasi_id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus lokasi ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">
                            Belum ada data lokasi aset.<br>
                            <a href="{{ route('lokasi-aset.create') }}" class="btn btn-link btn-sm mt-2">
                                + Tambah lokasi pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $lokasi->links() }}
        </div>

    </div>
</div>

{{-- sukses alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:"{{ session('success') }}",
    timer:1800,
    showConfirmButton:false
})
</script>
@endif

@endsection
