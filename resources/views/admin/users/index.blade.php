@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <h2>Users</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Tambah User</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>KYC</th>
                    <th>Dokumen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                        @if($u->ktp_photo && $u->simc_photo)
                            <span class="badge {{ $u->kyc_verified_at ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $u->kyc_verified_at ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum Lengkap</span>
                        @endif
                    </td>
                    <td>
                        @if($u->ktp_photo)
                            <img src="{{ asset($u->ktp_photo) }}" alt="KTP" style="height:40px;" class="me-1 rounded border">
                        @endif
                        @if($u->simc_photo)
                            <img src="{{ asset($u->simc_photo) }}" alt="SIM C" style="height:40px;" class="rounded border">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-secondary">Edit</a>
                        @if($u->ktp_photo && $u->simc_photo && !$u->kyc_verified_at)
                            <form action="{{ route('admin.users.kyc.verify', $u) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Verifikasi KYC pengguna ini?')">Verifikasi</button>
                            </form>
                        @elseif($u->kyc_verified_at)
                            <form action="{{ route('admin.users.kyc.revoke', $u) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Cabut verifikasi KYC pengguna ini?')">Cabut</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


