@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h2>Edit User</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" pattern="[0-9+\-\s()]+" title="Hanya angka, spasi, tanda plus, minus, dan kurung yang diperbolehkan (10-12 digit)" minlength="10" maxlength="12">
        </div>
        <div class="mb-3">
            <label class="form-label">No. KTP <span class="text-danger">*</span></label>
            <input type="text" name="ktp" class="form-control" value="{{ old('ktp', $user->ktp) }}" pattern="[0-9]+" title="Hanya angka yang diperbolehkan (16 digit)" minlength="16" maxlength="16">
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user" @if($user->role==='user') selected @endif>User</option>
                <option value="admin" @if($user->role==='admin') selected @endif>Admin</option>
            </select>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
    </form>

    <hr>

    <h4>Verifikasi Identitas</h4>
    <div class="row g-3 align-items-start">
        <div class="col-md-6">
            <label class="form-label">Foto KTP</label>
            @if($user->ktp_photo)
                <img src="{{ asset($user->ktp_photo) }}" alt="KTP" class="img-thumbnail w-100" style="max-width:360px;">
            @else
                <div class="text-muted">Belum diunggah</div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label">Foto SIM C</label>
            @if($user->simc_photo)
                <img src="{{ asset($user->simc_photo) }}" alt="SIM C" class="img-thumbnail w-100" style="max-width:360px;">
            @else
                <div class="text-muted">Belum diunggah</div>
            @endif
        </div>
    </div>
    <div class="mt-3">
        @if($user->ktp_photo && $user->simc_photo && !$user->kyc_verified_at)
            <form action="{{ route('admin.users.kyc.verify', $user) }}" method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-success" onclick="return confirm('Verifikasi KYC pengguna ini?')">Verifikasi KYC</button>
            </form>
        @elseif($user->kyc_verified_at)
            <span class="badge bg-success me-2">Terverifikasi</span>
            <form action="{{ route('admin.users.kyc.revoke', $user) }}" method="POST" class="d-inline-block">
                @csrf
                <button class="btn btn-outline-danger" onclick="return confirm('Cabut verifikasi KYC pengguna ini?')">Cabut Verifikasi</button>
            </form>
        @else
            <span class="badge bg-secondary">Dokumen belum lengkap</span>
        @endif
    </div>
</div>
@endsection


