<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Sewa Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-motorcycle"></i>
                Sewa Motor Balap
            </a>
        </div>
    </nav>

    <!-- Verify Email Section -->
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="auth-header">
                            <div class="auth-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h2 class="auth-title">Verifikasi Email Anda</h2>
                            <p class="auth-subtitle">Kami telah mengirimkan link verifikasi ke email Anda</p>
                        </div>

                        <div class="auth-body">
                            @if (session('resent'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>Link verifikasi baru telah dikirim ke alamat email Anda.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="text-center mb-4">
                                <div class="alert alert-info">
                                    <i class="fas fa-envelope-open-text me-2"></i>
                                    <strong>Email verifikasi telah dikirim!</strong>
                                    <p class="mb-0 mt-2">Silakan periksa kotak masuk email Anda dan klik link verifikasi yang telah kami kirim.</p>
                                    <p class="mb-0 mt-2"><strong>Setelah klik link verifikasi, silakan login kembali dengan akun yang sudah dibuat.</strong></p>
                                </div>
                            </div>

                            @auth
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-auth btn-primary w-100 mb-3">
                                        <i class="fas fa-envelope me-2"></i>Kirim Ulang Email Verifikasi
                                    </button>
                                </form>

                                <div class="auth-divider">
                                    <span>atau</span>
                                </div>
                            @endauth

                            <div class="auth-footer">
                                <p>
                                    <a href="{{ route('login') }}" class="auth-link">
                                        <i class="fas fa-sign-in-alt me-2"></i>Kembali ke Login
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="back-home">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
