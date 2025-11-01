<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Order;

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
                'code' => 'qris',
                'name' => 'QRIS',
                'logo' => 'build/assets/image/payments/qris.png',
            ],
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
                'code' => 'va_bri',
                'name' => 'BRI Virtual Account',
                'logo' => 'build/assets/image/payments/bri.png',
            ],
            [
                'code' => 'retail_alfamart',
                'name' => 'Alfamart / Alfamidi / Lawson / Dan+Dan',
                'logo' => 'build/assets/image/payments/alfamart.png',
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

        $userId = auth()->id();
        $orderCode = 'ORDER-' . strtoupper(uniqid());

        // Simpan order ke database dengan status pending
        $order = Order::create([
            'user_id' => $userId,
            'order_code' => $orderCode,
            'item_type' => 'multiple', // Multiple items in cart
            'item_id' => null,
            'item_name' => 'Multiple Items',
            'price' => 0, // Will be calculated from items
            'quantity' => count($cart),
            'total_amount' => $total,
            'payment_method' => $data['payment_method'],
            'status' => 'pending',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'midtrans_order_id' => $orderCode,
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Prepare transaction data for Midtrans
        $transactionDetails = [
            'order_id' => $orderCode,
            'gross_amount' => (int)$total,
        ];

        // Prepare customer data
        $customerDetails = [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone ?? '',
        ];

        // Prepare item details
        $itemDetails = [];
        foreach ($cart as $item) {
            $itemDetails[] = [
                'id' => $item['id'],
                'price' => (int)($item['price'] ?? 0),
                'quantity' => (int)($item['qty'] ?? 1),
                'name' => $item['name'],
            ];
        }

        // Prepare payment parameters
        $transactionParams = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        // Map payment method to Midtrans payment type
        $paymentTypeMap = [
            'qris' => 'qris',
            'va_mandiri' => 'bank_transfer',
            'va_bca' => 'bank_transfer',
            'va_bri' => 'bank_transfer',
            'retail_alfamart' => 'cstore',
        ];

        $paymentMethod = $data['payment_method'];
        if (isset($paymentTypeMap[$paymentMethod])) {
            if ($paymentTypeMap[$paymentMethod] === 'qris') {
                // QRIS - tidak perlu parameter tambahan
                $transactionParams['enabled_payments'] = ['qris'];
            } elseif ($paymentTypeMap[$paymentMethod] === 'bank_transfer') {
                $bank = str_replace('va_', '', $paymentMethod);
                $transactionParams['enabled_payments'] = ['bank_transfer'];
                $transactionParams['bank_transfer'] = [
                    'bank' => strtoupper($bank),
                ];
            } elseif ($paymentTypeMap[$paymentMethod] === 'cstore') {
                $store = str_replace('retail_', '', $paymentMethod);
                $transactionParams['enabled_payments'] = ['cstore'];
                $transactionParams['cstore'] = [
                    'store' => $store === 'alfamart' ? 'alfamart' : 'indomaret',
                ];
            }
        } else {
            // Default: enable all payment methods
            $transactionParams['enabled_payments'] = ['qris', 'bank_transfer', 'cstore', 'credit_card'];
        }

        try {
            // Generate Snap token
            $snapToken = Snap::getSnapToken($transactionParams);

            // Simpan snap token ke session untuk digunakan di view
            $request->session()->put('snap_token', $snapToken);
            $request->session()->put('order_id', $orderCode);
            $request->session()->put('payment_method', $data['payment_method']);

            return view('pembayaran.checkout', [
                'order' => $order,
                'cart' => $cart,
                'total' => $total,
                'snapToken' => $snapToken,
            ]);
        } catch (\Exception $e) {
            // Jika error, hapus order yang sudah dibuat
            $order->delete();
            
            return redirect()->route('pembayaran.checkout')
                ->with('error', 'Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
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


