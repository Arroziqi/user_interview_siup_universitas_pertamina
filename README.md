````markdown
# Sistem Manajemen Program Studi

Aplikasi manajemen data Program Studi dan Fakultas berbasis Laravel (REST API) dan Vue.js untuk frontend-nya.

## Fitur

✅ CRUD **Program Studi**  
✅ Relasi dengan **Fakultas** (melalui `faculty_id`)  
❌ CRUD Fakultas belum tersedia di UI  
⚠️ Bug: Setelah **update program studi**, nama fakultas belum langsung tampil kecuali halaman di-_reload_ (lihat Catatan Bug)

---

## Instalasi

### 1. Clone project

```bash
git clone https://github.com/namamu/nama-repo.git
cd nama-repo
```
````

### 2. Instalasi Laravel Backend

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 3. Setup database

Edit `.env` dan isi konfigurasi database:

```
DB_DATABASE=namadb
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

Seeder ini akan otomatis mengisi beberapa data awal Fakultas (lihat `DatabaseSeeder`).

### 4. Jalankan Laravel server

```bash
composer run dev
```

---

---

## Endpoint API

-   `GET /api/programs` — Menampilkan semua program studi beserta fakultasnya
-   `POST /api/programs` — Menambahkan program studi
-   `PUT /api/programs/{id}` — Mengubah program studi
-   `DELETE /api/programs/{id}` — Menghapus program studi
-   `GET /api/faculties` — Menampilkan daftar fakultas

---

## Catatan Bug

-   Setelah melakukan **update program studi**, data yang dikembalikan tidak langsung menyertakan relasi `faculty`. Akibatnya, nama fakultas tidak langsung tampil di tampilan frontend tanpa _reload_.
    👉 Solusi sementara: frontend dapat memanggil ulang `GET /api/programs` setelah update.
    👉 Solusi ideal: backend perlu memuat relasi `faculty` sebelum mengirim response update.

---

## Struktur Direktori Penting

```
├── app/
│   ├── Models/
│   │   ├── Program.php
│   │   └── Faculty.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ProgramController.php
│   │       └── FacultyController.php
│   └── Services/
│       └── ProgramService.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── FacultySeeder.php
├── routes/
│   └── api.php
└── resources/js/components
    └── ProgramList.vue
```
