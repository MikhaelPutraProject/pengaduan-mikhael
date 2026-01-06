# 🌐 Pengaduan Kota Madiun By Mikhael

**Nama Website:** Pengaduan Kota Madiun By Mikhael  
**Website:** https://pengaduanbymikhael.ct.ws  

**Deskripsi:**  
Pengaduan Kota Madiun By Mikhael adalah website pengaduan masyarakat yang memudahkan pengguna menyampaikan keluhan terkait fasilitas umum dan pelayanan publik secara cepat, mudah, dan terstruktur.

--------------------------------------------

# 📘 Website Sistem Laporan (PHP + CRUD API)

Website ini dibuat sebagai **tugas pembuatan website** dengan teknologi **PHP**, **PHP-CRUD-API**, dan **Bootstrap**.  
Aplikasi ini memiliki fitur **login**, **dashboard admin**, serta **pengelolaan laporan** berbasis database melalui API.

---

## 🧩 Teknologi yang Digunakan

- **PHP (Native)**
- **PHP CRUD API**
- **Bootstrap** (UI & Dashboard)
- **MySQL / MariaDB**
- **HTML, CSS, JavaScript**

---

## 📂 Struktur Halaman

Berikut adalah halaman-halaman utama pada website:

| Halaman | Deskripsi |
|-------|----------|
| `index.php` | Halaman utama website |
| `login.php` | Halaman login pengguna |
| `login_admin.php` | Halaman login admin |
| `dashboard.php` | Dashboard admin |
| `daftar.php` | Halaman pendaftaran / input data |
| `report.php` | Halaman pengiriman laporan |
| `my_report.php` | Halaman laporan milik user |
| `logout.php` | Logout user |
| `logout_admin.php` | Logout admin |

---

## 🔐 Akun Login (Untuk Penilaian)

### Admin
- **Username:** `admin`
- **Password:** `admin`

> ⚠️ *Akun ini dibuat hanya untuk keperluan tugas dan pengujian.*

---

## ⚙️ Fitur Utama

- ✅ Login User & Admin  
- ✅ Dashboard Admin  
- ✅ CRUD Data menggunakan **PHP CRUD API**  
- ✅ Pengelolaan laporan masyarakat  
- ✅ Session & Logout  
- ✅ Tampilan responsif menggunakan Bootstrap  

---

## 🗄️ Konsep Database

Website **Pengaduan Kota Madiun By Mikhael** menggunakan **MySQL / MariaDB** sebagai database dan dikelola melalui **PHP CRUD API**.  
Semua proses pengolahan data (Create, Read, Update, Delete) dilakukan melalui endpoint API dengan format data **JSON**, sehingga aplikasi lebih terstruktur dan mudah dikembangkan.

### 📑 Struktur Tabel Database

Database terdiri dari beberapa tabel utama berikut:

| Tabel | Deskripsi |
|------|----------|
| `admins` | Menyimpan data akun admin untuk mengelola dashboard |
| `users` | Menyimpan data pengguna yang dapat mengirim pengaduan |
| `categories` | Menyimpan kategori pengaduan (contoh: jalan rusak, sampah, layanan publik) |
| `complaints` | Menyimpan data utama pengaduan/laporan yang dikirim pengguna |
| `complaint_logs` | Menyimpan riwayat atau status perubahan pengaduan |

---

### 🔄 Konsep CRUD (Create, Read, Update, Delete)

Pengelolaan data pengaduan dilakukan melalui endpoint:

### Contoh endpoint API:
```http
GET /api.php/records/complaints
POST /api.php/records/complaints
PUT /api.php/records/complaints/{id}
DELETE /api.php/records/complaints/{id}
