# 🍰 CakeLuv Patisserie - E-Commerce Platform

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Midtrans](https://img.shields.io/badge/Midtrans_Payment-00A9E0?style=for-the-badge)

**CakeLuv Patisserie** adalah aplikasi E-Commerce toko kue premium yang dibangun dari nol (*from scratch*) menggunakan arsitektur **Native PHP MVC** (Tanpa Framework). Proyek ini saya kembangkan untuk mendemonstrasikan pemahaman mendalam tentang pola desain MVC, keamanan web, dan integrasi API pihak ketiga (*Payment Gateway*).

---

## ✨ Fitur Utama (Key Features)

### 🛍️ Sisi Pelanggan (Customer-Facing)
* **Katalog Produk Dinamis:** Menampilkan kue premium dan aksesoris dengan filter kategori.
* **Keranjang Belanja (Cart):** Pengelolaan keranjang yang responsif dengan fitur catatan (*custom request*) pada setiap produk.
* **Integrasi Payment Gateway:** Checkout mulus menggunakan **Midtrans Snap API** (Mendukung VA, GoPay, QRIS, dll). Termasuk simulasi pembaruan status Lunas (*Paid*) secara *real-time*.
* **Autentikasi Aman:** Sistem Login, Register, dan Lupa Sandi berbasis token (OTP) dengan *password hashing* (`bcrypt`) dan proteksi *Session Hijacking*.
* **UI/UX Mewah:** Dibangun dengan **Tailwind CSS**, mendukung desain responsif, *Toast Notifications* kustom, animasi AOS, dan *slider* produk dengan fitur *drag-to-scroll*.

### 📊 Sisi Admin (Dashboard & Manajemen)
* **Visualisasi Data:** Dashboard admin yang dilengkapi grafik analitik (Penjualan 7 Hari Terakhir & Produk Teratas) menggunakan **Chart.js**.
* **Manajemen Produk (CRUD):** Tambah, edit, hapus produk, serta sistem *upload* dan manajemen *file* gambar ke *local storage*.
* **Manajemen Pesanan:** Memantau pesanan masuk dan mengubah status pesanan (Pending -> Paid -> Processed -> Shipped).

---

## 🛠️ Tech Stack & Arsitektur

* **Backend:** Native PHP (Berorientasi Objek / OOP)
* **Arsitektur:** Custom MVC (Model - View - Controller) dengan Router dinamis.
* **Database:** MySQL dengan ekstensi **PDO** (*Prepared Statements* untuk mencegah *SQL Injection*).
* **Frontend:** HTML5, Tailwind CSS, JavaScript murni (*Vanilla JS*), Chart.js, AOS Animation.
* **API Integration:** Midtrans Payment Gateway API.

---

## 💡 Mengapa Proyek Ini Ada di Portfolio Saya?
Proyek ini membuktikan kemampuan saya dalam membangun sistem yang kompleks tanpa bergantung pada *framework* besar seperti Laravel atau CodeIgniter. Dengan membangun sistem routing, base controller, dan model secara manual, saya mengasah fundamental PHP, manajemen *session*, keamanan database, serta cara kerja *RESTful API* dan Webhook.

---

## 🚀 Panduan Instalasi (Local Development)

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/UsernameAnda/nama-repo-anda.git
   cd nama-repo-anda
   ```
2. **Database Setup:**
   * Buat database MySQL baru (contoh: `bakery_db`).
   * Import skema database dari file `database.sql`.
3. **Konfigurasi Environment:**
   * Ubah nama file `app/Config/config.example.php` menjadi `config.php`.
   * Sesuaikan kredensial koneksi database dan masukkan **Client/Server Key Midtrans Sandbox** Anda.
4. **Jalankan Aplikasi:**
   * Gunakan XAMPP/Laragon, atau jalankan via *built-in server* PHP:
     ```bash
     php -S localhost:8000 -t public
     ```

**Akun Demo Admin:**
* **Email:** `admin@cakeluv.com`
* **Password:** `password`
