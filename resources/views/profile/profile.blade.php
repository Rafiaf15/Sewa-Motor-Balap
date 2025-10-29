@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img class="rounded-circle mb-2" src="{{ $user->avatar ? asset($user->avatar) : 'https://via.placeholder.com/120x120?text=Avatar' }}" width="120" height="120" alt="Avatar">
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
