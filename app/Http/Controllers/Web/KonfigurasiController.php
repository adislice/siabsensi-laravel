<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Konfigurasi;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    public function index()
    {
        $konfigurasi = Konfigurasi::latest()->first();

        return view('pages.dashboard.konfigurasi.index', compact('konfigurasi'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'jam_masuk_dari' => 'required',
            'jam_masuk_sampai' => 'required',
            'jam_pulang_dari' => 'required',
            'jam_pulang_sampai' => 'required',
            'is_absensi_aktif' => 'required'
        ]);

        
        Konfigurasi::query()->delete();

        Konfigurasi::create([
            'jam_masuk_dari' => $request->jam_masuk_dari,
            'jam_masuk_sampai' => $request->jam_masuk_sampai,
            'jam_pulang_dari' => $request->jam_pulang_dari,
            'jam_pulang_sampai' => $request->jam_pulang_sampai,
            'is_absensi_aktif' => $request->is_absensi_aktif
        ]);

        return redirect()->back()->with('success', 'Konfigurasi berhasil disimpan');
    }
}
