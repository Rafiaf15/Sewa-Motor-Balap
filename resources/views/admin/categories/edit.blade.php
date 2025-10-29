@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <h2>Edit Kategori</h2>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select name="type" class="form-select" required>
                <option value="motor" @if($category->type==='motor') selected @endif>Motor</option>
                <option value="joki" @if($category->type==='joki') selected @endif>Joki</option>
            </select>
            @error('type')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
@endsection


