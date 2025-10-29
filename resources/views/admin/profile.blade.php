@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<div class="container-fluid py-2">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Profil Admin & Verifikasi</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. KTP</label>
                        <input type="text" name="ktp" class="form-control" value="{{ old('ktp', $user->ktp) }}" placeholder="Masukkan nomor KTP">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Profil (avatar)</label>
                    <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg">
                    <small class="text-muted">Hanya JPG/PNG</small>
                </div>

                <button class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>
@endsection
