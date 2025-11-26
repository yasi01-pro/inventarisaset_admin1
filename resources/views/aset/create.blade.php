@extends('layouts.main')

@section('title','Tambah Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold mb-1">Tambah Aset</h3>
    <small class="text-muted">Lengkapi data aset dengan detail perolehan dan kondisi.</small>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-light">
            <strong>Form Input Aset</strong>
        </div>
        <div class="card-body">
            <form id="formCreateAset" action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- KATEGORI --}}
                <div class="form-group mb-3">
                    <label for="kategori_id">Kategori Aset</label>
                    <select name="kategori_id" id="kategori_id"
                            class="form-control @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}" {{ old('kategori_id') == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama }} ({{ $k->kode }})
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KODE & NAMA --}}
                <div class="form-row">
                    <div class="form-group col-md-4 mb-3">
                        <label for="kode_aset">Kode Aset</label>
                        <input type="text" name="kode_aset" id="kode_aset"
                               class="form-control @error('kode_aset') is-invalid @enderror"
                               value="{{ old('kode_aset') }}"
                               placeholder="Misal: AST-001" required>
                        @error('kode_aset')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-8 mb-3">
                        <label for="nama_aset">Nama Aset</label>
                        <input type="text" name="nama_aset" id="nama_aset"
                               class="form-control @error('nama_aset') is-invalid @enderror"
                               value="{{ old('nama_aset') }}"
                               placeholder="Masukkan nama aset" required>
                        @error('nama_aset')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- TGL & NILAI --}}
                <div class="form-row">
                    <div class="form-group col-md-4 mb-3">
                        <label for="tgl_perolehan">Tanggal Perolehan</label>
                        <input type="date" name="tgl_perolehan" id="tgl_perolehan"
                               class="form-control @error('tgl_perolehan') is-invalid @enderror"
                               value="{{ old('tgl_perolehan') }}">
                        @error('tgl_perolehan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label for="nilai_perolehan">Nilai Perolehan (Rp)</label>
                        <input type="number" step="0.01" min="0"
                               name="nilai_perolehan" id="nilai_perolehan"
                               class="form-control @error('nilai_perolehan') is-invalid @enderror"
                               value="{{ old('nilai_perolehan') }}"
                               placeholder="0">
                        @error('nilai_perolehan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- KONDISI --}}
                    <div class="form-group col-md-4 mb-3">
                        <label for="kondisi">Kondisi</label>
                        <select name="kondisi" id="kondisi"
                                class="form-control @error('kondisi') is-invalid @enderror" required>
                            @php
                                $kondisiOld = old('kondisi', 'Baik');
                            @endphp
                            <option value="Baik" {{ $kondisiOld == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $kondisiOld == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $kondisiOld == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- FOTO & CAPTION --}}
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="foto">Foto Aset</label>
                        <input type="file" name="foto" id="foto"
                               class="form-control-file @error('foto') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted d-block">Opsional. Maksimal 2MB.</small>
                        @error('foto')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="caption">Caption Foto</label>
                        <input type="text" name="caption" id="caption"
                               class="form-control @error('caption') is-invalid @enderror"
                               value="{{ old('caption') }}"
                               placeholder="Keterangan singkat foto (opsional)">
                        @error('caption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('aset.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Aset
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SweetAlert konfirmasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formCreateAset').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Simpan data aset?',
        text: "Pastikan data sudah benar sebelum disimpan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection
