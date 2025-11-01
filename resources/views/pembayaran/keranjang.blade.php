@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')

    <!-- Cart Content -->
    <div class="cart-container">
        <div class="container">
            @auth
                @php
                    $cart = session('cart', []);
                @endphp

                <!-- Page Header -->
                <div class="cart-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <h1 class="header-title">Keranjang Belanja</h1>
                            <p class="header-subtitle">
                                @if(empty($cart))
                                    Keranjang Anda kosong
                                @else
                                    {{ count($cart) }} item dalam keranjang
                                @endif
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('motor.motorbalap') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Item
                    </a>
                </div>

                @if(empty($cart))
                    <!-- Empty Cart -->
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="empty-cart-title">Keranjang Anda Masih Kosong</h3>
                        <p class="empty-cart-text">Mulai belanja dan tambahkan item ke keranjang Anda</p>
                        <div class="empty-cart-actions">
                            <a href="{{ route('motor.motorbalap') }}" class="btn btn-primary">
                                <i class="fas fa-motorcycle me-2"></i>Lihat Motor Balap
                            </a>
                            <a href="{{ route('joki.penjoki') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-ninja me-2"></i>Lihat Joki
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Cart Items -->
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="cart-items-container">
                                @php $total = 0; $totalFine = 0; @endphp
                                @foreach($cart as $key => $item)
                                    @php
                                        $duration = $item['qty'] ?? 1;
                                        $basePrice = ($item['price'] ?? 0) * $duration;
                                        $fine = 0;
                                        if ($duration > 5) {
                                            $fine = 2 * ($item['price'] ?? 0) * ($duration - 5);
                                        }
                                        $subtotal = $basePrice + $fine;
                                        $total += $basePrice;
                                        $totalFine += $fine;
                                    @endphp
                                    <div class="cart-item">
                                        <div class="cart-item-image">
                                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/150x100?text=Product' }}" alt="{{ $item['name'] ?? 'Product' }}">
                                            <div class="cart-item-badge">
                                                <span class="badge badge-{{ $item['category'] ?? 'primary' }}">
                                                    {{ ucfirst($item['category'] ?? 'Item') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="cart-item-details">
                                            <h4 class="cart-item-title">{{ $item['name'] ?? 'Product Name' }}</h4>
                                            <p class="cart-item-type">
                                                <i class="fas fa-{{ $item['type'] == 'joki' ? 'user-ninja' : 'motorcycle' }} me-2"></i>
                                                {{ ucfirst($item['type'] ?? 'motor') }}
                                            </p>
                                            <div class="cart-item-specs">
                                                @if(isset($item['specs']))
                                                    @foreach($item['specs'] as $spec)
                                                        <span class="spec-tag">{{ $spec }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="cart-item-actions">
                                            <div class="duration-control">
                                                <label class="form-label">Durasi Sewa (hari)</label>
                                                <input type="number" class="form-control" value="{{ $item['qty'] ?? 1 }}" min="1" max="10" onchange="updateDuration('{{ $key }}', this.value)">
                                                @if(($item['qty'] ?? 1) > 5)
                                                    <small class="text-danger">Maksimal 5 hari, denda 2x untuk hari tambahan</small>
                                                @endif
                                            </div>

                                            <div class="cart-item-price">
                                                <span class="price-label">Harga Satuan</span>
                                                <span class="price-value">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}/hari</span>
                                            </div>

                                            <div class="cart-item-subtotal">
                                                @php
                                                    $duration = $item['qty'] ?? 1;
                                                    $basePrice = ($item['price'] ?? 0) * $duration;
                                                    $fine = 0;
                                                    if ($duration > 5) {
                                                        $fine = 2 * ($item['price'] ?? 0) * ($duration - 5);
                                                    }
                                                    $totalPrice = $basePrice + $fine;
                                                @endphp
                                                <span class="subtotal-label">Subtotal</span>
                                                <span class="subtotal-value">Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                                                @if($fine > 0)
                                                    <span class="subtotal-label">Denda</span>
                                                    <span class="subtotal-value text-danger">Rp {{ number_format($fine, 0, ',', '.') }}</span>
                                                @endif
                                                <span class="subtotal-label fw-bold">Total</span>
                                                <span class="subtotal-value fw-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                            </div>

                                            <button class="btn-remove" onclick="removeItem('{{ $key }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Continue Shopping -->
                            <div class="continue-shopping">
                                <a href="{{ route('motor.motorbalap') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button class="btn btn-outline-danger" onclick="clearCart()">
                                    <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                                </button>
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div class="col-lg-4">
                            <div class="cart-summary">
                                <h3 class="summary-title">
                                    <i class="fas fa-receipt me-2"></i>Ringkasan Belanja
                                </h3>

                                <div class="summary-content">
                                    <div class="summary-row">
                                        <span>Subtotal ({{ count($cart) }} item)</span>
                                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>

                                    @if($totalFine > 0)
                                    <div class="summary-row">
                                        <span>Total Denda</span>
                                        <span class="text-danger">Rp {{ number_format($totalFine, 0, ',', '.') }}</span>
                                    </div>
                                    @endif

                                    <div class="summary-row">
                                        <span>Biaya Admin</span>
                                        <span>Rp 5.000</span>
                                    </div>

                                    <div class="summary-row">
                                        <span>Asuransi</span>
                                        <span>Rp {{ number_format($total * 0.01, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="summary-divider"></div>

                                    <div class="summary-row summary-total">
                                        <span>Total Pembayaran</span>
                                        <span>Rp {{ number_format($total + $totalFine + 5000 + ($total * 0.01), 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="promo-code">
                                    <input type="text" class="form-control" placeholder="Masukkan kode promo">
                                    <button class="btn btn-secondary">Terapkan</button>
                                </div>

                                <form method="POST" action="{{ route('pembayaran.pay') }}" class="mt-3">
                                    @csrf
                                    <div class="mb-2">
                                        <p class="payment-label mb-2">Metode Pembayaran</p>
                                        <div class="list-group">
                                            <label class="list-group-item d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_method" value="va_mandiri" checked>
                                                <span>Mandiri Virtual Account</span>
                                            </label>
                                            <label class="list-group-item d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_method" value="va_bca">
                                                <span>BCA Virtual Account</span>
                                            </label>
                                            <label class="list-group-item d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_method" value="retail_alfamart">
                                                <span>Alfamart / Alfamidi / Lawson / Dan+Dan</span>
                                            </label>
                                            <label class="list-group-item d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="payment_method" value="va_bri">
                                                <span>BRI Virtual Account</span>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-checkout w-100">
                                        <i class="fas fa-credit-card me-2"></i>Lanjut ke Pembayaran
                                    </button>
                                </form>

                                <div class="secure-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Transaksi Aman & Terpercaya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Not Authenticated -->
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="empty-cart-title">Login Diperlukan</h3>
                    <p class="empty-cart-text">Anda harus login terlebih dahulu untuk melihat keranjang</p>
                    <div class="empty-cart-actions">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Daftar Akun
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function updateDuration(key, value) {
            // AJAX call to update duration
            console.log('Update duration for item:', key, 'to:', value);
            // You'll need to implement the backend route for this
            // For now, just reload the page to recalculate
            location.reload();
        }

        function removeItem(key) {
            if (confirm('Hapus item dari keranjang?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cart.remove") }}';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const keyInput = document.createElement('input');
                keyInput.type = 'hidden';
                keyInput.name = 'key';
                keyInput.value = key;
                form.appendChild(keyInput);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function clearCart() {
            if (confirm('Kosongkan seluruh keranjang?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cart.clear") }}';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush