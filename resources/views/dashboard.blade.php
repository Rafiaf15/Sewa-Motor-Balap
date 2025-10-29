@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 hero-content">
                    <h1 class="hero-title">Rental Motor Terpercaya & Terjangkau</h1>
                    <p class="hero-subtitle">
                        Solusi transportasi praktis untuk perjalanan Anda. Proses cepat, harga bersahabat, motor berkualitas.
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
                        <div class="stat-number"><i class="fas fa-users"></i> 500+</div>
                        <div class="stat-label">Pelanggan Puas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-motorcycle"></i> 50+</div>
                        <div class="stat-label">Motor Tersedia</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number"><i class="fas fa-map-marked-alt"></i> 10+</div>
                        <div class="stat-label">Lokasi Pickup</div>
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
            <p class="section-subtitle">Keunggulan layanan rental motor kami untuk kenyamanan Anda</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="feature-title">Proses Cepat</h3>
                        <p class="feature-text">
                            Booking online dalam hitungan menit. Sistem yang mudah dan tidak ribet untuk menghemat waktu Anda.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Motor Terawat</h3>
                        <p class="feature-text">
                            Semua motor melalui perawatan berkala dan inspeksi ketat untuk keamanan dan kenyamanan berkendara.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3 class="feature-title">Harga Terjangkau</h3>
                        <p class="feature-text">
                            Harga kompetitif dengan berbagai paket sewa harian, mingguan, atau bulanan yang hemat.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Support 24/7</h3>
                        <p class="feature-text">
                            Tim customer service kami siap membantu Anda kapanpun untuk pengalaman rental yang lancar.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="feature-title">Banyak Lokasi</h3>
                        <p class="feature-text">
                            Tersedia di berbagai lokasi strategis untuk kemudahan pickup dan return motor Anda.
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Booking Online</h3>
                        <p class="feature-text">
                            Platform digital yang user-friendly, booking motor dari mana saja dan kapan saja dengan mudah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2 class="section-title">Cara Sewa Motor</h2>
            <p class="section-subtitle">Ikuti 4 langkah mudah untuk menyewa motor impian Anda</p>
            
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="step-title">Daftar Akun</h4>
                        <p class="feature-text">Buat akun gratis dengan mengisi data diri Anda secara lengkap dan aman</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="step-title">Pilih Motor</h4>
                        <p class="feature-text">Browse koleksi motor kami dan pilih yang sesuai kebutuhan Anda</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="step-title">Lakukan Pembayaran</h4>
                        <p class="feature-text">Bayar dengan metode yang tersedia dan dapatkan konfirmasi booking</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4 class="step-title">Ambil Motor</h4>
                        <p class="feature-text">Datang ke lokasi pickup dan nikmati perjalanan Anda!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Siap Memulai Perjalanan Anda?</h2>
            <p class="cta-text">Daftar sekarang dan dapatkan promo menarik untuk pelanggan baru!</p>
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