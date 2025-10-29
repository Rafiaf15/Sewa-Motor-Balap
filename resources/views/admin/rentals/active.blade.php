@extends('layouts.admin')

@section('title', 'Sewa Aktif')

@section('content')
<div class="container-fluid">
    <h2>Unit Dipinjam (Aktif)</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>User</th>
                <th>Item</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Tanggal Mulai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->order_code }}</td>
                <td>{{ $o->user?->name }}</td>
                <td>{{ $o->item_name }}</td>
                <td>{{ strtoupper($o->item_type) }}</td>
                <td>{{ strtoupper($o->status) }}</td>
                <td>{{ optional($o->start_date)->format('Y-m-d') }}</td>
                <td>
                    <form action="{{ route('admin.rentals.return', $o) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success" onclick="return confirm('Proses pengembalian?')">Kembalikan</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection


