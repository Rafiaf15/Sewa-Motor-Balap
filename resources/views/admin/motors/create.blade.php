@extends('layouts.admin')

@section('title', 'Tambah Unit')

@section('content')
<div class="container-fluid">
    <h2>Tambah Unit</h2>
    <form action="{{ route('admin.motors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input name="slug" class="form-control" value="{{ old('slug') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input name="category" class="form-control" value="{{ old('category') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga per Hari</label>
            <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar (path/URL)</label>
            <input name="image" class="form-control" value="{{ old('image') }}">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="available" class="form-check-input" id="avail" checked>
            <label class="form-check-label" for="avail">Tersedia</label>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.motors.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection


