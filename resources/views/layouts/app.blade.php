<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Motor - Rental Motor Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-motorcycle"></i>
                Sewa Motor Balap
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('motor.motorbalap') }}">Motor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('joki.penjoki') }}">Joki</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pembayaran.keranjang') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user me-2"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pembayaran.keranjang') }}">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-login" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-register" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-title">
                        <i class="fas fa-motorcycle me-2"></i>Sewa Motor
                    </h5>
                    <p style="color: rgba(255, 255, 255, 0.7);">
                        Platform rental motor terpercaya yang menyediakan berbagai pilihan motor dengan harga terjangkau dan layanan terbaik.
                    </p>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Menu</h5>
                    <a href="{{ url('/') }}" class="footer-link">Beranda</a>
                    <a href="#features" class="footer-link">Fitur</a>
                    <a href="#how-it-works" class="footer-link">Cara Kerja</a>
                    <a href="#" class="footer-link">Tentang Kami</a>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5 class="footer-title">Layanan</h5>
                    <a href="#" class="footer-link">Rental Harian</a>
                    <a href="#" class="footer-link">Rental Mingguan</a>
                    <a href="#" class="footer-link">Rental Bulanan</a>
                    <a href="#" class="footer-link">Corporate</a>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <p style="color: rgba(255, 255, 255, 0.7);">
                        <i class="fas fa-map-marker-alt me-2"></i>Bandung, Indonesia<br>
                        <i class="fas fa-phone me-2"></i>+62 812-3456-7890<br>
                        <i class="fas fa-envelope me-2"></i>info@sewamotor.com
                    </p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-0">&copy; 2024 Sewa Motor. All Rights Reserved. | Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>