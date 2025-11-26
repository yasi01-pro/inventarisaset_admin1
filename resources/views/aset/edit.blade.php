@extends('layouts.main')

@section('title','Edit Aset')

@section('content')
<div class="content-wrapper p-3">

    <h3 class="fw-bold mb-1">Edit Aset</h3>
    <small class="text-muted">
        Perbarui informasi aset dan foto jika diperlukan.
    </small>

    <div class="card shadow-sm border-0 mt-3">
        <div class="card-header bg-light">
            <strong>Form Edit Aset</strong>
        </div>
        <div class="card-body">
            <form id="formEditAset" action="{{ route('aset.update', $aset->aset_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- KATEGORI --}}
                <div class="form-group mb-3">
                    <label for="kategori_id">Kategori Aset</label>
                    <select name="kategori_id" id="kategori_id"
                            class="form-control @error('kategori_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}"
                                {{ old('kategori_id', $aset->kategori_id) == $k->kategori_id ? 'selected' : '' }}>
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
                               value="{{ old('kode_aset', $aset->kode_aset) }}"
                               required>
                        @error('kode_aset')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-8 mb-3">
                        <label for="nama_aset">Nama Aset</label>
                        <input type="text" name="nama_aset" id="nama_aset"
                               class="form-control @error('nama_aset') is-invalid @enderror"
                               value="{{ old('nama_aset', $aset->nama_aset) }}"
                               required>
                        @error('nama_aset')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- TGL & NILAI & KONDISI --}}
                <div class="form-row">
                    <div class="form-group col-md-4 mb-3">
                        <label for="tgl_perolehan">Tanggal Perolehan</label>
                        <input type="date" name="tgl_perolehan" id="tgl_perolehan"
                               class="form-control @error('tgl_perolehan') is-invalid @enderror"
                               value="{{ old('tgl_perolehan', optional($aset->tgl_perolehan)->format('Y-m-d')) }}">
                        @error('tgl_perolehan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label for="nilai_perolehan">Nilai Perolehan (Rp)</label>
                        <input type="number" step="0.01" min="0"
                               name="nilai_perolehan" id="nilai_perolehan"
                               class="form-control @error('nilai_perolehan') is-invalid @enderror"
                               value="{{ old('nilai_perolehan', $aset->nilai_perolehan) }}">
                        @error('nilai_perolehan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4 mb-3">
                        <label for="kondisi">Kondisi</label>
                        @php
                            $kondisiVal = old('kondisi', $aset->kondisi);
                        @endphp
                        <select name="kondisi" id="kondisi"
                                class="form-control @error('kondisi') is-invalid @enderror" required>
                            <option value="Baik" {{ $kondisiVal == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $kondisiVal == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $kondisiVal == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @error('kondisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- FOTO SEKARANG --}}
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label>Foto Saat Ini</label>
                        <div class="border rounded p-2 d-flex align-items-center">
                            @php
                                $fotoLama = $foto ?? ($aset->media->first() ?? null);
                            @endphp
                            @if($fotoLama && $fotoLama->file_url)
                                <img src="{{ asset('storage/'.$fotoLama->file_url) }}"
                                     alt="Foto Aset"
                                     class="img-thumbnail mr-3"
                                     style="width:80px;height:80px;object-fit:cover;">
                                <div>
                                    <small class="text-muted d-block">
                                        {{ $fotoLama->caption ?: 'Tanpa caption' }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $fotoLama->mime_type }}
                                    </small>
                                </div>
                            @else
                                <span class="text-muted small">Belum ada foto tersimpan.</span>
                            @endif
                        </div>
                    </div>

                    {{-- UPLOAD FOTO BARU --}}
                    <div class="form-group col-md-6 mb-3">
                        <label for="foto">Ganti Foto (opsional)</label>
                        <input type="file" name="foto" id="foto"
                               class="form-control-file @error('foto') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted d-block">Jika diisi, foto lama akan diganti.</small>
                        @error('foto')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror>

                        <label for="caption" class="mt-2">Caption Foto</label>
                        <input type="text" name="caption" id="caption"
                               class="form-control @error('caption') is-invalid @enderror"
                               value="{{ old('caption', $fotoLama->caption ?? '') }}"
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
                        Update Aset
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SweetAlert konfirmasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('formEditAset').addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Update data aset?',
        text: "Perubahan akan disimpan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, update',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>
@endsection
