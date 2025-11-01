<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Pastikan Anda memiliki model Order
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    /**
     * Handle Midtrans notification/webhook. 
     * 
     * STATUS TRANSAKSI MIDTRANS:
     * - 'pending': Pembayaran masih menunggu (belum dibayar)
     * - 'settlement': Pembayaran berhasil (uang sudah masuk)
     * - 'capture': Pembayaran dengan kartu kredit berhasil
     * - 'deny': Pembayaran ditolak
     * - 'expire': Pembayaran kadaluarsa
     * - 'cancel': Pembayaran dibatalkan
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notificationHandler(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // Buat instance notifikasi Midtrans
            // Midtrans mengirim data dalam bentuk POST body
            $notification = new Notification();

            // Ambil data notifikasi dari Midtrans
            $orderId = $notification->order_id; // Order ID yang kita kirim saat create transaction
            $transactionStatus = $notification->transaction_status; // Status pembayaran
            $fraudStatus = $notification->fraud_status; // Status fraud detection (untuk kartu kredit)
            $paymentType = $notification->payment_type; // Tipe pembayaran (qris, bank_transfer, dll)
            $grossAmount = $notification->gross_amount; // Total amount

            // Log notification untuk debugging (opsional)
            \Log::info('Midtrans Notification Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'gross_amount' => $grossAmount,
            ]);

            // Cari pesanan berdasarkan order_code atau midtrans_order_id
            $order = Order::where('order_code', $orderId)
                ->orWhere('midtrans_order_id', $orderId)
                ->first();

            if (!$order) {
                \Log::warning('Order not found for Midtrans notification', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Verifikasi signature key (direkomendasikan untuk keamanan)
            $signature = hash('sha512', $orderId . $notification->status_code . $grossAmount . Config::$serverKey);
            if ($notification->signature_key != $signature) {
                \Log::error('Invalid Midtrans signature', ['order_id' => $orderId]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Update status pesanan berdasarkan status transaksi Midtrans
            $oldStatus = $order->status;
            
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                // Pembayaran berhasil (settlement = untuk bank transfer/QRIS, capture = untuk kartu kredit)
                if ($transactionStatus == 'capture' && $fraudStatus != 'accept') {
                    // Untuk kartu kredit, cek fraud status
                    $order->status = 'pending'; // Tunggu verifikasi
                } else {
                    // Pembayaran berhasil dan aman
                    $order->status = 'paid';
                    
                    // Update availability untuk motor/joki yang sudah dibayar
                    // (jika order sudah dibuat sebelumnya dengan status pending)
                }
            } elseif ($transactionStatus == 'pending') {
                // Pembayaran masih menunggu (user belum bayar)
                $order->status = 'pending';
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Pembayaran ditolak, kadaluarsa, atau dibatalkan
                $order->status = 'cancelled';
                
                // Kembalikan stock/availability jika order dibatalkan
                // (jika diperlukan)
            }

            $order->save();

            // Log perubahan status
            if ($oldStatus != $order->status) {
                \Log::info('Order status updated', [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $order->status,
                    'midtrans_status' => $transactionStatus,
                ]);
            }

            // Beri respons ke Midtrans bahwa notifikasi telah diterima dengan sukses
            // Response 200 memberitahu Midtrans bahwa webhook berhasil diproses
            return response()->json([
                'message' => 'Notification handled successfully',
                'order_id' => $orderId,
                'status' => $order->status,
            ], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error handling Midtrans notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Tetap return 200 ke Midtrans agar tidak retry terus-menerus
            // Tapi log error untuk diperbaiki
            return response()->json([
                'message' => 'Error handling notification: ' . $e->getMessage()
            ], 200); // Tetap 200, tapi log error
        }
    }
}