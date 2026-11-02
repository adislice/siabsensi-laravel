<?php

namespace App\Services;

use App\Models\Pegawai;

class AttendanceGeofenceService
{
    /**
     * Radius bumi rata-rata dalam meter.
     */
    private const EARTH_RADIUS_METERS = 6371008.8;

    /**
     * Toleransi kecil agar titik yang tepat berada di batas radius tetap diterima.
     */
    private const RADIUS_TOLERANCE_METERS = 0.001;

    /**
     * Hitung jarak antara dua koordinat memakai rumus Haversine.
     *
     * @return float Jarak dalam meter.
     */
    public function hitungJarakMeter(float $latitude1, float $longitude1, float $latitude2, float $longitude2): float
    {
        $lat1 = deg2rad($latitude1);
        $lat2 = deg2rad($latitude2);
        $selisih_lat = deg2rad($latitude2 - $latitude1);
        $selisih_lng = deg2rad($longitude2 - $longitude1);

        $a = sin($selisih_lat / 2) ** 2
            + cos($lat1) * cos($lat2) * sin($selisih_lng / 2) ** 2;

        // Jaga nilai a tetap pada rentang 0..1 agar aman dari galat pembulatan.
        $a = max(0, min(1, $a));

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_METERS * $c;
    }

    /**
     * Validasi koordinat pegawai terhadap lokasi absensi miliknya.
     *
     * @return array{valid: bool, distance: float|null, radius: float|null, message: string}
     */
    public function validasiLokasiPegawai(Pegawai $pegawai, float $latitude, float $longitude): array
    {
        $lokasi = $pegawai->lokasi_absensi;

        if (!$lokasi) {
            return [
                'valid' => false,
                'distance' => null,
                'radius' => null,
                'message' => 'Anda belum memiliki lokasi absensi. Hubungi admin untuk mengatur lokasi absensi terlebih dahulu.',
            ];
        }

        $latitude_lokasi = $lokasi->latitude;
        $longitude_lokasi = $lokasi->longitude;
        $radius_lokasi = $lokasi->radius;

        if (
            !is_numeric($latitude_lokasi) || $latitude_lokasi < -90 || $latitude_lokasi > 90
            || !is_numeric($longitude_lokasi) || $longitude_lokasi < -180 || $longitude_lokasi > 180
            || !is_numeric($radius_lokasi) || $radius_lokasi <= 0
        ) {
            return [
                'valid' => false,
                'distance' => null,
                'radius' => is_numeric($radius_lokasi) ? (float) $radius_lokasi : null,
                'message' => 'Data lokasi absensi belum valid. Hubungi admin untuk memperbaiki koordinat atau radius lokasi absensi.',
            ];
        }

        $radius = (float) $radius_lokasi;
        $jarak = $this->hitungJarakMeter(
            $latitude,
            $longitude,
            (float) $latitude_lokasi,
            (float) $longitude_lokasi
        );

        $jarak_dibulatkan = (int) round($jarak);
        $radius_dibulatkan = (int) round($radius);
        $nama_lokasi = $lokasi->nama_lokasi ?: 'lokasi absensi';

        if ($jarak > $radius + self::RADIUS_TOLERANCE_METERS) {
            return [
                'valid' => false,
                'distance' => round($jarak, 2),
                'radius' => round($radius, 2),
                'message' => sprintf(
                    'Lokasi Anda berada di luar radius absensi. Jarak Anda %d meter dari %s, sedangkan radius yang diizinkan %d meter.',
                    $jarak_dibulatkan,
                    $nama_lokasi,
                    $radius_dibulatkan
                ),
            ];
        }

        return [
            'valid' => true,
            'distance' => round($jarak, 2),
            'radius' => round($radius, 2),
            'message' => sprintf(
                'Lokasi Anda berada dalam radius absensi (jarak %d meter dari %s, radius %d meter).',
                $jarak_dibulatkan,
                $nama_lokasi,
                $radius_dibulatkan
            ),
        ];
    }
}
