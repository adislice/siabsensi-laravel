<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'izin';
    protected $primaryKey = 'id_izin';

    protected $fillable = [
        'id_pegawai',
        'tanggal',
        'alasan',
        'alasan_ditolak',
        'status'
    ];

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    // cast tinyint to boolean
    protected $casts = [
        'sepanjang_hari' => 'boolean'
    ];
}
