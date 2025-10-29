@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')

    <section class="catalog-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card p-3">
                        <h4 class="mb-3">Instruksi Pembayaran</h4>
                        <p class="mb-1"><strong>Metode:</strong> {{ strtoupper(str_replace('_', ' ', $payment['method'])) }}</p>
                        <p class="mb-1"><strong>Kode Pesanan:</strong> {{ $payment['order_code'] }}</p>
                        <p class="mb-3"><strong>Total:</strong> Rp {{ number_format($payment['amount'], 0, ',', '.') }}</p>

                        <div class="alert alert-info">
                            {{ $payment['instructions'] }}
                        </div>

                        <form method="POST" action="{{ route('pembayaran.complete') }}" class="mt-3 d-flex gap-2">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Selesaikan Pembayaran
                            </button>
                            <a href="{{ route('pembayaran.keranjang') }}" class="btn btn-outline-secondary">
                                Kembali ke Keranjang
                            </a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card p-3">
                        <h5 class="mb-3">Ringkasan Pesanan</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($cart as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $item['name'] }}</div>
                                        <small class="text-muted">Qty: {{ $item['qty'] ?? 1 }}</small>
                                    </div>
                                    <div>Rp {{ number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 0, ',', '.') }}</div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-3 d-flex justify-content-between">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


