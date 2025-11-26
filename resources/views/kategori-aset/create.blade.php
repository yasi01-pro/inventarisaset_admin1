@extends('layouts.main')

@section('title','Tambah Kategori')

@section('content')
<div class="content-wrapper p-3">

    <h4 class="fw-bold mb-2">Tambah Kategori Aset</h4>
    <small class="text-muted">Isi data kategori baru untuk disimpan</small>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-body">

            <form id="formCreate" action="{{ route('kategori-aset.store') }}" method="POST">
                @csrf

                <div class="form-group mb-2">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama kategori" required>
                </div>

                <div class="form-group mb-2">
                    <label>Kode</label>
                    <input type="text" name="kode" class="form-control" placeholder="Contoh: ATK, FURN, ELEK" required>
                </div>

                <div class="form-group mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi kategori (opsional)"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kategori-aset.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formCreate').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Simpan Data?',
        text: "Pastikan data sudah benar!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((x)=>{
        if(x.isConfirmed) this.submit();
    });
});
</script>

@endsection
