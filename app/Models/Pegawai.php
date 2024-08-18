<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'id_pegawai', 
        'nama_pegawai', 
        'nip', 
        'jenis_kelamin', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'alamat', 
        'id_jabatan', 
        'id_lokasi_absensi',
        'no_telp',
        'status',
        'foto',
        'password'
    ];

    protected $appends = ['foto_url'];

    //hide password
    protected $hidden = [
        'password',
    ];

    // accessor
    public function fotoUrl(): Attribute {
        return new Attribute(
            get: fn() => $this->foto ? url($this->foto) : null
        );
    }

    // relationship
    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function absensi() {
        return $this->hasMany(Absensi::class, 'id_pegawai', 'id_pegawai');
    }

    public function cuti() {
        return $this->hasMany(Cuti::class, 'id_pegawai', 'id_pegawai');
    }

    public function izin() {
        return $this->hasMany(Izin::class, 'id_pegawai', 'id_pegawai');
    }

    public function lokasi_absensi() {
        return $this->belongsTo(LokasiAbsensi::class, 'id_lokasi_absensi', 'id_lokasi_absensi');
    }
}
