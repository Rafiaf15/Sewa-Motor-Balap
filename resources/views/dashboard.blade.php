@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 hero-content">
                    <h1 class="hero-title">Sewa Motor Racing & Joki Racing</h1>
                    <p class="hero-subtitle">
                        Drag race atau sirkuit, pilih unit racing dan joki berpengalaman. Proses cepat, performa maksimal.
                    </p>
                    <div class="hero-buttons">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-hero btn-hero-primary">
                                <i class="fas fa-rocket me-2"></i>Dashboard
                            </a>
                        @endguest
                        <a href="#how-it-works" class="btn btn-hero btn-hero-secondary">
                            <i class="fas fa-play-circle me-2"></i>Cara Kerja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-flag-checkered"></i> 500+</div>
                        <div class="stat-label">Balapan Sukses</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-motorcycle"></i> 50+</div>
                        <div class="stat-label">Unit Racing</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-user-ninja"></i> 30+</div>
                        <div class="stat-label">Joki Racing</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-star"></i> 4.9</div>
                        <div class="stat-label">Rating Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Mengapa Pilih Kami?</h2>
            <p class="section-subtitle">Spesialis sewa motor racing dan joki drag/sirkuit</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Proses Cepat</h3>
                        <p class="feature-text">
                            Booking online kilat, siap gas di sirkuit atau trek drag.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Unit Terawat</h3>
                        <p class="feature-text">
                            Setup racing dirawat rutin untuk performa dan keamanan.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="feature-title">Harga Kompetitif</h3>
                        <p class="feature-text">
                            Paket drag dan sirkuit yang fleksibel sesuai kebutuhan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2 class="section-title">Cara Sewa</h2>
            <p class="section-subtitle">Empat langkah untuk siap balapan</p>
            
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="step-title">Daftar</h4>
                        <p class="feature-text">Buat akun dan lengkapi verifikasi identitas</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="step-title">Pilih Racing</h4>
                        <p class="feature-text">Motor racing dan/atau joki drag/sirkuit</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="step-title">Bayar</h4>
                        <p class="feature-text">Selesaikan pembayaran sesuai paket</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4 class="step-title">Gas!</h4>
                        <p class="feature-text">Ambil unit dan siap turun lintasan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Siap Turun Lintasan?</h2>
            <p class="cta-text">Daftar sekarang dan pilih paket racing Anda.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-hero btn-hero-primary">
                    <i class="fas fa-user-plus me-2"></i>Daftar Gratis
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-hero btn-hero-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Ke Dashboard
                </a>
            @endguest
        </div>
    </section>

@endsection