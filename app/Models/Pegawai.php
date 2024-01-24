<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $fillable = ['id_pegawai', 'nama_pegawai', 'nip', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'id_jabatan', 'password'];

    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function absensi() {
        return $this->hasMany(Absensi::class, 'id_pegawai', 'id_pegawai');
    }

    public function cuti() {
        return $this->hasMany(Cuti::class, 'id_pegawai', 'id_pegawai');
    }
}
