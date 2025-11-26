@extends('layouts.main')
@section('title','Pemeliharaan Aset')

@section('content')
<div class="content-wrapper p-3">

    <div class="d-flex justify-content-between mb-3">
        <div>
            <h3 class="fw-bold text-dark">🛠 Riwayat Pemeliharaan Aset</h3>
            <small class="text-muted">Pantau seluruh aktivitas pemeliharaan yang pernah dilakukan.</small>
        </div>
        <a href="{{ route('pemeliharaan-aset.create') }}" class="btn btn-primary btn-sm shadow">+ Tambah Riwayat</a>
    </div>

    {{-- FILTER --}}
    <div class="card shadow-sm border-0 mb-3" style="background:#e9ecef;">
        <div class="card-body">
            <form method="GET" action="{{ route('pemeliharaan-aset.index') }}" class="row g-2 align-items-end">

                <div class="col-md-4">
                    <label class="fw-semibold">Filter Aset</label>
                    <select name="aset_id" class="form-control form-control-sm">
                        <option value="">Semua Aset</option>
                        @foreach($asetList as $a)
                        <option value="{{ $a->aset_id }}" {{ request('aset_id')==$a->aset_id?'selected':'' }}>
                            {{ $a->nama_aset }} ({{ $a->kode_aset }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="fw-semibold">Cari Tindakan / Pelaksana</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                           placeholder="Filter berdasarkan tindakan / pelaksana...">
                </div>

                <div class="col-md-4">
                    <button class="btn btn-secondary btn-sm w-100">🔍 Terapkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE LIST --}}
    <div class="card shadow-sm border-0" style="background:#f2f2f2;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-dark text-light">
                <tr>
                    <th width="50">No</th>
                    <th>Aset</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Pelaksana</th>
                    <th>Biaya</th>
                    <th>Bukti</th>
                    <th width="140">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pemeliharaan as $row)
                @php $bukti = $row->media->first(); @endphp

                <tr>
                    <td>{{ ($pemeliharaan->currentPage()-1)*$pemeliharaan->perPage()+$loop->iteration }}</td>
                    <td>
                        <strong>{{ $row->aset->nama_aset }}</strong><br>
                        <small class="text-muted">{{ $row->aset->kode_aset }}</small>
                    </td>
                    <td>{{ $row->tindakan }}</td>
                    <td>{{ $row->tanggal->format('d M Y') }}</td>
                    <td>{{ $row->pelaksana }}</td>
                    <td class="fw-bold text-success">
                        Rp {{ number_format($row->biaya,0,',','.') }}
                    </td>
                    <td>
                        @if($bukti)
                            <img src="{{ asset('storage/'.$bukti->file_url) }}" style="width:65px;height:65px;object-fit:cover;border-radius:6px;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pemeliharaan-aset.edit',$row->pemeliharaan_id) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>

                        <form method="POST" action="{{ route('pemeliharaan-aset.destroy',$row->pemeliharaan_id) }}"
                              class="d-inline" onsubmit="return confirm('Hapus data pemeliharaan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                @empty
                    <tr><td colspan="8" class="text-center text-muted p-4">
                        Belum ada data pemeliharaan.
                        <br>
                        <a href="{{ route('pemeliharaan-aset.create') }}" class="btn btn-link btn-sm mt-2">
                            + Tambah Riwayat Perawatan
                        </a>
                    </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $pemeliharaan->links() }}
        </div>
    </div>

</div>
@endsection
