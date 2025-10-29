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
                    <i class="fas fa-user-ninja"></i>
                </div>
                <h1 class="hero-title">Joki Balap Profesional</h1>
                <p class="hero-subtitle">Sewa joki berpengalaman untuk memenangkan kompetisi balap Anda</p>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-card">
                <!-- Search Form -->
                <div class="search-form mb-3">
                    <form action="{{ route('joki.search') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari joki..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>

                <div class="filter-header">
                    <i class="fas fa-filter me-2"></i>
                    <span>Filter Kategori:</span>
                </div>
                <div class="filter-buttons">
                    <a href="{{ route('joki.penjoki') }}" class="filter-btn {{ !isset($category) ? 'active' : '' }}">
                        <i class="fas fa-th me-2"></i>Semua
                    </a>
                    <a href="{{ route('joki.category', ['category' => 'pemula']) }}" class="filter-btn filter-pemula {{ isset($category) && $category == 'pemula' ? 'active' : '' }}">
                        <i class="fas fa-star me-2"></i>Pemula
                    </a>
                    <a href="{{ route('joki.category', ['category' => 'menengah']) }}" class="filter-btn filter-menengah {{ isset($category) && $category == 'menengah' ? 'active' : '' }}">
                        <i class="fas fa-star-half-alt me-2"></i>Menengah
                    </a>
                    <a href="{{ route('joki.category', ['category' => 'expert']) }}" class="filter-btn filter-expert {{ isset($category) && $category == 'expert' ? 'active' : '' }}">
                        <i class="fas fa-trophy me-2"></i>Expert
                    </a>
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
                    <i class="fas fa-users me-2"></i>
                    Menampilkan: {{ $categoryLabel }}
                </h2>
                <p class="section-subtitle">{{ $jokis->count() }} joki ditemukan</p>
            </div>

            <div class="row g-4">
                @foreach ($jokis as $joki)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card joki-card">
                            <div class="product-badge">
                                <span class="badge badge-{{ $joki->category }}">{{ ucfirst($joki->category) }}</span>
                                <span class="badge {{ $joki->available ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $joki->available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            </div>
                            
                            <div class="product-image">
                                @if($joki->image)
                                    <img src="{{ asset($joki->image) }}" alt="{{ $joki->name }}" class="img-fluid" onerror="this.src='https://via.placeholder.com/600x400?text={{ urlencode($joki->name) }}'">
                                @else
                                    <img src="https://via.placeholder.com/600x400?text={{ urlencode($joki->name) }}" alt="{{ $joki->name }}" class="img-fluid">
                                @endif
                                <div class="product-overlay">
                                    <button class="btn-quick-view" data-bs-toggle="modal" data-bs-target="#jokiModal{{ $joki->id }}">
                                        <i class="fas fa-user me-2"></i>Lihat Profile
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

                                <h3 class="product-title">{{ $joki->name }}</h3>
                                
                                <div class="product-description">
                                    <p>{{ $joki->description }}</p>
                                </div>

                                <div class="product-price">
                                    <span class="price-label">Tarif Sewa</span>
                                    <span class="price-value">Rp {{ number_format($joki->price_per_day, 0, ',', '.') }}</span>
                                    <span class="price-period">/hari</span>
                                </div>

                                <div class="product-actions d-flex gap-2">
                                    @if($joki->available)
                                        {{-- Add to cart form --}}
                                        <form method="POST" action="{{ route('cart.add') }}" class="d-inline-block">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $joki->id }}">
                                            <input type="hidden" name="type" value="joki">
                                            <input type="hidden" name="name" value="{{ $joki->name }}">
                                            <input type="hidden" name="price" value="{{ $joki->price_per_day }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="btn btn-outline-primary btn-cart" title="Tambah ke keranjang">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </form>

                                        {{-- Sewa Sekarang --}}
                                        <form method="POST" action="{{ route('cart.add') }}" class="d-inline-block flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $joki->id }}">
                                            <input type="hidden" name="type" value="joki">
                                            <input type="hidden" name="name" value="{{ $joki->name }}">
                                            <input type="hidden" name="price" value="{{ $joki->price_per_day }}">
                                            <input type="hidden" name="qty" value="1">
                                            <input type="hidden" name="redirect" value="keranjang">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-handshake me-2"></i>Sewa Joki
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-ban me-2"></i>Tidak Tersedia
                                        </button>
                                    @endif

                                    {{-- Wishlist button --}}
                                    <button class="btn btn-outline-danger btn-wishlist">
                                        <i class="far fa-bookmark"></i>
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