# SiAbsensi

SiAbsensi adalah sistem informasi absensi pegawai berbasis Laravel. Repositori ini berisi dua bagian utama:

- **Dashboard admin** untuk mengelola data pegawai, jabatan, lokasi absensi, absensi harian, pengajuan izin/cuti, dan konfigurasi jam absensi.
- **REST API pegawai** untuk aplikasi mobile, meliputi login, profil, absensi masuk/pulang, riwayat absensi, serta pengajuan izin dan cuti.

Aplikasi mobile pegawai dikembangkan terpisah dan menggunakan API dari repositori ini.

## Fitur

### Dashboard admin

- **Ringkasan dan statistik**: jumlah pegawai, persentase kehadiran, jumlah cuti dan izin, serta grafik kehadiran bulan berjalan untuk hari kerja.
- **Master pegawai**: tambah, lihat, ubah, dan hapus data pegawai, termasuk foto, jabatan, lokasi absensi, status aktif/nonaktif, serta pencarian berdasarkan nama.
- **Master jabatan**: pengelolaan data jabatan yang dipakai oleh pegawai.
- **Lokasi absensi**: pengelolaan lokasi dengan koordinat latitude/longitude dan radius dalam meter. Peta memakai Leaflet dengan tile OpenStreetMap.
- **Data absensi per tanggal**: daftar seluruh pegawai pada tanggal yang dipilih, filter berdasarkan NIP, serta penambahan atau perubahan status **hadir**, **alfa**, **izin**, dan **cuti**.
- **Export Excel**: unduh data absensi berdasarkan rentang tanggal. Kolom yang diekspor: No, Nama Pegawai, NIP, Tanggal, Jam Masuk, Jam Pulang, dan Status.
- **Persetujuan izin**: daftar dan detail pengajuan izin, serta persetujuan atau penolakan. Izin yang disetujui otomatis dicatat sebagai absensi berstatus `izin` pada tanggal terkait.
- **Persetujuan cuti**: daftar dan detail pengajuan cuti, persetujuan dengan lampiran persetujuan, atau penolakan dengan alasan. Cuti yang disetujui otomatis dicatat sebagai absensi berstatus `cuti` untuk tanggal-tanggal dalam rentang cuti.
- **Konfigurasi jam absensi**: pengaturan jam masuk, jam pulang, dan status aktif/nonaktif absensi.

### API pegawai

- **Login** memakai NIP dan password, menghasilkan token Sanctum.
- **Profil pegawai** beserta jabatan dan lokasi absensi.
- **Absensi masuk dan pulang** dengan validasi jam absensi, pencegahan absensi ganda, dan validasi geofence.
- **Riwayat absensi** per bulan dan tahun.
- **Pengajuan izin** serta daftar riwayat izin.
- **Pengajuan cuti** dengan lampiran, daftar riwayat, detail, perubahan, dan penghapusan pengajuan.

### Geofence

Endpoint `POST /api/absensi-masuk` dan `POST /api/absensi-pulang` mewajibkan field `latitude` dan `longitude`. Koordinat pegawai divalidasi terhadap **lokasi absensi milik pegawai** (`pegawai.id_lokasi_absensi`), memakai titik pusat dan radius (meter) dari master lokasi tersebut. Jarak dihitung dengan rumus Haversine.

Validasi lokasi dijalankan sebelum pengecekan jam absensi dan status absensi. Detail field, contoh request/respons, dan catatan integrasi mobile tersedia di [docs/validasi-lokasi-absensi.md](docs/validasi-lokasi-absensi.md).

## Peran Pengguna

| Peran | Kredensial | Guard | Akses |
| --- | --- | --- | --- |
| Admin | Email dan password | `web` (session) | Dashboard admin |
| Pegawai | NIP dan password | `api` (Sanctum Bearer token) | REST API pegawai |

Admin tidak memiliki fitur registrasi mandiri. Akun admin dibuat melalui seeder atau data awal database. Pegawai juga tidak mendaftar sendiri; akunnya dibuat oleh admin melalui dashboard.

## Teknologi

- **Laravel 10** (`laravel/framework ^10.10`) dengan **PHP >= 8.1**
- **MySQL** atau **MariaDB**
- **Blade** dan **Livewire 3** untuk dashboard admin
- **Laravel Sanctum 3** untuk autentikasi API
- **Maatwebsite Excel 3** untuk export data absensi
- **Leaflet** dengan tile **OpenStreetMap** untuk peta lokasi absensi
- **Vite 5** dan npm untuk aset frontend
- Bootstrap 5 dan Chart.js untuk tampilan dashboard

## Kebutuhan Sistem

- PHP **8.1 atau lebih baru**
- Composer **2**
- Node.js **18 atau lebih baru** dan npm
- MySQL atau MariaDB
- Web server (Apache/Nginx) atau `php artisan serve` untuk pengembangan
- Ekstensi PHP umum untuk Laravel (antara lain `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, dan `fileinfo`). Untuk export Excel, pastikan ekstensi `zip` dan `gd` aktif.

## Instalasi

1. Clone repositori dan masuk ke direktori proyek.

   ```bash
   git clone <url-repositori> siabsensi-laravel
   cd siabsensi-laravel
   ```

2. Pasang dependensi PHP dan buat file environment.

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

   Di Windows, gunakan `copy .env.example .env`.

3. Siapkan database MySQL/MariaDB, lalu sesuaikan konfigurasi di `.env`.

   ```dotenv
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_sistemabsensi
   DB_USERNAME=<user-database>
   DB_PASSWORD=<password-database>
   ```

   Contoh membuat database:

   ```sql
   CREATE DATABASE db_sistemabsensi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. Jalankan migrasi dan seeder.

   ```bash
   php artisan migrate --seed
   ```

5. Buat symbolic link storage agar foto pegawai dan lampiran dapat diakses.

   ```bash
   php artisan storage:link
   ```

6. Pasang dependensi frontend dan jalankan Vite.

   ```bash
   npm install
   npm run dev
   ```

   Untuk build produksi, gunakan `npm run build`.

7. Jalankan server pengembangan di terminal terpisah.

   ```bash
   php artisan serve
   ```

   Dashboard dapat dibuka di `http://localhost:8000`.

## Akun dari Seeder

| Akun | Kredensial | Keterangan |
| --- | --- | --- |
| Admin | `admin@gmail.com` / `admin123` | Login dashboard admin |
| Pegawai contoh | NIP `1` / `password` | Login API pegawai |
| 50 pegawai dummy | NIP acak / `password` | Data contoh untuk pengujian |
| Lokasi contoh | Kantor Simatupang | Latitude `-6.9096320`, longitude `109.6952180`, radius `50` meter |

Seeder juga membuat dua jabatan contoh (Frontend Developer dan Backend Developer) serta riwayat absensi untuk 50 pegawai pertama sejak 1 Januari 2024 sampai kemarin. Karena jumlah datanya cukup banyak, proses seeding dapat memakan waktu.

> **Peringatan:** `admin123` dan `password` adalah kredensial demo. Segera ganti password setelah instalasi dan jangan pernah memakai kredensial default di lingkungan produksi.

Catatan: seeder mengisi atribut `nama_admin` pada `Admin::create`, sedangkan `$fillable` model `Admin` memakai `nama_user`. Pada MySQL dengan mode strict, `php artisan migrate --seed` dapat berhenti saat membuat akun admin. Jika itu terjadi, samakan nama atribut dengan kolom tabel `admin`, lalu jalankan ulang seeder.

## Struktur Proyek

```text
app/
├── Exports/
│   └── AbsensiExport.php          # Export absensi ke Excel
├── Http/Controllers/
│   ├── Api/                       # Controller REST API pegawai
│   └── Web/                       # Controller dashboard admin
├── Livewire/
│   └── LoginForm.php              # Form login admin
├── Models/                        # Admin, Pegawai, Jabatan, Absensi,
│                                  # Izin, Cuti, LokasiAbsensi, Konfigurasi
├── Services/
│   └── AttendanceGeofenceService.php  # Perhitungan Haversine dan validasi radius
└── Utils/                         # Konstanta dan helper

database/
├── migrations/                    # Skema tabel
└── seeders/DatabaseSeeder.php     # Data awal dan akun demo

docs/
└── validasi-lokasi-absensi.md     # Dokumentasi teknis geofence

resources/views/
├── layouts/                       # Layout dashboard
├── livewire/                      # Komponen Livewire
├── pages/auth/                    # Halaman login
├── pages/dashboard/               # Halaman dashboard admin
└── partials/                      # Sidebar dan navbar

routes/
├── api.php                        # Endpoint API pegawai
└── web.php                        # Route dashboard admin

tests/
├── Feature/
└── Unit/AttendanceGeofenceServiceTest.php
```

## Endpoint API

Base URL pengembangan: `http://localhost:8000/api`.

Semua endpoint selain login memerlukan header berikut:

```http
Authorization: Bearer <token>
Accept: application/json
```

Token diperoleh dari `POST /api/login` dan disimpan di tabel `personal_access_tokens`.

| Method | Endpoint | Autentikasi | Keterangan |
| --- | --- | --- | --- |
| POST | `/api/login` | Tidak | Login dengan `nip` dan `password`; mengembalikan token Sanctum |
| POST | `/api/loginWithToken` | Bearer token | Mengambil data pegawai dan info jam absensi dengan token aktif |
| GET | `/api/logout` | Bearer token | Menghapus seluruh token milik pegawai |
| GET | `/api/profil` | Bearer token | Profil pegawai beserta jabatan dan lokasi absensi |
| GET | `/api/absensi?bulan=&tahun=` | Bearer token | Riwayat absensi; tanpa parameter memakai bulan dan tahun berjalan |
| POST | `/api/absensi-masuk` | Bearer token | Absen masuk; wajib mengirim koordinat |
| POST | `/api/absensi-pulang` | Bearer token | Absen pulang; wajib mengirim koordinat |
| GET | `/api/izin?status=` | Bearer token | Daftar izin pegawai, filter status opsional |
| POST | `/api/izin/add` | Bearer token | Ajukan izin |
| POST | `/api/izin/{id}/update` | Bearer token | Ubah pengajuan izin |
| POST | `/api/izin/{id}/delete` | Bearer token | Hapus pengajuan izin |
| GET | `/api/cuti?status=` | Bearer token | Daftar cuti pegawai beserta URL lampiran |
| GET | `/api/cuti/{id}` | Bearer token | Detail pengajuan cuti |
| POST | `/api/cuti/add` | Bearer token | Ajukan cuti dengan lampiran (multipart/form-data) |
| POST | `/api/cuti/{id}/update` | Bearer token | Ubah pengajuan cuti; lampiran baru opsional |
| POST | `/api/cuti/{id}/delete` | Bearer token | Hapus pengajuan cuti |

Catatan: logout pada `routes/api.php` memakai method **GET**, bukan POST.

Field utama yang dikirim:

- **Login**: `nip`, `password`
- **Absensi masuk**: `tanggal`, `jam_masuk`, `latitude`, `longitude`
- **Absensi pulang**: `tanggal`, `jam_pulang`, `latitude`, `longitude`
- **Izin**: `tanggal`, `alasan`
- **Cuti**: `tanggal_mulai`, `tanggal_selesai`, `alasan`, `lampiran` (file)

Semua respons API memakai format JSON dengan properti `success`. Error validasi dan error bisnis dikembalikan dengan HTTP 200 dan `success: false`, disertai `message`.

### Contoh Login

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "nip": "1",
    "password": "password"
  }'
```

Contoh respons (disederhanakan):

```json
{
  "success": true,
  "data": {
    "pegawai": {
      "id_pegawai": 1,
      "nip": "1",
      "nama_pegawai": "Rudy Zen"
    },
    "auth_token": "<token>",
    "info_absensi": {
      "jam_masuk_dari": "08:00:00",
      "jam_masuk_sampai": "09:00:00",
      "jam_pulang_dari": "16:00:00",
      "jam_pulang_sampai": "17:00:00"
    }
  }
}
```

Gunakan token tersebut untuk endpoint lain:

```bash
curl http://localhost:8000/api/profil \
  -H "Authorization: Bearer <token>" \
  -H "Accept: application/json"
```

### Contoh Absensi Masuk

```bash
curl -X POST http://localhost:8000/api/absensi-masuk \
  -H "Authorization: Bearer <token>" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "tanggal": "2026-11-02",
    "jam_masuk": "07:45",
    "latitude": -6.9096320,
    "longitude": 109.6952180
  }'
```

## Geofence dan Validasi Lokasi

- `latitude` dan `longitude` **wajib** dikirim di body request absensi masuk dan pulang, bukan di query string.
- Latitude harus numerik antara `-90` sampai `90`; longitude antara `-180` sampai `180`.
- Titik pusat dan radius diambil dari master **Lokasi Absensi** yang terhubung ke pegawai melalui `id_lokasi_absensi`.
- Radius disimpan dalam **meter**. Jarak dihitung dengan rumus Haversine; titik yang tepat berada di batas radius tetap diterima.
- Jika pegawai belum memiliki lokasi absensi atau data lokasinya tidak valid, absensi ditolak.
- Jika koordinat berada di luar radius, respons menyertakan `data.distance` dan `data.radius` dalam meter.

Contoh respons di luar radius:

```json
{
  "success": false,
  "message": "Lokasi Anda berada di luar radius absensi. Jarak Anda 150 meter dari Kantor Simatupang, sedangkan radius yang diizinkan 50 meter.",
  "data": {
    "distance": 150.0,
    "radius": 50.0
  }
}
```

Dokumentasi lengkap, termasuk urutan validasi dan contoh respons lain, ada di [docs/validasi-lokasi-absensi.md](docs/validasi-lokasi-absensi.md).

## Testing

Jalankan seluruh test:

```bash
php artisan test
```

Jalankan test khusus layanan geofence:

```bash
php artisan test --filter=AttendanceGeofenceServiceTest
```

Test geofence mencakup jarak titik yang sama, perhitungan Haversine pada titik referensi, lokasi di dalam radius, lokasi di luar radius, lokasi tepat di batas radius, dan pegawai tanpa lokasi absensi.

## Catatan dan Batasan

- Repositori ini hanya berisi **backend dan dashboard admin**. Aplikasi mobile pegawai berada di repositori terpisah.
- Aplikasi mobile lama yang belum mengirim `latitude` dan `longitude` akan ditolak oleh endpoint absensi. Aplikasi harus diperbarui agar selalu mengirim koordinat GPS perangkat.
- Validasi geofence hanya memeriksa koordinat yang dikirim klien. Manipulasi atau spoofing GPS di perangkat **belum** ditangani oleh backend.
- Panduan integrasi geofence untuk aplikasi mobile: [docs/validasi-lokasi-absensi.md](docs/validasi-lokasi-absensi.md).
- Dashboard admin memakai session guard `web`, sedangkan API pegawai memakai Sanctum guard `api`. Keduanya memakai tabel pengguna yang berbeda.

## License

Dirilis dengan lisensi **MIT**.
