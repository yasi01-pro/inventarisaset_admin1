@extends('layouts.main')
@section('title','Tambah Lokasi Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold">Tambah Lokasi Aset</h3>
    <small class="text-muted">Isi detail lokasi dan unggah denah/foto lokasi.</small>

    <div class="card border-0 shadow-sm mt-3" style="background:#f4f4f4;">
        <div class="card-body">

            <form id="formLokasiAset" action="{{ route('lokasi-aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="fw-semibold">Aset</label>
                    <select name="aset_id" class="form-control" required>
                        <option value="">-- Pilih Aset --</option>
                        @foreach($asetList as $a)
                        <option value="{{ $a->aset_id }}">{{ $a->nama_aset }} ({{ $a->kode_aset }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Keterangan Lokasi</label>
                    <input type="text" name="keterangan" class="form-control"
                           placeholder="Gudang Belakang / Ruang Arsip lantai 2 ...">
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Detail Lokasi</label>
                    <textarea name="lokasi_text" rows="3" class="form-control"
                              placeholder="Deskripsi lokasi lebih lengkap..."></textarea>
                </div>

                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label>RT</label>
                        <input type="text" name="rt" class="form-control" placeholder="RT ...">
                    </div>
                    <div class="col-md-6">
                        <label>RW</label>
                        <input type="text" name="rw" class="form-control" placeholder="RW ...">
                    </div>
                </div>

                <hr>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Denah / Foto Lokasi</label>
                    <input type="file" name="denah" class="form-control" accept="image/*">
                    <small class="text-muted">Opsional — Maks 2MB</small>
                </div>

                <div class="form-group mb-4">
                    <label>Caption (opsional)</label>
                    <input type="text" name="caption" class="form-control" placeholder="Catatan foto">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('lokasi-aset.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formLokasiAset').addEventListener('submit', e=>{
    e.preventDefault();
    Swal.fire({
        title:'Simpan lokasi?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText:'Simpan',
        cancelButtonText:'Batal',
    }).then(r=>{
        if(r.isConfirmed) e.target.submit();
    });
});
</script>

@endsection
