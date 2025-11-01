<x-mail::message>
# Verifikasi Email Anda

Halo {{ $notifiable->name }},

Terima kasih telah mendaftar di **{{ config('app.name') }}**! Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:

<x-mail::button :url="$url" color="primary">
Verifikasi Email
</x-mail::button>

Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan tautan berikut ke browser Anda:

<p><a href="{{ $url }}">{{ $url }}</a></p>

Email ini akan kedaluwarsa dalam **60 menit**. Jika Anda tidak meminta verifikasi ini, abaikan email ini.

Terima kasih,<br>
Tim {{ config('app.name') }}
</x-mail::message>
