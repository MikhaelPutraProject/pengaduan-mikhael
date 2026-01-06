# 🌐 Pengaduan By Mikhael

**Nama Website:** Pengaduan By Mikhael  
**Website:** https://pengaduanbymikhael.ct.ws  

**Deskripsi:**  
Pengaduan By Mikhael adalah website pengaduan masyarakat yang memudahkan pengguna menyampaikan keluhan terkait fasilitas umum dan pelayanan publik secara cepat, mudah, dan terstruktur.

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

Website ini menggunakan **PHP CRUD API** sehingga:
- Tidak memerlukan banyak query manual
- Data diakses melalui endpoint API
- Format data menggunakan **JSON**

Contoh endpoint API:
```http
GET /api.php/records/users
POST /api.php/records/reports
