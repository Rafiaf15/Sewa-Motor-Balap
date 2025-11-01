@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-3">
    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2 fw-bold">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h2>
                    <p class="mb-0 opacity-75">Kelola sistem penyewaan motor balap & joki dengan mudah</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="fas fa-chart-line" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; font-weight: 600;">Total Motor</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalMotors ?? 0 }}</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> Unit tersedia</small>
                        </div>
                        <div class="text-end">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-motorcycle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('admin.motors.index') }}" class="text-danger text-decoration-none small">
                        Kelola Motor <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; font-weight: 600;">Total Joki</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalJokis ?? 0 }}</h2>
                            <small class="text-info"><i class="fas fa-user-check"></i> Joki tersedia</small>
                        </div>
                        <div class="text-end">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1);">
                                <i class="fas fa-user-ninja fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="#" class="text-warning text-decoration-none small">
                        Kelola Joki <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #28a745 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; font-weight: 600;">Sewa Aktif</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $activeRentals ?? 0 }}</h2>
                            <small class="text-warning"><i class="fas fa-clock"></i> Sedang berjalan</small>
                        </div>
                        <div class="text-end">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: rgba(40, 167, 69, 0.1);">
                                <i class="fas fa-box-open fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('admin.rentals.active') }}" class="text-success text-decoration-none small">
                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #007bff !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; font-weight: 600;">Total User</h6>
                            <h2 class="mb-0 fw-bold text-dark">{{ $totalUsers ?? 0 }}</h2>
                            <small class="text-primary"><i class="fas fa-users"></i> Pengguna terdaftar</small>
                        </div>
                        <div class="text-end">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: rgba(0, 123, 255, 0.1);">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('admin.users.index') }}" class="text-primary text-decoration-none small">
                        Kelola User <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-3 mb-4">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.motors.create') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-plus-circle me-2"></i>Tambah Motor Baru</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-plus-circle me-2"></i>Tambah Kategori</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-user-shield me-2"></i>Verifikasi KYC User</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.rentals.active') }}" class="btn btn-outline-warning d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-boxes me-2"></i>Kelola Penyewaan Aktif</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        System Info
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                Tanggal Hari Ini
                            </span>
                            <strong>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</strong>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-clock text-success me-2"></i>
                                Waktu Server
                            </span>
                            <strong>{{ \Carbon\Carbon::now()->format('H:i:s') }}</strong>
                        </li>
                        <li class="mb-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-server text-warning me-2"></i>
                                Laravel Version
                            </span>
                            <strong>{{ app()->version() }}</strong>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <i class="fas fa-database text-danger me-2"></i>
                                Database Status
                            </span>
                            <span class="badge bg-success">Connected</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Rentals & User History -->
    <div class="row g-3">
        <!-- Cari Riwayat User -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-search text-primary me-2"></i>
                        Cari Riwayat Penyewaan
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" onsubmit="event.preventDefault(); var id = this.querySelector('[name=user_id]').value; if(id){ window.location.href = '/admin/rentals/' + encodeURIComponent(id) + '/history'; }">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="number" 
                                   min="1" 
                                   class="form-control form-control-lg" 
                                   name="user_id" 
                                   placeholder="Masukkan ID User (contoh: 5)">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </form>
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Masukkan ID user untuk melihat riwayat penyewaan lengkap</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Useful Links -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3 pb-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-link text-success me-2"></i>
                        Useful Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-tags text-primary me-2"></i>
                            Manajemen Kategori Motor
                        </a>
                        <a href="{{ route('admin.motors.index') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-motorcycle text-danger me-2"></i>
                            Daftar Semua Motor
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-users text-success me-2"></i>
                            Manajemen User & KYC
                        </a>
                        <a href="{{ route('admin.rentals.active') }}" class="list-group-item list-group-item-action border-0 px-0">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Monitor Penyewaan Aktif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .list-group-item-action:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #4b0037;
        padding-left: 1rem !important;
    }
</style>
@endpush
@endsection