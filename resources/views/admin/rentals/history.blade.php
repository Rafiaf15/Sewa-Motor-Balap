@extends('layouts.admin')

@section('title', 'Riwayat Penyewaan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Riwayat Peminjaman: {{ $user->name }}</h2>
        <button class="btn btn-outline-secondary" onclick="window.print()">Cetak</button>
    </div>

    <table class="table mt-3">
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
@endsection


