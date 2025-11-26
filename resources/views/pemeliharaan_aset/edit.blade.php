@extends('layouts.main')
@section('title','Edit Pemeliharaan Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold text-dark">Edit Pemeliharaan Aset</h3>
    <small class="text-muted">Perbaiki data pemeliharaan atau ganti bukti pelaksanaan.</small>

    <div class="card shadow-sm border-0 mt-3" style="background:#e8e8e8;">
        <div class="card-body">

            <form id="editPem" action="{{ route('pemeliharaan-aset.update',$pem->pemeliharaan_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group mb-3">
                    <label>Aset</label>
                    <select name="aset_id" class="form-control">
                        @foreach($asetList as $a)
                        <option value="{{ $a->aset_id }}" {{ $pem->aset_id==$a->aset_id?'selected':'' }}>
                            {{ $a->nama_aset }} ({{ $a->kode_aset }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $pem->tanggal->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Pelaksana</label>
                        <input type="text" name="pelaksana" class="form-control" value="{{ $pem->pelaksana }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" value="{{ $pem->biaya }}">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Tindakan</label>
                    <input type="text" name="tindakan" class="form-control" value="{{ $pem->tindakan }}">
                </div>

                <hr>

                {{-- BUKTI --}}
                <label class="fw-semibold">Bukti Sekarang:</label><br>
                @if($bukti)
                    <img src="{{ asset('storage/'.$bukti->file_url) }}" style="width:90px;height:90px;border-radius:10px;object-fit:cover;">
                    <p class="text-muted small">{{ $bukti->caption ?? '-' }}</p>
                @else
                    <span class="text-muted">Tidak ada bukti tersimpan</span>
                @endif
                <br><br>

                <div class="form-group mb-3">
                    <label>Ganti Bukti (opsional)</label>
                    <input type="file" name="bukti" class="form-control">
                </div>

                <div class="form-group mb-4">
                    <label>Caption Bukti</label>
                    <input type="text" name="caption" class="form-control" value="{{ $bukti->caption ?? '' }}">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pemeliharaan-aset.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('editPem').addEventListener('submit',e=>{
    e.preventDefault();
    Swal.fire({
        title:'Simpan perubahan?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Update'
    }).then(r=>{ if(r.isConfirmed) e.target.submit(); });
});
</script>

@endsection
