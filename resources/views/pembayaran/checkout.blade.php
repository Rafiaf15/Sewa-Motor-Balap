@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')

    <section class="catalog-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card p-3">
                        <h4 class="mb-3">Metode Pembayaran</h4>
                        <form method="POST" action="{{ route('pembayaran.pay') }}">
                            @csrf
                            <div class="list-group">
                                @foreach($methods as $method)
                                    <label class="list-group-item d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="radio" name="payment_method" value="{{ $method['code'] }}" {{ $loop->first ? 'checked' : '' }}>
                                        <img src="{{ asset($method['logo']) }}" alt="{{ $method['name'] }}" style="height:24px;width:auto;">
                                        <span>{{ $method['name'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted">Total Tagihan</div>
                                    <div class="fs-5 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</div>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>Lanjut ke Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
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


