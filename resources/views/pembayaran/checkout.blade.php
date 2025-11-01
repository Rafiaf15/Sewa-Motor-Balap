@extends('layouts.app')

{{-- Include Midtrans Snap JS Library --}}
@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Ringkasan Pesanan</h4>
                </div>
                <div class="card-body">
                    {{-- Display order summary here --}}
                    <p>Total Pembayaran: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                    <hr>
                    <button id="pay-button" class="btn btn-primary w-100">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Find the pay button
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger Snap popup
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                // alert("payment success!");
                window.location.href = '{{ route("dashboard") }}?payment_status=success';
            },
            onPending: function(result){
                /* You may add your own implementation here */
                // alert("wating your payment!");
                window.location.href = '{{ route("dashboard") }}?payment_status=pending';
            },
            onError: function(result){
                /* You may add your own implementation here */
                // alert("payment failed!");
                window.location.href = '{{ route("dashboard") }}?payment_status=error';
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        })
    });
</script>
@endsection