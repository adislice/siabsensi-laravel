# Validasi Lokasi Absensi (Geofence)

Dokumen ini menjelaskan validasi lokasi/radius pada endpoint absensi API setelah perubahan geofence.

## Endpoint yang terpengaruh

- `POST /api/absensi-masuk`
- `POST /api/absensi-pulang`

Kedua endpoint tetap memakai autentikasi Sanctum/Bearer token dan tetap mengembalikan HTTP 200 dengan format `success`, `message`, dan `data` (jika ada). Kontrak respons sukses tidak berubah.

## Field baru

| Field | Tipe | Wajib | Rentang | Keterangan |
| --- | --- | --- | --- | --- |
| `latitude` | numeric | Ya | -90 s.d. 90 | Koordinat GPS pegawai (derajat desimal, WGS84) |
| `longitude` | numeric | Ya | -180 s.d. 180 | Koordinat GPS pegawai (derajat desimal, WGS84) |

Field lama (`jam_masuk`, `jam_pulang`, `tanggal`) tidak berubah. Kedua field koordinat wajib dikirim pada body request, bukan query string.

## Sumber lokasi dan radius

Lokasi dan radius diambil dari master **Lokasi Absensi** yang terhubung ke pegawai:

1. `pegawai.id_lokasi_absensi` menunjuk ke `lokasi_absensi.id_lokasi_absensi`.
2. `lokasi_absensi.latitude` dan `lokasi_absensi.longitude` menjadi titik pusat.
3. `lokasi_absensi.radius` adalah radius yang diizinkan **dalam meter** (default form admin adalah 100).

Jika pegawai belum memiliki `id_lokasi_absensi`, atau data lokasinya tidak lengkap/tidak valid, absensi ditolak. Perubahan data di menu admin Lokasi Absensi langsung berlaku pada request berikutnya.

## Urutan validasi

1. Validasi field `latitude` dan `longitude` (wajib, numerik, rentang valid).
2. Ambil data pegawai beserta relasi `lokasi_absensi`.
3. Tolak jika pegawai tidak punya lokasi absensi.
4. Hitung jarak Haversine antara koordinat pegawai dan titik lokasi.
5. Tolak jika jarak melebihi radius. Titik yang tepat berada di batas radius tetap diterima (toleransi pembulatan 1 mm).
6. Jika lokasi valid, lanjutkan logika lama: cek jam absensi, status absensi aktif, absensi ganda, dan penyimpanan data.

Pemeriksaan lokasi dijalankan **sebelum** pemeriksaan jam/status. Artinya pegawai di luar radius akan mendapat pesan radius walaupun jam absensi saat itu juga tidak valid atau ia sudah absen.

## Contoh request

### Absensi masuk

```http
POST /api/absensi-masuk
Authorization: Bearer <token>
Content-Type: application/json
Accept: application/json

{
  "jam_masuk": "07:45",
  "tanggal": "2026-11-02",
  "latitude": -6.9096320,
  "longitude": 109.6952180
}
```

### Absensi pulang

```http
POST /api/absensi-pulang
Authorization: Bearer <token>
Content-Type: application/json
Accept: application/json

{
  "jam_pulang": "16:30",
  "tanggal": "2026-11-02",
  "latitude": -6.9096320,
  "longitude": 109.6952180
}
```

## Respons sukses

Lokasi valid dan jam absensi sesuai:

```json
{
  "success": true,
  "message": "Absensi masuk berhasil"
}
```

Absensi pulang:

```json
{
  "success": true,
  "message": "Absensi pulang berhasil"
}
```

## Respons gagal

Semua error bisnis/validasi memakai HTTP 200 dengan `success: false`.

### Di luar radius

```json
{
  "success": false,
  "message": "Lokasi Anda berada di luar radius absensi. Jarak Anda 150 meter dari Kantor Simatupang, sedangkan radius yang diizinkan 100 meter.",
  "data": {
    "distance": 150.0,
    "radius": 100.0
  }
}
```

`distance` adalah jarak hasil perhitungan Haversine dalam meter (dibulatkan 2 desimal). `radius` adalah radius dari master lokasi.

### Pegawai belum punya lokasi absensi

```json
{
  "success": false,
  "message": "Anda belum memiliki lokasi absensi. Hubungi admin untuk mengatur lokasi absensi terlebih dahulu.",
  "data": {
    "distance": null,
    "radius": null
  }
}
```

### Data master lokasi tidak valid

```json
{
  "success": false,
  "message": "Data lokasi absensi belum valid. Hubungi admin untuk memperbaiki koordinat atau radius lokasi absensi.",
  "data": {
    "distance": null,
    "radius": 0.0
  }
}
```

### Field koordinat tidak dikirim/tidak valid

```json
{
  "success": false,
  "message": "Koordinat latitude wajib dikirim."
}
```

Contoh pesan lain:

- `Koordinat latitude harus berupa angka.`
- `Koordinat latitude harus berada di antara -90 dan 90.`
- `Koordinat longitude wajib dikirim.`
- `Koordinat longitude harus berada di antara -180 dan 180.`

Jika beberapa field salah sekaligus, pesan digabung dengan newline (mengikuti helper validasi yang sudah dipakai endpoint lain).

### Error lama

Pesan lama tetap sama ketika lokasi valid, misalnya:

- `Absensi hari ini ditutup`
- `Anda sudah absen masuk hari ini`
- `Bukan waktu absensi masuk. Absensi masuk dibuka pada ...`
- `Anda belum absensi masuk hari ini`
- `Anda sudah absensi pulang hari ini`
- `Bukan waktu absensi pulang. Absensi pulang dibuka pada ...`

## Catatan untuk aplikasi mobile

- Aplikasi **wajib** mengirim `latitude` dan `longitude` pada setiap request absensi masuk/pulang. Aplikasi versi lama yang belum mengirim field tersebut akan ditolak dengan pesan validasi, bukan lagi berhasil.
- Koordinat harus berasal dari GPS perangkat dalam derajat desimal (WGS84), bukan alamat atau nama tempat. Pastikan izin lokasi sudah diberikan dan GPS aktif sebelum request dikirim.
- Jangan mengirim `null`, string kosong, atau koordinat `0,0` sebagai pengganti lokasi yang tidak tersedia. `0,0` secara teknis valid dan akan dihitung sebagai titik di Samudra Atlantik.
- Akurasi GPS di dalam gedung dapat membesar. Radius master sebaiknya disesuaikan dengan kondisi lokasi; nilai radius kecil (misalnya 10-20 meter) berisiko menolak pegawai yang sebenarnya berada di kantor.
- Pegawai harus sudah di-assign ke salah satu Lokasi Absensi oleh admin. Tanpa assignment, absensi selalu ditolak.
- Validasi ini hanya memeriksa koordinat yang dikirim klien. Aplikasi mobile tetap menjadi sumber koordinat, sehingga risiko manipulasi GPS di sisi perangkat belum ditangani oleh backend.

## Pengujian

Unit test service tersedia di `tests/Unit/AttendanceGeofenceServiceTest.php` dan mencakup:

- jarak dua titik yang sama;
- jarak Haversine pada titik referensi;
- lokasi di dalam radius;
- lokasi di luar radius;
- lokasi tepat di batas radius;
- pegawai tanpa lokasi absensi.

Jalankan dengan:

```bash
php artisan test --filter=AttendanceGeofenceServiceTest
```

Rumus Haversine juga diuji numerik dengan Node pada beberapa jarak (50 m, 100 m, 100,1 m, 150 m) dan menghasilkan jarak sesuai toleransi pembulatan.
