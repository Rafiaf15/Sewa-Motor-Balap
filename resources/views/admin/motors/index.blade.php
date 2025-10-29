@extends('layouts.admin')

@section('title', 'Unit Motor')

@section('content')
<div class="container-fluid">
    <h2>Unit (Motor)</h2>
    <a href="{{ route('admin.motors.create') }}" class="btn btn-primary mb-3">Tambah Unit</a>
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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($motors as $m)
            <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->category }}</td>
                <td>{{ number_format($m->price_per_day,0,',','.') }}</td>
                <td>{{ $m->available ? 'Ya' : 'Tidak' }}</td>
                <td>
                    <a href="{{ route('admin.motors.edit', $m) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form action="{{ route('admin.motors.destroy', $m) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus unit?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection


