@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @php
                        $avatarUrl = 'https://via.placeholder.com/120x120?text=Avatar'; // Fallback
                        // Use user's avatar only if it exists and is NOT a full URL (i.e., it's a local path)
                        if ($user->avatar && !Illuminate\Support\Str::startsWith($user->avatar, 'http')) {
                            $avatarUrl = asset($user->avatar);
                        }
                    @endphp
                    <img class="rounded-circle mb-2" src="{{ $avatarUrl }}" width="120" height="120" alt="Avatar">
                    <div class="text-muted">{{ $user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Profile Information -->
            <div class="card shadow-sm mb-4" id="profile-info">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Informasi Profil & Verifikasi</h5>
                    @php
                        $hasPhone = !empty(trim($user->phone));
                        $hasKtp = !empty(trim($user->ktp));
                        $hasAddress = !empty(trim($user->address));
                        $hasKtpPhoto = !empty($user->ktp_photo);
                        $hasSimcPhoto = !empty($user->simc_photo);
                        $isVerified = !empty($user->kyc_verified_at);
                        $isPending = ($hasKtpPhoto && $hasSimcPhoto) && !$isVerified;
                        $isUnverified = (!$hasKtpPhoto || !$hasSimcPhoto) && !$isVerified;
                    @endphp
                    @if($hasPhone && $hasKtp && $hasAddress && $isVerified)
                        <span class="badge bg-success ms-2">Akun Terverifikasi</span>
                    @elseif($isPending)
                        <span class="badge bg-warning ms-2">Sedang Diverifikasi</span>
                    @else
                        <span class="badge bg-danger ms-2">Belum Verifikasi</span>
                    @endif
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-semibold mb-1">Perbaiki kesalahan berikut:</div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                                <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone ?? Auth::user()->phone) }}" pattern="[0-9+\-\s()]+" title="Hanya angka, spasi, tanda plus, minus, dan kurung yang diperbolehkan (10-12 digit)" minlength="10" maxlength="12" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIK / No. KTP <span class="text-danger">*</span></label>
                                <input type="text" name="ktp" class="form-control @error('ktp') is-invalid @enderror" value="{{ old('ktp', $user->ktp ?? Auth::user()->ktp) }}" placeholder="Masukkan nomor KTP (16 digit)" pattern="[0-9]+" title="Hanya angka yang diperbolehkan (16 digit)" minlength="16" maxlength="16" required>
                                @error('ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $user->address ?? Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Profil (avatar)</label>
                            <input type="file" name="avatar" class="form-control" accept="image/png,image/jpeg">
                            <small class="text-muted">Hanya JPG/PNG</small>
                        </div>

                        <hr>
                        <h6 class="mb-3">Verifikasi Identitas</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Foto KTP</label>
                                <input type="file" name="ktp_photo" class="form-control" accept="image/png,image/jpeg">
                                @if($user->ktp_photo)
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset($user->ktp_photo) }}" alt="KTP" class="img-thumbnail" style="max-height: 140px;">
                                        <form method="POST" action="{{ route('profile.kyc.ktp.delete') }}">
                                            @csrf
                                            <button class="btn btn-outline-danger" onclick="return confirm('Hapus foto KTP? Verifikasi akan dicabut.')">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto SIM C</label>
                                <input type="file" name="simc_photo" class="form-control" accept="image/png,image/jpeg">
                                @if($user->simc_photo)
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset($user->simc_photo) }}" alt="SIM C" class="img-thumbnail" style="max-height: 140px;">
                                        <form method="POST" action="{{ route('profile.kyc.simc.delete') }}">
                                            @csrf
                                            <button class="btn btn-outline-danger" onclick="return confirm('Hapus foto SIM C? Verifikasi akan dicabut.')">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Hanya JPG/PNG. Wajib unggah foto KTP & SIM C yang jelas sebelum melakukan penyewaan.</small>
                        </div>

                        <button class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Riwayat Penyewaan -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Riwayat Penyewaan Saya</h5>
                </div>
                <div class="card-body">
                    @if(($orders ?? collect())->isEmpty())
                        <div class="text-muted">Belum ada riwayat penyewaan.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Item</th>
                                        <th>Tipe</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $o)
                                        <tr>
                                            <td>{{ $o->order_code }}</td>
                                            <td>{{ $o->item_name }}</td>
                                            <td>{{ strtoupper($o->item_type) }}</td>
                                            <td>{{ number_format($o->total_amount,0,',','.') }}</td>
                                            <td>{{ strtoupper($o->status) }}</td>
                                            <td>{{ optional($o->start_date)->format('Y-m-d') }}</td>
                                            <td>{{ optional($o->end_date)->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection