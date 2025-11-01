@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="catalog-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <h1 class="hero-title">Motor Balap</h1>
                <p class="hero-subtitle">Pilih motor balap profesional untuk pengalaman berkendara yang mendebarkan</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-card">
                <!-- Search Form -->
                <div class="search-form mb-3">
                    <form action="{{ route('motor.search') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari motor..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>

                <div class="filter-header">
                    <i class="fas fa-filter me-2"></i>
                    <span>Filter Kategori:</span>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('motor.motorbalap') }}" class="filter-btn {{ !isset($category) ? 'active' : '' }}">
                        <i class="fas fa-th me-2"></i>Semua
                    </a>
                    <a href="{{ route('motor.category', ['category' => 'balap']) }}" class="filter-btn filter-balap {{ isset($category) && $category == 'balap' ? 'active' : '' }}">
                        <i class="fas fa-flag-checkered me-2"></i>Motor Balap
                    </a>
                    <a href="{{ route('motor.category', ['category' => 'normal']) }}" class="filter-btn filter-normal {{ isset($category) && $category == 'normal' ? 'active' : '' }}">
                        <i class="fas fa-motorcycle me-2"></i>Motor Normal
                    </a>
                    <!-- show variant buttons when Normal is selected -->
                    @if(isset($category) && $category == 'normal')
                        <div class="mt-2">
                            <a href="{{ route('motor.normal.variant', ['variant' => 'matic']) }}" class="filter-btn ms-1 {{ isset($variant) && $variant == 'matic' ? 'active' : '' }}">Matic</a>
                            <a href="{{ route('motor.normal.variant', ['variant' => 'sport']) }}" class="filter-btn ms-1 {{ isset($variant) && $variant == 'sport' ? 'active' : '' }}">Sport</a>
                            <a href="{{ route('motor.normal.variant', ['variant' => 'bebek']) }}" class="filter-btn ms-1 {{ isset($variant) && $variant == 'bebek' ? 'active' : '' }}">Bebek</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
    <section class="catalog-section">
        <div class="container">
            @php
                $categoryLabel = isset($category) ? ucfirst($category) : 'Semua Kategori';
            @endphp

            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-motorcycle me-2"></i>
                    Menampilkan: {{ $categoryLabel }}
                </h2>
                <p class="section-subtitle">{{ $motors->count() }} motor ditemukan</p>
            </div>

            <div class="row g-4">
                @foreach ($motors as $motor)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card">
                            <div class="product-badge">
                                @php
                                    $label = $motor->category;
                                    if (str_starts_with($motor->category, 'normal-')) {
                                        $variant = substr($motor->category, strlen('normal-'));
                                        $label = 'Normal - ' . ucfirst($variant);
                                    } else {
                                        $label = ucfirst($motor->category);
                                    }
                                @endphp
                                <span class="badge badge-{{ $motor->category }}">{{ $label }}</span>
                                <span class="badge {{ $motor->stock > 0 ? 'bg-success' : 'bg-secondary' }}">
                                    Stok: {{ $motor->stock }}
                                </span>
                            </div>
                            
                            <div class="product-image">
                                <img src="{{ asset($motor->image) }}" alt="{{ $motor->name }}" class="img-fluid">
                                <div class="product-overlay">
                                    <button class="btn-quick-view" data-bs-toggle="modal" data-bs-target="#motorModal{{ $motor->id }}">
                                        <i class="fas fa-eye me-2"></i>Quick View
                                    </button>
                                </div>
                            </div>

                            <div class="product-body">
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="rating-count">(4.5)</span>
                                </div>

                                <h3 class="product-title">{{ $motor->name }}</h3>
                                
                                <div class="product-description">
                                    <p>{{ $motor->description }}</p>
                                </div>

                                <div class="product-price">
                                    <span class="price-label">Harga Sewa</span>
                                    <span class="price-value">Rp {{ number_format($motor->price_per_day, 0, ',', '.') }}</span>
                                    <span class="price-period">/hari</span>
                                </div>

                                <div class="product-actions d-flex gap-2">
                                    @if($motor->stock > 0)
                                        {{-- Add to cart form --}}
                                        <form method="POST" action="{{ route('cart.add') }}" class="d-inline-block">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $motor->id }}">
                                            <input type="hidden" name="type" value="motor">
                                            <input type="hidden" name="name" value="{{ $motor->name }}">
                                            <input type="hidden" name="price" value="{{ $motor->price_per_day }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="btn btn-outline-primary btn-cart" title="Tambah ke keranjang">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </form>

                                        {{-- Sewa Sekarang --}}
                                        <form method="POST" action="{{ route('cart.add') }}" class="d-inline-block flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $motor->id }}">
                                            <input type="hidden" name="type" value="motor">
                                            <input type="hidden" name="name" value="{{ $motor->name }}">
                                            <input type="hidden" name="price" value="{{ $motor->price_per_day }}">
                                            <input type="hidden" name="qty" value="1">
                                            <input type="hidden" name="redirect" value="keranjang">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-motorcycle me-2"></i>Sewa Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-ban me-2"></i>Stok Habis
                                        </button>
                                    @endif

                                    {{-- Wishlist button --}}
                                    <button class="btn btn-outline-danger btn-wishlist">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection