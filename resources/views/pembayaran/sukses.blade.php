@extends('layouts.app')

@section('content')

    <section class="catalog-section">
        <div class="container">
            <div class="card p-4 text-center">
                <div class="mb-3">
                    <i class="fas fa-check-circle" style="font-size:48px;color:#16a34a;"></i>
                </div>
                <h3 class="mb-2">Pembayaran Berhasil</h3>
                <p class="text-muted">Terima kasih, pesanan Anda telah kami terima.</p>
                <div class="mt-3 d-flex justify-content-center gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                    <a href="{{ route('motor.motorbalap') }}" class="btn btn-outline-primary">Lanjut Belanja</a>
                </div>
            </div>
        </div>
    </section>

@endsection


