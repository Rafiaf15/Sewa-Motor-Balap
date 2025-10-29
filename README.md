# 🏍️ README – Project Sewa Motor Balap & Joki

## 👥 Nama Kelompok
Kelompok 5

## 🧑‍💻 Nama Team
Rafi Abdul Fatah  
[Anggota 2]  
[Anggota 3]  

## 📦 Nama Project
**Sewa Motor Balap & Joki – Sistem Penyewaan Motor Balap dan Jasa Joki Berbasis Web**

---

## 🧩 List Fitur
1. **Autentikasi Login & Register**
   - Terdapat 2 jenis akun: **Admin** dan **User (Anggota)**  
   - User harus login untuk dapat mengakses fitur sewa

2. **Manajemen Data**
   - Admin dapat menambah, mengubah, dan menghapus data **motor balap**, **joki**, dan **kategori motor**
   - User dapat mengedit profilnya sendiri

3. **Sewa Motor dan Joki**
   - User dapat menyewa motor balap dan memilih joki jika diperlukan
   - User dapat menyewa **maksimal 2 unit** motor dalam satu waktu
   - Durasi sewa maksimal **5 hari**, lebih dari itu dikenakan **denda otomatis**

4. **Manajemen Joki**
   - Admin dapat menambah dan mengatur ketersediaan joki
   - Joki yang sedang bertugas tidak bisa disewa bersamaan oleh user lain

5. **Laporan & Riwayat**
   - Admin dapat melihat dan mencetak laporan penyewaan
   - User dapat melihat riwayat sewa dan status pengembalian

6. **Pencarian & Filter**
   - User dapat mencari motor berdasarkan **nama**, **kategori**, atau **status**
   - Filter juga tersedia untuk menampilkan motor yang sedang tersedia saja

7. **Validasi Data**
   - Semua form penting diberi validasi (`required`, format email, batas pinjaman, dsb)
   - Sistem otomatis menghitung **denda** jika melewati batas waktu sewa

---

## 🗃️ Skema Database (ERD)
Berikut adalah relasi utama antar tabel dalam sistem:

![ERD Database Sewa Motor Balap](public/images/erd-sewa-motor-balap.png)

**Tabel Utama:**
- `users` → menyimpan data user dan admin  
- `categories` → menyimpan kategori motor (Matic, Sport, Drag, Superbike, dll)  
- `units` → menyimpan data motor balap  
- `jokis` → menyimpan data joki yang bisa disewa  
- `loans` → menyimpan transaksi penyewaan (motor + joki)

---

## 🎥 Demo Project
Screen recorder demo penjelasan website dapat dilihat di link berikut:

🔗 **[Lihat Video Demo di Google Drive](https://drive.google.com/drive/folders/xxxxx)**  
*(Gantilah dengan link video demo project kamu di Google Drive atau YouTube)*

---

## ⚙️ Cara Menjalankan Project (Menggunakan XAMPP)
1. Pastikan **XAMPP** sudah aktif (Apache & MySQL).
2. Ekstrak project ke dalam folder `htdocs`.
3. Buka terminal / cmd, arahkan ke folder project.
4. Jalankan perintah berikut:
   ```bash
   composer install
   copy .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
