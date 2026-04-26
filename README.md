# SIMS SMA MA'ARIF KROYA

Laravel 11 application untuk Sistem Informasi Sekolah SMA MA'ARIF KROYA.

## Fitur Utama

- Landing page sekolah dengan Blade components
- PPDB online
- Portal siswa dummy
- Admin dashboard dummy
- Konfigurasi sekolah terpusat lewat `config/school.php`
- Data awal via migration schema

## Route Utama

- `/` landing page
- `/ppdb` halaman PPDB
- `/ppdb/daftar` formulir pendaftaran
- `/ppdb/cek-status` cek status pendaftaran
- `/portal` portal siswa
- `/admin` dashboard admin

## Setup Lokal

1. Copy `.env.example` ke `.env`
2. Sesuaikan database MySQL
3. Jalankan:

```bash
php artisan key:generate
php artisan migrate
php artisan serve
```

## Asset

- CSS landing: `public/css/landing.css`
- JS landing: `public/js/landing.js`
- CSS admin: `public/css/admin.css`
- JS admin: `public/js/admin.js`

## Konfigurasi Sekolah

Nilai berikut dibaca dari `.env` melalui `config/school.php`:

- `SCHOOL_NAME`
- `SCHOOL_EMAIL`
- `SCHOOL_PHONE`
- `SCHOOL_ADDRESS`

## Catatan

- Halaman admin masih memakai dummy data untuk UI.
- Portal siswa dan PPDB masih fase pengembangan data persistence.
- Migration schema sudah disiapkan untuk fase backend berikutnya.
- Akun admin demo:
  - `admin@smamaarifkroya.sch.id`
  - `password123`
