# 📘 README – Project Sewa Kamera 🎥

## 👥 Nama Kelompok
Kelompok 5

## 🧑‍💻 Nama Team
Rafi Abdul Fatah  
Dewi Lestari  
Rizky Maulana  

## 📦 Nama Project
**Sewa Kamera – Sistem Penyewaan Kamera dan Lensa Berbasis Web**

## 🧩 List Fitur
1. Autentikasi Login & Register (User dan Admin)
2. Manajemen Data Kamera (CRUD oleh Admin)
3. Manajemen Kategori Kamera (DSLR, Mirrorless, Lensa, Aksesoris)
4. User dapat menyewa kamera/lensa yang tersedia
5. Batas maksimal 2 item yang bisa disewa oleh 1 user
6. Lama sewa maksimal 5 hari (lebih dari itu dikenakan denda)
7. Admin dapat melihat dan mencetak laporan penyewaan
8. User dapat melihat riwayat penyewaan mereka
9. Validasi input data dan status unit (tersedia / disewa)
10. Pencarian kamera berdasarkan nama atau kategori
11. Admin dapat menambahkan, mengubah, dan menghapus data kategori, kamera, serta user

---

## 🗃️ Skema Database (ERD)

Berikut adalah struktur relasi tabel utama dalam sistem:

![ERD Database Sewa Kamera](public/images/erd-sewa-kamera.png)

**Tabel Utama:**
- `users` → Menyimpan data user dan admin  
- `categories` → Menyimpan kategori kamera  
- `units` → Menyimpan data kamera & lensa  
- `loans` → Menyimpan transaksi penyewaan  

---

## 🎥 Demo Project

Screen recorder demo penjelasan website dapat dilihat di link berikut:

🔗 **[Lihat Video Demo di Google Drive](https://drive.google.com/drive/folders/xxxxx)**  
*(Gantilah dengan link video demo project kamu di Google Drive atau YouTube)*

---

## ⚙️ Cara Menjalankan Project (Menggunakan XAMPP)
1. Pastikan XAMPP sudah aktif (Apache & MySQL).
2. Clone atau ekstrak project ini ke dalam folder `htdocs`.
3. Jalankan perintah berikut di terminal:
   ```bash
   composer install
   copy .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve


---

### 🔧 Penjelasan
- `public/images/erd-sewa-kamera.png` → simpan gambar skema database kamu di folder `public/images/`.  
- Link video demo → upload screen recorder ke Google Drive, lalu masukkan link di README.  
- Kamu tinggal ubah bagian:
  - Nama kelompok
  - Anggota tim
  - Nama dosen
  - Nama project (kalau bukan *Sewa Kamera*)  

---

Kalau kamu mau, saya bisa bantu:
1. Buatkan **gambar ERD-nya (skema database)** agar bisa kamu taruh di README.  
2. Atau ubah README ini supaya sesuai jika kamu **pilih ide project lain** (misalnya *Sewa Power Tools*, *Sewa Kostum*, dll).

Kamu mau saya bantu buatkan **ERD-nya untuk ide “Sewa Kamera”** atau mau ubah dulu ke ide lain?
