@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-3">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-bold">Dashboard Admin</h3>
            <small class="text-muted">Ringkasan data dan aktivitas sistem</small>
        </div>
        <div class="text-end">
            <span class="d-block fw-semibold">
                {{ session('user.name') ?? 'Administrator' }}
            </span>
            <small class="text-muted">Role: {{ session('user.role') ?? 'admin' }}</small>
        </div>
    </div>

    {{-- ROW STATISTIK UTAMA --}}
    <div class="row g-3 mb-4">

        {{-- CARD TOTAL WARGA --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small">Total Warga</span>
                        <i class="bi bi-people-fill fs-4 text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $totalWarga ?? 0 }}</h3>
                    <small class="text-muted">Data warga terdaftar</small>
                </div>
            </div>
        </div>

        {{-- CARD TOTAL USER --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small">User Sistem</span>
                        <i class="bi bi-person-badge-fill fs-4 text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $totalUser ?? 0 }}</h3>
                    <small class="text-muted">Admin & operator aktif</small>
                </div>
            </div>
        </div>

        {{-- CARD PROGRAM BINA DESA --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small">Program Bina Desa</span>
                        <i class="bi bi-building-check fs-4 text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $totalProgram ?? 0 }}</h3>
                    <small class="text-muted">Program berjalan</small>
                </div>
            </div>
        </div>

        {{-- CARD NOTIF / PENGUMUMAN --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small">Log Aktivitas</span>
                        <i class="bi bi-activity fs-4 text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $totalLog ?? 0 }}</h3>
                    <small class="text-muted">Aktivitas terbaru hari ini</small>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW KONTEN BAWAH --}}
    <div class="row g-3">

        {{-- KOLOM KIRI: TABEL AKTIVITAS TERBARU --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Aktivitas Terbaru</span>
                    <small class="text-muted">Log sistem terakhir</small>
                </div>
                <div class="card-body">
                    @if(isset($logs) && count($logs) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-muted small">Waktu</th>
                                        <th class="text-muted small">User</th>
                                        <th class="text-muted small">Aksi</th>
                                        <th class="text-muted small text-end">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $log->user_name ?? '-' }}</td>
                                            <td>{{ $log->action ?? '-' }}</td>
                                            <td class="text-end">
                                                <small class="text-muted">{{ $log->description ?? '-' }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada aktivitas terbaru.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RINGKASAN & QUICK ACTION --}}
        <div class="col-lg-4">
            {{-- CARD RINGKASAN SISTEM --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light border-0">
                    <span class="fw-semibold">Ringkasan Sistem</span>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Versi Aplikasi</span>
                            <span class="fw-semibold">v1.0.0</span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Terakhir Login</span>
                            <span class="fw-semibold">
                                {{ session('last_login') ?? now()->format('d M Y H:i') }}
                            </span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Role Saat Ini</span>
                            <span class="fw-semibold text-uppercase">
                                {{ session('user.role') ?? 'admin' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- CARD QUICK ACTION --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <span class="fw-semibold">Aksi Cepat</span>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary btn-sm">
                            Kelola Data Warga
                        </a>
                        <a href="{{ route('kategori-aset.index') }}" class="btn btn-outline-secondary btn-sm">
                            Kelola Bina Desa
                        </a>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary btn-sm">
                            Kelola User Sistem
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
