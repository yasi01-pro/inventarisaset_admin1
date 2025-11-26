@extends('layouts.main')
@section('title','Tambah Pemeliharaan Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold text-dark">Tambah Riwayat Pemeliharaan</h3>
    <small class="text-muted">Catat tindakan pemeliharaan berikut bukti pelaksanaannya.</small>

    <div class="card shadow-sm border-0 mt-3" style="background:#efefef;">
        <div class="card-body">

            <form id="formPemeliharaan" action="{{ route('pemeliharaan-aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ASET --}}
                <div class="form-group mb-3">
                    <label class="fw-semibold">Aset</label>
                    <select name="aset_id" class="form-control" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach($asetList as $a)
                        <option value="{{ $a->aset_id }}">{{ $a->nama_aset }} ({{ $a->kode_aset }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Pemeliharaan</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Pelaksana</label>
                        <input type="text" name="pelaksana" class="form-control" placeholder="Nama teknisi">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Biaya (Rp)</label>
                        <input type="number" name="biaya" class="form-control" min="0" value="0">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Tindakan</label>
                    <input type="text" name="tindakan" class="form-control" placeholder="Contoh: penggantian sparepart, pengecekan sistem..." required>
                </div>

                <hr>

                <div class="form-group mb-3">
                    <label>Bukti Pemeliharaan</label>
                    <input type="file" name="bukti" class="form-control" accept="image/*,application/pdf">
                    <small class="text-muted">Opsional — Foto / PDF maksimal 4MB.</small>
                </div>

                <div class="form-group mb-4">
                    <label>Caption (opsional)</label>
                    <input type="text" name="caption" class="form-control" placeholder="Keterangan bukti">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pemeliharaan-aset.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formPemeliharaan').addEventListener('submit',e=>{
    e.preventDefault();
    Swal.fire({
        title:'Simpan data pemeliharaan?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Simpan'
    }).then(r=>{ if(r.isConfirmed) e.target.submit(); });
});
</script>

@endsection
