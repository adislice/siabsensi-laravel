<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi';
    protected $fillable = [
        'lokasi_absensi_latitude',
        'lokasi_absensi_longitude',
        'radius_absensi',
        'jam_masuk_dari',
        'jam_masuk_sampai',
        'jam_pulang_dari',
        'jam_pulang_sampai',
        'is_absensi_aktif',
    ];

    protected $casts = [
        'is_absensi_aktif' => 'boolean'
    ];
}
