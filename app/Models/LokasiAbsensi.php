<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiAbsensi extends Model
{
    protected $table = 'lokasi_absensi';
    protected $primaryKey = 'id_lokasi_absensi';
    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius'
    ];

    public function pegawai() {
        return $this->hasMany(Pegawai::class, 'id_lokasi_absensi', 'id_lokasi_absensi');
    }
}
