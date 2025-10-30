<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->reduce(function ($carry, $item) {
            $price = (float)($item['price'] ?? 0);
            $qty = (int)($item['qty'] ?? 1);
            return $carry + ($price * $qty);
        }, 0.0);

        $methods = [
            [
                'code' => 'va_mandiri',
                'name' => 'Mandiri Virtual Account',
                'logo' => 'build/assets/image/payments/mandiri.png',
            ],
            [
                'code' => 'va_bca',
                'name' => 'BCA Virtual Account',
                'logo' => 'build/assets/image/payments/bca.png',
            ],
            [
                'code' => 'retail_alfamart',
                'name' => 'Alfamart / Alfamidi / Lawson / Dan+Dan',
                'logo' => 'build/assets/image/payments/alfamart.png',
            ],
            [
                'code' => 'va_bri',
                'name' => 'BRI Virtual Account',
                'logo' => 'build/assets/image/payments/bri.png',
            ],
        ];

        return view('pembayaran.checkout', compact('cart', 'total', 'methods'));
    }

    public function pay(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pembayaran.keranjang')->with('error', 'Keranjang kosong.');
        }

        $total = collect($cart)->reduce(function ($carry, $item) {
            $price = (float)($item['price'] ?? 0);
            $qty = (int)($item['qty'] ?? 1);
            return $carry + ($price * $qty);
        }, 0.0);

        // Simpan payment method ke session untuk digunakan saat complete
        $request->session()->put('payment_method', $data['payment_method']);
        
        // Simulasikan pembuatan instruksi pembayaran (tanpa gateway dulu)
        $payment = [
            'method' => $data['payment_method'],
            'amount' => $total,
            'order_code' => 'INV-' . strtoupper(uniqid()),
            'instructions' => match ($data['payment_method']) {
                'va_mandiri' => 'Bayar ke Mandiri VA yang akan dikirim setelah konfirmasi.',
                'va_bca' => 'Bayar ke BCA VA yang akan dikirim setelah konfirmasi.',
                'va_bri' => 'Bayar ke BRI VA yang akan dikirim setelah konfirmasi.',
                'retail_alfamart' => 'Bayar di kasir Alfamart dengan menunjukkan kode bayar.',
                default => 'Ikuti instruksi pada layar.',
            },
        ];

        // Arahkan ke halaman ringkasan pembayaran
        return view('pembayaran.pembayaran', [
            'cart' => $cart,
            'total' => $total,
            'payment' => $payment,
        ]);
    }

    public function complete(Request $request)
    {
        // Di implementasi nyata, validasi status pembayaran dari gateway terlebih dahulu.
        // Untuk simulasi: anggap pembayaran berhasil dan simpan order ke DB.
        
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pembayaran.keranjang')->with('error', 'Keranjang kosong.');
        }

        $userId = auth()->id();
        // Ambil payment_method dari session atau request
        $paymentMethod = $request->session()->get('payment_method', 'va_mandiri');
        
        // Simpan setiap item di cart sebagai order terpisah
        foreach ($cart as $item) {
            \App\Models\Order::create([
                'user_id' => $userId,
                'order_code' => 'INV-' . strtoupper(uniqid()),
                'item_type' => $item['type'],
                'item_id' => $item['id'],
                'item_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['qty'] ?? 1,
                'total_amount' => ($item['price'] ?? 0) * ($item['qty'] ?? 1),
                'payment_method' => $paymentMethod,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays(7), // Default 7 hari sewa
            ]);

            // Decrease stock when rented
            if (($item['type'] ?? null) === 'motor') {
                if ($motor = \App\Models\Motor::find($item['id'])) {
                    $motor->decrement('stock', $item['qty'] ?? 1);
                }
            } elseif (($item['type'] ?? null) === 'joki') {
                if ($joki = \App\Models\Joki::find($item['id'])) {
                    $joki->decrement('available', $item['qty'] ?? 1); // Assuming joki has available field
                }
            }
        }

        // Kosongkan keranjang
        $request->session()->forget('cart');
        if (auth()->check()) {
            \App\Models\Cart::where('user_id', $userId)->delete();
        }

        return view('pembayaran.sukses');
    }
}


