# Sistem Informasi Aset KAI

Aplikasi web berbasis Laravel untuk manajemen dan monitoring aset PT. Kereta Api Indonesia (KAI). Sistem ini menyediakan fitur katalog aset, peta persebaran, monitoring kontrak, manajemen favorit, dan administrasi pengguna.

---

## Fitur Utama

- **Dashboard** — Ringkasan data aset dan statistik
- **Katalog & Explorer Aset** — Daftar, pencarian, dan detail aset
- **Peta Aset** — Visualisasi persebaran aset di peta Indonesia
- **Manajemen Kontrak** — Daftar kontrak dan monitoring jatuh tempo
- **Backlog** — Monitoring aset yang belum terkontrak
- **Favorit** — Tandai aset favorit
- **FAQ** — Halaman pertanyaan umum
- **Admin Panel** — Manajemen aset dan pengguna (khusus admin)

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database: SQLite (default) atau MySQL/MariaDB
- Laravel 11.x

---

## Struktur Folder

```
test-project-kai/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AssetManagementController.php
│   │   │   │   └── UserManagementController.php
│   │   │   ├── AssetController.php
│   │   │   ├── AuthController.php
│   │   │   ├── BacklogController.php
│   │   │   ├── ContractController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── FavoriteController.php
│   │   │   ├── JatuhTempoController.php
│   │   │   └── MapController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   ├── Models/
│   │   ├── Asset.php
│   │   ├── AssetImage.php
│   │   ├── ContractFinancial.php
│   │   ├── Favorite.php
│   │   ├── KaiAsset.php
│   │   ├── KaiContract.php
│   │   ├── MonthlySchedule.php
│   │   ├── Penyewa.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/          # File migrasi tabel database
│   ├── seeders/             # Data seeder (KaiDatabaseSeeder, UserSeeder, dsb.)
│   ├── factories/
│   └── test_project_kai.sql # SQL dump database (opsional)
├── public/
│   ├── images/              # Gambar statis (background, dsb.)
│   ├── js/                  # File JS statis (peta Indonesia, mapdata, dsb.)
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/           # View panel admin (assets, users)
│       ├── assets/          # View katalog, detail, explorer, edit aset
│       ├── auth/            # View login
│       ├── backlog/         # View backlog aset
│       ├── components/      # Komponen reusable (navbar, icon)
│       ├── contracts/       # View daftar kontrak
│       ├── dashboard/       # View dashboard utama
│       ├── favorites/       # View favorit
│       ├── faq/             # View FAQ
│       ├── jatuh-tempo/     # View monitoring jatuh tempo
│       ├── layout/          # Layout utama aplikasi
│       ├── map/             # View peta aset
│       └── settings/        # View pengaturan
├── routes/
│   ├── web.php              # Definisi routing aplikasi
│   └── console.php
├── config/                  # Konfigurasi Laravel (database, cache, mail, dsb.)
├── storage/                 # Log, cache, session, file upload
├── bootstrap/
├── tests/
├── .env.example
├── composer.json
├── package.json
└── vite.config.js
```

---

## Cara Menjalankan Project

### 1. Clone & Install Dependensi

```bash
# Clone repository (jika dari git)
git clone <url-repository>
cd test-project-kai

# Install dependensi PHP
composer install

# Install dependensi JavaScript
npm install
```

### 2. Konfigurasi Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit file `.env` sesuai kebutuhan, terutama konfigurasi database:

**Menggunakan SQLite (default):**
```env
DB_CONNECTION=sqlite
```
File database SQLite akan dibuat otomatis di `database/database.sqlite`.

**Menggunakan MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=password_anda
```

### 3. Setup Database

```bash
# Buat file SQLite (jika menggunakan SQLite)
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# (Opsional) Jalankan seeder untuk data awal
php artisan db:seed --class=DatabaseSeeder
```

Atau gunakan file SQL dump yang tersedia:
```bash
# Import SQL dump (untuk MySQL)
mysql -u root -p nama_database < database/test_project_kai.sql
```

### 4. Build Assets Frontend

```bash
# Development (dengan hot reload)
npm run dev

# Production build
npm run build
```

### 5. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## Akun Default (jika menggunakan seeder)

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@kai.id        | password |
| User  | user@kai.id         | password |

> Sesuaikan akun dengan isi `UserSeeder.php` jika berbeda.

---

## Perintah Artisan Berguna

```bash
# Jalankan server development
php artisan serve

# Reset dan jalankan ulang semua migrasi + seeder
php artisan migrate:fresh --seed

# Bersihkan cache aplikasi
php artisan optimize:clear

# Lihat semua route yang terdaftar
php artisan route:list
```

---

## Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Frontend**: Blade Templates, Vite
- **Database**: SQLite / MySQL
- **Map**: Custom JS (countrymap.js, indonesia.json)

---

## Lisensi

Project ini dikembangkan dalam rangka magang di PT. Kereta Api Indonesia (KAI).
