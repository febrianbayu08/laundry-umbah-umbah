# 🫧 PIKUCEK! Laundry Management System

**PIKUCEK!** adalah aplikasi sistem informasi manajemen laundry berbasis web yang modern, responsif, dan kaya fitur. Aplikasi ini dirancang untuk membantu operasional bisnis laundry mulai dari pencatatan transaksi, manajemen pelanggan, hingga pelaporan keuangan yang akurat.

 Login Page
 <img width="1640" height="861" alt="image" src="https://github.com/user-attachments/assets/708685c6-4f01-41bd-9e10-ff50673c6333" />

 Dashboard
 <img width="1901" height="906" alt="image" src="https://github.com/user-attachments/assets/80d4c66b-c66d-4911-ab39-50bff4622af4" />



---

## 🚀 Fitur Unggulan (Key Features)

Aplikasi ini dilengkapi dengan fitur-fitur premium:

* **📊 Smart Dashboard:** Grafik pendapatan real-time (7 hari terakhir) menggunakan *Chart.js* dan ringkasan statistik harian.
* **🛒 Transaksi Cerdas:** * Kalkulator otomatis (Total harga langsung muncul tanpa refresh).
    * Support berbagai satuan: **Kg** (Kiloan), **Pasang** (Sepatu), **Meter** (Karpet), dan **Pcs** (Satuan).
* **📱 WhatsApp Gateway:** Kirim notifikasi status cucian ke pelanggan via WhatsApp hanya dengan 1 klik.
* **🧾 Struk Digital:** Cetak nota transaksi profesional dengan *branding* PIKUCEK!.
* **📈 Laporan Keuangan:** Filter pendapatan berdasarkan tanggal dan fitur **Export to Excel**.
* **🔍 Tracking Cucian:** Fitur "Cek Resi" untuk pelanggan melihat status cucian tanpa perlu login.
* **✨ Modern UI/UX:** Tampilan *Glassmorphism* dengan tema Midnight Blue, animasi halus, dan tabel interaktif (*DataTables*).

---

## 🛠️ Teknologi yang Digunakan

* **Bahasa Pemrograman:** PHP Native (Versi 7.4 / 8.0+)
* **Database:** MySQL / MariaDB
* **Frontend Framework:** Bootstrap 5.3
* **Styling:** Custom CSS (Gradients & Glassmorphism)
* **Libraries:** * *SweetAlert2* (Notifikasi Cantik)
    * *Chart.js* (Grafik Statistik)
    * *DataTables* (Tabel Pencarian & Paginasi)
    * *FontAwesome 6* (Ikon)

---

## ⚙️ Cara Instalasi (How to Run)

Ikuti langkah ini untuk menjalankan aplikasi di komputer lokal (XAMPP/Laragon):

1.  **Download Source Code**
    Clone repository ini atau download sebagai ZIP dan ekstrak ke folder `htdocs` (XAMPP) atau `www` (Laragon).
    ```bash
    git clone [https://github.com/febrianbayu08/laundry-umbah-umbah.git](https://github.com/febrianbayu08/laundry-umbah-umbah.git)
    ```

2.  **Buat Database**
    * Buka `localhost/phpmyadmin`
    * Buat database baru dengan nama: `laundry_db`

3.  **Import Database**
    * Klik tab **SQL** pada database `laundry_db`.
    * Copy dan Paste kode SQL yang ada di bagian bawah file ini (Lihat bagian **Struktur Database**).
    * Klik **Go / Kirim**.

4.  **Konfigurasi Koneksi**
    Pastikan file `koneksi.php` sudah sesuai dengan settingan database kamu:
    ```php
    $host = "localhost";
    $user = "root";
    $pass = ""; 
    $db   = "laundry_db";
    ```

5.  **Jalankan Aplikasi**
    Buka browser dan akses: `http://localhost/laundry_web`

---

## 🔐 Akun Login (Default)

Gunakan akun ini untuk masuk sebagai Administrator:

* **Username:** `admin`
* **Password:** `admin123`
* **Role:** Administrator (Akses Penuh)

---

## 🗄️ Struktur Database (Database Schema)

Berikut adalah struktur tabel yang digunakan dalam aplikasi ini:

### 1. Tabel `users` (Pengguna/Pegawai)
Menyimpan data admin dan kasir.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `nama` | VARCHAR(100) | Nama Lengkap |
| `username` | VARCHAR(50) | Username Login |
| `password` | VARCHAR(255) | Password |
| `role` | ENUM | 'admin', 'kasir', 'owner' |

### 2. Tabel `customers` (Pelanggan)
Menyimpan data pelanggan.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `nama` | VARCHAR(100) | Nama Pelanggan |
| `alamat` | TEXT | Alamat Domisili |
| `telp` | VARCHAR(20) | Nomor WhatsApp |

### 3. Tabel `packages` (Paket Laundry)
Menyimpan daftar harga dan jenis layanan.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `jenis` | ENUM | 'kiloan', 'selimut', 'bed_cover', 'kaos' |
| `nama_paket` | VARCHAR(100) | Contoh: Cuci Komplit, Cuci Sepatu |
| `harga` | INT | Harga per satuan |

### 4. Tabel `transactions` (Transaksi Header)
Menyimpan data utama transaksi (Nota).
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `kode_invoice`| VARCHAR(100)| Contoh: INV-20251128... |
| `id_member` | INT (FK) | Relasi ke tabel customers |
| `tgl` | DATETIME | Waktu transaksi masuk |
| `status` | ENUM | 'baru', 'proses', 'selesai', 'diambil' |
| `dibayar` | ENUM | 'dibayar', 'belum_dibayar' |

### 5. Tabel `transaction_details` (Rincian Item)
Menyimpan detail barang apa saja yang dicuci dalam satu nota.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `id_transaksi`| INT (FK) | Relasi ke tabel transactions |
| `id_paket` | INT (FK) | Relasi ke tabel packages |
| `qty` | DOUBLE | Jumlah berat (Kg) atau Satuan (Pcs) |

---

## 📝 Query SQL (Import Ini)

Copy kode di bawah ini ke SQL phpMyAdmin untuk membuat database otomatis:

```sql
-- Buat Database
CREATE DATABASE IF NOT EXISTS laundry_db;
USE laundry_db;

-- Tabel Outlets
CREATE TABLE outlets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    telp VARCHAR(15)
);

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('admin', 'kasir', 'owner'),
    id_outlet INT
);

-- Tabel Customers
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    telp VARCHAR(20)
);

-- Tabel Packages
CREATE TABLE packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_outlet INT,
    jenis ENUM('kiloan', 'selimut', 'bed_cover', 'kaos'),
    nama_paket VARCHAR(100),
    harga INT
);

-- Tabel Transactions
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_outlet INT,
    kode_invoice VARCHAR(100),
    id_member INT,
    tgl DATETIME,
    batas_waktu DATETIME,
    tgl_bayar DATETIME,
    status ENUM('baru', 'proses', 'selesai', 'diambil'),
    dibayar ENUM('dibayar', 'belum_dibayar'),
    id_user INT
);

-- Tabel Transaction Details
CREATE TABLE transaction_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_paket INT,
    qty DOUBLE,
    keterangan TEXT
);

-- DATA DUMMY (Opsional)
INSERT INTO users (nama, username, password, role) VALUES 
('Administrator', 'admin', 'admin123', 'admin'),
('Kasir Pikucek', 'kasir', 'kasir123', 'kasir');

INSERT INTO packages (id_outlet, jenis, nama_paket, harga) VALUES 
(1, 'kiloan', 'Cuci Komplit (Reguler)', 7000),
(1, 'kiloan', 'Cuci Komplit (Express)', 12000),
(1, 'kaos', 'Cuci Sepatu (Deep Clean)', 35000),
(1, 'bed_cover', 'Cuci Bedcover Besar', 25000),
(1, 'kaos', 'Cuci Karpet (Per Meter)', 15000);

Tentu! Ini adalah file README.md yang sangat lengkap dan profesional. File ini dirancang khusus untuk memenuhi syarat tugas sekolah kamu (wajib mencantumkan struktur database) sekaligus memamerkan fitur-fitur canggih "PIKUCEK!" agar gurumu terkesan.

Silakan buat file baru di VS Code bernama README.md, lalu Copy-Paste semua kode di bawah ini:

Markdown

# 🫧 PIKUCEK! Laundry Management System

**PIKUCEK!** adalah aplikasi sistem informasi manajemen laundry berbasis web yang modern, responsif, dan kaya fitur. Aplikasi ini dirancang untuk membantu operasional bisnis laundry mulai dari pencatatan transaksi, manajemen pelanggan, hingga pelaporan keuangan yang akurat.

![Dashboard Preview](https://via.placeholder.com/800x400.png?text=Preview+Dashboard+PIKUCEK)
*(Ganti link gambar di atas dengan screenshot aplikasi kamu jika sempat)*

---

## 🚀 Fitur Unggulan (Key Features)

Aplikasi ini dilengkapi dengan fitur-fitur premium:

* **📊 Smart Dashboard:** Grafik pendapatan real-time (7 hari terakhir) menggunakan *Chart.js* dan ringkasan statistik harian.
* **🛒 Transaksi Cerdas:** * Kalkulator otomatis (Total harga langsung muncul tanpa refresh).
    * Support berbagai satuan: **Kg** (Kiloan), **Pasang** (Sepatu), **Meter** (Karpet), dan **Pcs** (Satuan).
* **📱 WhatsApp Gateway:** Kirim notifikasi status cucian ke pelanggan via WhatsApp hanya dengan 1 klik.
* **🧾 Struk Digital:** Cetak nota transaksi profesional dengan *branding* PIKUCEK!.
* **📈 Laporan Keuangan:** Filter pendapatan berdasarkan tanggal dan fitur **Export to Excel**.
* **🔍 Tracking Cucian:** Fitur "Cek Resi" untuk pelanggan melihat status cucian tanpa perlu login.
* **✨ Modern UI/UX:** Tampilan *Glassmorphism* dengan tema Midnight Blue, animasi halus, dan tabel interaktif (*DataTables*).

---

## 🛠️ Teknologi yang Digunakan

* **Bahasa Pemrograman:** PHP Native (Versi 7.4 / 8.0+)
* **Database:** MySQL / MariaDB
* **Frontend Framework:** Bootstrap 5.3
* **Styling:** Custom CSS (Gradients & Glassmorphism)
* **Libraries:** * *SweetAlert2* (Notifikasi Cantik)
    * *Chart.js* (Grafik Statistik)
    * *DataTables* (Tabel Pencarian & Paginasi)
    * *FontAwesome 6* (Ikon)

---

## ⚙️ Cara Instalasi (How to Run)

Ikuti langkah ini untuk menjalankan aplikasi di komputer lokal (XAMPP/Laragon):

1.  **Download Source Code**
    Clone repository ini atau download sebagai ZIP dan ekstrak ke folder `htdocs` (XAMPP) atau `www` (Laragon).
    ```bash
    git clone [https://github.com/febrianbayu08/laundry-umbah-umbah.git](https://github.com/febrianbayu08/laundry-umbah-umbah.git)
    ```

2.  **Buat Database**
    * Buka `localhost/phpmyadmin`
    * Buat database baru dengan nama: `laundry_db`

3.  **Import Database**
    * Klik tab **SQL** pada database `laundry_db`.
    * Copy dan Paste kode SQL yang ada di bagian bawah file ini (Lihat bagian **Struktur Database**).
    * Klik **Go / Kirim**.

4.  **Konfigurasi Koneksi**
    Pastikan file `koneksi.php` sudah sesuai dengan settingan database kamu:
    ```php
    $host = "localhost";
    $user = "root";
    $pass = ""; 
    $db   = "laundry_db";
    ```

5.  **Jalankan Aplikasi**
    Buka browser dan akses: `http://localhost/laundry_web`

---

## 🔐 Akun Login (Default)

Gunakan akun ini untuk masuk sebagai Administrator:

* **Username:** `admin`
* **Password:** `admin123`
* **Role:** Administrator (Akses Penuh)

---

## 🗄️ Struktur Database (Database Schema)

Berikut adalah struktur tabel yang digunakan dalam aplikasi ini:

### 1. Tabel `users` (Pengguna/Pegawai)
Menyimpan data admin dan kasir.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `nama` | VARCHAR(100) | Nama Lengkap |
| `username` | VARCHAR(50) | Username Login |
| `password` | VARCHAR(255) | Password |
| `role` | ENUM | 'admin', 'kasir', 'owner' |

### 2. Tabel `customers` (Pelanggan)
Menyimpan data pelanggan.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `nama` | VARCHAR(100) | Nama Pelanggan |
| `alamat` | TEXT | Alamat Domisili |
| `telp` | VARCHAR(20) | Nomor WhatsApp |

### 3. Tabel `packages` (Paket Laundry)
Menyimpan daftar harga dan jenis layanan.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `jenis` | ENUM | 'kiloan', 'selimut', 'bed_cover', 'kaos' |
| `nama_paket` | VARCHAR(100) | Contoh: Cuci Komplit, Cuci Sepatu |
| `harga` | INT | Harga per satuan |

### 4. Tabel `transactions` (Transaksi Header)
Menyimpan data utama transaksi (Nota).
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `kode_invoice`| VARCHAR(100)| Contoh: INV-20251128... |
| `id_member` | INT (FK) | Relasi ke tabel customers |
| `tgl` | DATETIME | Waktu transaksi masuk |
| `status` | ENUM | 'baru', 'proses', 'selesai', 'diambil' |
| `dibayar` | ENUM | 'dibayar', 'belum_dibayar' |

### 5. Tabel `transaction_details` (Rincian Item)
Menyimpan detail barang apa saja yang dicuci dalam satu nota.
| Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT (PK) | Auto Increment |
| `id_transaksi`| INT (FK) | Relasi ke tabel transactions |
| `id_paket` | INT (FK) | Relasi ke tabel packages |
| `qty` | DOUBLE | Jumlah berat (Kg) atau Satuan (Pcs) |

---

## 📝 Query SQL (Import Ini)

Copy kode di bawah ini ke SQL phpMyAdmin untuk membuat database otomatis:

```sql
-- Buat Database
CREATE DATABASE IF NOT EXISTS laundry_db;
USE laundry_db;

-- Tabel Outlets
CREATE TABLE outlets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    telp VARCHAR(15)
);

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('admin', 'kasir', 'owner'),
    id_outlet INT
);

-- Tabel Customers
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    telp VARCHAR(20)
);

-- Tabel Packages
CREATE TABLE packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_outlet INT,
    jenis ENUM('kiloan', 'selimut', 'bed_cover', 'kaos'),
    nama_paket VARCHAR(100),
    harga INT
);

-- Tabel Transactions
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_outlet INT,
    kode_invoice VARCHAR(100),
    id_member INT,
    tgl DATETIME,
    batas_waktu DATETIME,
    tgl_bayar DATETIME,
    status ENUM('baru', 'proses', 'selesai', 'diambil'),
    dibayar ENUM('dibayar', 'belum_dibayar'),
    id_user INT
);

-- Tabel Transaction Details
CREATE TABLE transaction_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_paket INT,
    qty DOUBLE,
    keterangan TEXT
);

-- DATA DUMMY (Opsional)
INSERT INTO users (nama, username, password, role) VALUES 
('Administrator', 'admin', 'admin123', 'admin'),
('Kasir Pikucek', 'kasir', 'kasir123', 'kasir');

INSERT INTO packages (id_outlet, jenis, nama_paket, harga) VALUES 
(1, 'kiloan', 'Cuci Komplit (Reguler)', 7000),
(1, 'kiloan', 'Cuci Komplit (Express)', 12000),
(1, 'kaos', 'Cuci Sepatu (Deep Clean)', 35000),
(1, 'bed_cover', 'Cuci Bedcover Besar', 25000),
(1, 'kaos', 'Cuci Karpet (Per Meter)', 15000);



Dibuat dengan ❤️ oleh *Febrian Bayu Putranto - XII RPL/12*


---

### Cara Update ke GitHub
Setelah file `README.md` ini disimpan, jangan lupa update ke GitHub agar muncul di halaman depan repository kamu:

1.  Buka Terminal VS Code.
2.  Ketik: `git add README.md`
3.  Ketik: `git commit -m "Update dokumentasi lengkap"`
4.  Ketik: `git push`
