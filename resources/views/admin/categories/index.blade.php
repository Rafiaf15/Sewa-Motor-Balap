@extends('layouts.admin')

@section('title', 'Joki')

@section('content')
<div class="container-fluid">
    <h2>Daftar Joki</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga/Hari</th>
                <th>Tersedia</th>
            </tr>
        </thead>
        <tbody>
        @foreach(($jokis ?? []) as $j)
            <tr>
                <td>{{ $j->name }}</td>
                <td>{{ ucfirst($j->category) }}</td>
                <td>{{ number_format($j->price_per_day ?? 0,0,',','.') }}</td>
                <td>
                    <span class="badge {{ ($j->available ?? false) ? 'bg-success' : 'bg-secondary' }}">
                        {{ ($j->available ?? false) ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection


