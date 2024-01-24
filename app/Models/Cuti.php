<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = 'cuti';
    protected $primaryKey = 'id_cuti';
    protected $fillable = [
        'id_pegawai',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'alasan_ditolak',
        'lampiran',
        'lampiran_disetujui',
        'status'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

}
