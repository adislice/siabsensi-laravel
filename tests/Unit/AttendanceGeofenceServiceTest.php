<?php

namespace Tests\Unit;

use App\Models\LokasiAbsensi;
use App\Models\Pegawai;
use App\Services\AttendanceGeofenceService;
use PHPUnit\Framework\TestCase;

class AttendanceGeofenceServiceTest extends TestCase
{
    private const EARTH_RADIUS_METERS = 6371008.8;
    private const LATITUDE_KANTOR = -6.9096320;
    private const LONGITUDE_KANTOR = 109.6952180;

    private AttendanceGeofenceService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new AttendanceGeofenceService();
    }

    public function test_menghitung_jarak_dua_titik_yang_sama(): void
    {
        $jarak = $this->service->hitungJarakMeter(
            self::LATITUDE_KANTOR,
            self::LONGITUDE_KANTOR,
            self::LATITUDE_KANTOR,
            self::LONGITUDE_KANTOR
        );

        $this->assertEqualsWithDelta(0.0, $jarak, 0.0001);
    }

    public function test_menghitung_jarak_haversine_pada_titik_yang_diketahui(): void
    {
        // Monas ke Bundaran HI, jarak referensi sekitar 2165 meter.
        $jarak = $this->service->hitungJarakMeter(
            -6.175392,
            106.827153,
            -6.1944,
            106.8229
        );

        $this->assertEqualsWithDelta(2165.26, $jarak, 0.01);
    }

    public function test_menerima_lokasi_di_dalam_radius(): void
    {
        $pegawai = $this->buatPegawai(100);

        $hasil = $this->service->validasiLokasiPegawai(
            $pegawai,
            $this->latitudePadaJarak(50),
            self::LONGITUDE_KANTOR
        );

        $this->assertTrue($hasil['valid']);
        $this->assertEqualsWithDelta(50.0, $hasil['distance'], 0.1);
        $this->assertSame(100.0, $hasil['radius']);
    }

    public function test_menolak_lokasi_di_luar_radius(): void
    {
        $pegawai = $this->buatPegawai(100);

        $hasil = $this->service->validasiLokasiPegawai(
            $pegawai,
            $this->latitudePadaJarak(150),
            self::LONGITUDE_KANTOR
        );

        $this->assertFalse($hasil['valid']);
        $this->assertEqualsWithDelta(150.0, $hasil['distance'], 0.1);
        $this->assertSame(100.0, $hasil['radius']);
        $this->assertStringContainsString('150 meter', $hasil['message']);
        $this->assertStringContainsString('100 meter', $hasil['message']);
        $this->assertStringContainsString('Kantor Uji', $hasil['message']);
    }

    public function test_menerima_lokasi_tepat_di_batas_radius(): void
    {
        $pegawai = $this->buatPegawai(100);

        $hasil = $this->service->validasiLokasiPegawai(
            $pegawai,
            $this->latitudePadaJarak(100),
            self::LONGITUDE_KANTOR
        );

        $this->assertTrue($hasil['valid']);
        $this->assertEqualsWithDelta(100.0, $hasil['distance'], 0.01);
    }

    public function test_menolak_pegawai_tanpa_lokasi_absensi(): void
    {
        $pegawai = $this->buatPegawai(null);

        $hasil = $this->service->validasiLokasiPegawai(
            $pegawai,
            self::LATITUDE_KANTOR,
            self::LONGITUDE_KANTOR
        );

        $this->assertFalse($hasil['valid']);
        $this->assertNull($hasil['distance']);
        $this->assertNull($hasil['radius']);
        $this->assertStringContainsString('belum memiliki lokasi absensi', $hasil['message']);
    }

    private function buatPegawai(?int $radius): Pegawai
    {
        $pegawai = new Pegawai();

        if ($radius === null) {
            $pegawai->setRelation('lokasi_absensi', null);

            return $pegawai;
        }

        $lokasi = new LokasiAbsensi([
            'nama_lokasi' => 'Kantor Uji',
            'latitude' => self::LATITUDE_KANTOR,
            'longitude' => self::LONGITUDE_KANTOR,
            'radius' => $radius,
        ]);

        $pegawai->setRelation('lokasi_absensi', $lokasi);

        return $pegawai;
    }

    private function latitudePadaJarak(float $meter): float
    {
        return self::LATITUDE_KANTOR + rad2deg($meter / self::EARTH_RADIUS_METERS);
    }
}
