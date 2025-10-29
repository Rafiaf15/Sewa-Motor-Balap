@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Profile -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="profile-image mb-3">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle" width="100" height="100" alt="Profile Image">
                        @else
                            <div class="default-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; margin: 0 auto; font-size: 2.5rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h5 class="card-title mb-0">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#profile-info" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i> Informasi Profil
                    </a>
                    <a href="#rental-history" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i> Riwayat Sewa
                    </a>
                    <a href="#documents" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i> Dokumen Saya
                    </a>
                    <a href="#preferences" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>

            <!-- Membership Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-3">Status Membership</h6>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-crown text-warning me-2 fa-2x"></i>
                        <div>
                            <h6 class="mb-0">Regular Member</h6>
                            <small class="text-muted">5 sewa lagi menuju Gold</small>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Profile Information -->
            <div class="card shadow-sm mb-4" id="profile-info">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? Auth::user()->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ old('email', $user->email ?? Auth::user()->email) }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon</label>
                                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? Auth::user()->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. KTP</label>
                                <input type="text" name="ktp" class="form-control" value="{{ old('ktp', $user->ktp ?? Auth::user()->ktp) }}" placeholder="Masukkan nomor KTP">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address ?? Auth::user()->address) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Profil (avatar)</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Rental History -->
            <div class="card shadow-sm mb-4" id="rental-history">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Riwayat Sewa</h5>
                    <div class="btn-group">
                        <button class="btn btn-outline-primary btn-sm">Semua</button>
                        <button class="btn btn-outline-primary btn-sm">Aktif</button>
                        <button class="btn btn-outline-primary btn-sm">Selesai</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Example rental history items -->
                        <div class="rental-item mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Honda CBR250RR</h6>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-calendar me-1"></i> 25 Oct 2025 - 27 Oct 2025
                                        <span class="badge bg-success ms-2">Selesai</span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-1">Rp 1.500.000</h6>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                                </div>
                            </div>
                        </div>

                        <div class="rental-item mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Yamaha R6</h6>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-calendar me-1"></i> 20 Oct 2025 - 22 Oct 2025
                                        <span class="badge bg-success ms-2">Selesai</span>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-1">Rp 1.350.000</h6>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="card shadow-sm mb-4" id="documents">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Dokumen Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="document-item p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">KTP</h6>
                                        <p class="text-muted mb-0 small">Format: JPG, PNG, PDF (Max 2MB)</p>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="document-item p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">SIM</h6>
                                        <p class="text-muted mb-0 small">Format: JPG, PNG, PDF (Max 2MB)</p>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="card shadow-sm mb-4" id="preferences">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Pengaturan</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Notifikasi</h6>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                            <label class="form-check-label" for="emailNotif">Email Notifikasi</label>
                        </div>
                        <small class="text-muted">Terima email untuk pembaruan status sewa dan promo</small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="whatsappNotif" checked>
                            <label class="form-check-label" for="whatsappNotif">WhatsApp Notifikasi</label>
                        </div>
                        <small class="text-muted">Terima notifikasi WhatsApp untuk pembaruan status sewa</small>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Keamanan</h6>
                    <div class="mb-3">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-lock me-2"></i>Ubah Password
                        </button>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="twoFactor">
                            <label class="form-check-label" for="twoFactor">Verifikasi 2 Langkah</label>
                        </div>
                        <small class="text-muted">Tingkatkan keamanan akun dengan verifikasi tambahan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.rental-item {
    border-left: 3px solid #2ed573;
    padding-left: 15px;
}

.rental-item:hover {
    background-color: #f8f9fa;
}

.default-avatar {
    font-family: Arial, sans-serif;
}

.document-item {
    transition: all 0.3s;
}

.document-item:hover {
    background-color: #f8f9fa;
}

.timeline {
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}
</style>
@endpush
