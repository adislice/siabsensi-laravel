<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = ['id_pegawai', 'tanggal', 'jam_masuk', 'jam_pulang', 'latitude_masuk', 'longitude_masuk', 'latitude_pulang', 'longitude_pulang', 'status', 'terlambat_menit'];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
