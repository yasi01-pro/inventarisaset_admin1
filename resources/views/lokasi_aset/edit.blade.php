@extends('layouts.main')
@section('title','Edit Lokasi Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold">Edit Lokasi Aset</h3>
    <small class="text-muted">Perbarui posisi & denah lokasi aset.</small>

    <div class="card shadow-sm border-0 mt-3" style="background:#efefef;">
        <div class="card-body">

            <form id="formLokasiEdit" action="{{ route('lokasi-aset.update',$lokasi->lokasi_id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group mb-3">
                    <label class="fw-semibold">Aset</label>
                    <select name="aset_id" class="form-control" required>
                        @foreach($asetList as $a)
                        <option value="{{ $a->aset_id }}"
                            {{ $lokasi->aset_id==$a->aset_id?'selected':'' }}>
                            {{ $a->nama_aset }} ({{ $a->kode_aset }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ $lokasi->keterangan }}" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label class="fw-semibold">Detail Lokasi</label>
                    <textarea name="lokasi_text" rows="3" class="form-control">{{$lokasi->lokasi_text}}</textarea>
                </div>

                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label>RT</label>
                        <input type="text" name="rt" value="{{ $lokasi->rt }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>RW</label>
                        <input type="text" name="rw" value="{{ $lokasi->rw }}" class="form-control">
                    </div>
                </div>

                <div class="border rounded p-3 bg-white mb-3">
                    <label class="fw-semibold">Denah Saat Ini</label><br>
                    @if($denah)
                    <img src="{{ asset('storage/'.$denah->file_url) }}"
                         style="width:90px;height:90px;border-radius:8px;object-fit:cover;">
                    <p class="text-muted small mt-2">{{ $denah->caption ?? '-' }}</p>
                    @else
                    <span class="text-muted small">Belum ada foto tersimpan.</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label>Ganti Denah (opsional)</label>
                    <input type="file" name="denah" class="form-control" accept="image/*">
                    <small class="text-muted">Jika diisi, gambar lama akan diganti.</small>
                </div>

                <div class="form-group mb-4">
                    <label>Caption Foto</label>
                    <input type="text" name="caption"
                           value="{{ $denah->caption ?? '' }}" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('lokasi-aset.index') }}" class="btn btn-secondary">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formLokasiEdit').addEventListener('submit',e=>{
    e.preventDefault();
    Swal.fire({
        title:'Simpan perubahan?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#3085d6',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Update',
        cancelButtonText:'Batal'
    }).then(r=>{ if(r.isConfirmed) e.target.submit(); });
});
</script>

@endsection
