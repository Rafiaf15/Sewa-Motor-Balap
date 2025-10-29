@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <h2>Tambah Kategori</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-select" required>
                <option value="motor">Motor</option>
                <option value="joki">Joki</option>
            </select>
            @error('type')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
@endsection


