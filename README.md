<p align="center">
  <img src="https://github.com/denywa/ALP-Juku/blob/main/flutter/assets/logo-full.png?raw=true" alt="Juku Sambalu Logo" width="300px">
</p>

# Juku Sambalu

**Juku Sambalu** adalah aplikasi yang dirancang untuk mempermudah petambak ikan dalam menjual hasil panen mereka secara langsung kepada pembeli. Dengan menghilangkan tengkulak/perantara, aplikasi ini bertujuan untuk memberikan harga jual yang lebih adil bagi petambak dan akses yang lebih baik bagi pembeli untuk mendapatkan ikan segar.

Aplikasi ini dikembangkan menggunakan **Flutter** untuk aplikasi mobile dan **Laravel** sebagai backend. Dengan fitur-fitur yang memudahkan transaksi, aplikasi ini berfokus pada efisiensi, kesegaran, dan keterjangkauan harga.

## Fitur Utama

- **Penjualan Langsung**: Memungkinkan petambak ikan untuk menjual hasil panen langsung kepada konsumen tanpa perantara.
- **Akses Pembeli**: Pembeli dapat membeli ikan segar dengan harga yang lebih terjangkau dan kualitas yang lebih baik.
- **Transparansi Harga**: Mengurangi praktik monopoli harga dalam rantai distribusi ikan.

## Cara Instalasi

1. **Clone Repository**  
   Clone repository ini ke komputer Anda:

   ```bash
   git clone https://github.com/denywa/ALP-Juku.git
   cd ALP-Juku
   ```

2. **Frontend**:

   - Aplikasi mobile dibangun menggunakan **Flutter**. Pastikan Flutter SDK telah diinstal di perangkat Anda.
   - Jalankan perintah berikut untuk memulai aplikasi:
     ```bash
     cd 'flutter/'
     flutter pub get
     flutter run
     ```

3. **Backend**:
   - Backend menggunakan **Laravel**. Pastikan server PHP, Composer, dan environment telah diatur.
   - Jalankan perintah berikut untuk memulai server backend:
     ```bash
     cd 'pasarJuku'
     composer install
     cp .env.example .env
     php artisan key:generate
     php artisan migrate:fresh --seed
     php artisan serve
     ```

## Lebih Lanjut Tentang **Juku Sambalu**

- [Banner PDF](https://github.com/denywa/ALP-Juku/blob/main/Banner.pdf)
- [Poster PDF](https://github.com/denywa/ALP-Juku/blob/main/Poster.pdf)
- [Presentasi PDF](https://github.com/denywa/ALP-Juku/blob/main/Presentasi.pdf)

## Tim Pengembang

**By Group Juku Sambalu | IMT UCM '23**

- **[Deny Wahyudi Asaloei](https://github.com/denywa)** - 0806022310009
- **[Felicia Wijaya](https://github.com/feliciawijaya2006)** - 0806022310007
- **[Levin Dawson Wisan](https://github.com/levinn1)** - 0806022310020
- **[Muh. Ryan Ardiansyah](https://github.com/mzkyann)** - 0806022310019

##### <p align="center">```👈(ﾟヮﾟ👈)(👉ﾟヮﾟ)👉```
