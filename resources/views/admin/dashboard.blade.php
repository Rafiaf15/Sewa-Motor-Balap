@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-2">
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body bg-dark text-white rounded-top">
            <h2 class="mb-0">
                🏁 Admin Dashboard — Penyewaan Motor Balap & Joki
            </h2>
            <p class="mb-0">Kelola sistem penyewaan motor, joki, dan pengguna dengan cepat dan mudah.</p>
        </div>
    </div>

    {{-- Statistik singkat --}}
    <div class="row text-center mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-danger">🏍️ Total Motor</h5>
                    <p class="display-6">{{ $totalMotors ?? '—' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-warning">👨‍✈️ Total Joki</h5>
                    <p class="display-6">{{ $totalJokis ?? '—' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-success">📦 Sewa Aktif</h5>
                    <p class="display-6">{{ $activeRentals ?? '—' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold text-primary">👥 Total User</h5>
                    <p class="display-6">{{ $totalUsers ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu navigasi --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white fw-bold">
            🔧 Menu Manajemen
        </div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" href="{{ route('admin.categories.index') }}">
                🏷️ Kelola Kategori
            </a>
            <a class="list-group-item list-group-item-action" href="{{ route('admin.motors.index') }}">
                🏍️ Kelola Unit Motor
            </a>
            <a class="list-group-item list-group-item-action" href="{{ route('admin.users.index') }}">
                👥 Kelola User
            </a>
            <a class="list-group-item list-group-item-action" href="{{ route('admin.rentals.active') }}">
                ⏱️ Unit Sedang Disewa (Aktif)
            </a>
        </div>
    </div>

    {{-- Riwayat sewa anggota --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            📜 Lihat Riwayat Penyewaan Anggota
        </div>
        <div class="card-body">
            <form class="row g-3 align-items-center" method="GET"
                onsubmit="event.preventDefault(); var id = this.querySelector('[name=user_id]').value; if(id){ window.location.href = '/admin/rentals/' + encodeURIComponent(id) + '/history'; }">
                <div class="col-auto">
                    <label for="user_id" class="col-form-label fw-semibold">Masukkan ID User</label>
                </div>
                <div class="col-auto">
                    <input type="number" min="1" class="form-control" id="user_id" name="user_id" placeholder="Contoh: 3">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-danger">Lihat Riwayat</button>
                </div>
            </form>
            <small class="text-muted d-block mt-2">
                💡 Tip: Anda juga dapat membuka dari halaman <strong>Kelola User</strong>.
            </small>
        </div>
    </div>
</div>
@endsection
