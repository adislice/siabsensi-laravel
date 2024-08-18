<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'jam_masuk', 
        'jam_pulang', 
        'status', 
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
