# Panduan URL Webhook Midtrans

## 1. URL Notifikasi di Aplikasi

**File**: `routes/api.php` (baris 22)

**Route**: `/api/midtrans/notification`

**URL Lengkap**:
- Production: `https://your-domain.com/api/midtrans/notification`
- Localhost (via ngrok): `https://xxxx-xx-xxx-xxx-xx.ngrok.io/api/midtrans/notification`

## 2. Cara Mendapatkan URL untuk Testing Lokal

### Langkah 1: Install ngrok

1. Download ngrok dari https://ngrok.com/
2. Extract file ngrok.exe ke folder yang mudah diakses
3. Atau install via package manager (choco, scoop, dll)

### Langkah 2: Jalankan Laravel

```bash
php artisan serve
# Laravel akan berjalan di http://127.0.0.1:8000
```

### Langkah 3: Expose dengan ngrok

Buka terminal baru dan jalankan:

```bash
ngrok http 8000
```

Output akan seperti ini:
```
ngrok                                                                                   

Session Status                online
Account                       Your Account (Plan: Free)
Version                       3.x.x
Region                        Asia Pacific (ap)
Latency                       45ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc123-def456.ngrok.io -> http://localhost:8000

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

### Langkah 4: Salin URL ngrok

Dari output di atas, salin URL `Forwarding`:
```
https://abc123-def456.ngrok.io
```

### Langkah 5: Buat URL Webhook Lengkap

Tambahkan `/api/midtrans/notification` di akhir:

```
https://abc123-def456.ngrok.io/api/midtrans/notification
```

**Catatan Penting**:
- URL ngrok akan berubah setiap kali ngrok di-restart
- Untuk production, gunakan domain tetap Anda

## 3. Konfigurasi URL di Dashboard Midtrans

### Untuk Sandbox (Testing)

1. Login ke https://dashboard.sandbox.midtrans.com/
2. Pilih **Settings** → **Configuration**
3. Scroll ke bagian **Notification URL**
4. Masukkan URL webhook Anda:
   ```
   https://abc123-def456.ngrok.io/api/midtrans/notification
   ```
   atau untuk production:
   ```
   https://your-domain.com/api/midtrans/notification
   ```
5. Klik **Save**

### Untuk Production

1. Login ke https://dashboard.midtrans.com/
2. Pilih **Settings** → **Configuration**
3. Masukkan URL webhook production Anda:
   ```
   https://your-domain.com/api/midtrans/notification
   ```
4. Klik **Save**

## 4. Testing URL Webhook

### Test dengan cURL

```bash
curl -X POST https://abc123-def456.ngrok.io/api/midtrans/notification \
  -H "Content-Type: application/json" \
  -d '{
    "transaction_status": "settlement",
    "order_id": "ORDER-XXXXX",
    "gross_amount": "100000.00",
    "payment_type": "qris",
    "status_code": "200"
  }'
```

### Test dari Dashboard Midtrans

1. Login ke Dashboard Midtrans
2. Pilih **Transactions**
3. Pilih transaksi yang ingin di-test
4. Klik **Simulate Payment** atau **Send Notification**

## 5. Troubleshooting

### Error: "Webhook tidak menerima notifikasi"

1. **Cek URL**: Pastikan URL webhook benar
2. **Cek ngrok**: Pastikan ngrok masih berjalan dan URL masih aktif
3. **Cek Laravel**: Pastikan Laravel server masih berjalan
4. **Cek log**: Lihat `storage/logs/laravel.log` untuk error

### Error: "Connection refused"

1. Pastikan ngrok masih berjalan
2. Pastikan Laravel server masih berjalan di port 8000
3. Restart ngrok jika perlu

### URL ngrok berubah

- Jika ngrok di-restart, URL akan berubah
- Update URL di Dashboard Midtrans dengan URL baru
- Atau gunakan ngrok dengan custom domain (untuk paid plan)

## 6. Tips

1. **Gunakan ngrok untuk development**: Lebih mudah untuk testing
2. **Monitor log**: Cek `storage/logs/laravel.log` untuk melihat notifikasi yang masuk
3. **Test sebelum production**: Pastikan webhook bekerja dengan baik sebelum deploy
4. **Gunakan HTTPS untuk production**: Midtrans memerlukan HTTPS untuk production

## 7. Contoh URL Lengkap

### Development (ngrok)
```
https://abc123-def456.ngrok.io/api/midtrans/notification
```

### Production
```
https://sewa-motor.com/api/midtrans/notification
```

atau

```
https://api.sewa-motor.com/midtrans/notification
```

## 8. Verifikasi URL Berfungsi

Setelah mengkonfigurasi URL di Dashboard Midtrans, lakukan test:

1. Buat transaksi test dari aplikasi
2. Bayar menggunakan QRIS/Virtual Account
3. Cek log di `storage/logs/laravel.log`:
   ```bash
   tail -f storage/logs/laravel.log
   ```
4. Anda akan melihat log:
   ```
   [2024-01-01 10:00:00] local.INFO: Midtrans Notification Received {"order_id":"ORDER-XXXXX","transaction_status":"settlement"...}
   ```

Jika melihat log tersebut, berarti webhook sudah berfungsi dengan baik!

