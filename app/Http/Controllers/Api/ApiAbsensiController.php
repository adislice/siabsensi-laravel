<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $id_pegawai = auth()->user()->id_pegawai;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $absensi_query = Absensi::where('id_pegawai', $id_pegawai);

        if ($bulan && $tahun) {
            $absensi_query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } else {
            $absensi_query->whereMonth('tanggal', date('m'))->whereYear('tanggal', date('Y'));
        }

        $data_absensi = $absensi_query->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data_absensi
        ]);
    }

    public function absensiMasuk(Request $request)
    {
        try {
            $id_pegawai = auth()->user()->id_pegawai;
            $jam_masuk = Carbon::createFromTimeString($request->jam_masuk);
            $tanggal = $request->tanggal;

            $is_absensi_aktif = $this->getKonfigurasi('is_absensi_aktif');

            if (!$is_absensi_aktif) {
                return response()->json([
                    'success' => false,
                    'message' => 'Absensi hari ini ditutup'
                ]);
            }

            $cek = Absensi::where('id_pegawai', $id_pegawai)->whereDate('tanggal', $tanggal)->first();
            if ($cek) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen masuk hari ini'
                ]);
            }

            $jam_masuk_dari = Carbon::createFromTimeString($this->getKonfigurasi('jam_masuk_dari'));
            $jam_masuk_sampai = Carbon::createFromTimeString($this->getKonfigurasi('jam_masuk_sampai'));
            $jam_max_terlambat = Carbon::createFromTimeString($this->getKonfigurasi('jam_max_terlambat'));

            $data_absensi = [
                'id_pegawai' => $id_pegawai,
                'tanggal' => $tanggal,
                'jam_masuk' => $request->jam_masuk,
                'latitude_masuk' => $request->latitude_masuk,
                'longitude_masuk' => $request->longitude_masuk,
            ];

            if ($jam_masuk->between($jam_masuk_dari, $jam_masuk_sampai)) {
                Absensi::create($data_absensi);
                return response()->json([
                    'success' => true,
                    'message' => 'Absensi masuk berhasil'
                ]);
            } elseif ($jam_masuk->greaterThan($jam_masuk_sampai) && $jam_masuk->lessThan($jam_max_terlambat)) {
                $terlambat_menit = $jam_masuk->diffInMinutes($jam_masuk_sampai);
                $data_absensi['terlambat_menit'] = $terlambat_menit;
                Absensi::create($data_absensi);
                return response()->json([
                    'success' => true,
                    'message' => 'Absensi masuk berhasil, terlambat ' . $terlambat_menit . ' menit'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Bukan waktu absensi masuk. Absensi masuk dibuka pada ' . $jam_masuk_dari->format('H:i') . ' sampai ' . $jam_masuk_sampai->format('H:i') . ' dengan maksimal terlambat ' . $jam_max_terlambat->format('H:i')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function absensiPulang(Request $request)
    {
        $id_pegawai = auth()->user()->id_pegawai;
        $jam_pulang = Carbon::createFromTimeString($request->jam_pulang);
        $tanggal = $request->tanggal;

        $cek_absensi_masuk = Absensi::where('id_pegawai', $id_pegawai)->whereDate('tanggal', $tanggal)->first();
        if (!$cek_absensi_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum absensi masuk hari ini'
            ]);
        }

        $cek_absensi_pulang = Absensi::where('id_pegawai', $id_pegawai)->whereDate('tanggal', $tanggal)->whereNotNull('jam_pulang')->first();
        if ($cek_absensi_pulang) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah absensi pulang hari ini'
            ]);
        }

        $jam_pulang_dari = Carbon::createFromTimeString($this->getKonfigurasi('jam_pulang_dari'));
        $jam_pulang_sampai = Carbon::createFromTimeString($this->getKonfigurasi('jam_pulang_sampai'));

        if ($jam_pulang->between($jam_pulang_dari, $jam_pulang_sampai)) {
            Absensi::where('id_pegawai', $id_pegawai)
                ->whereDate('tanggal', $tanggal)
                ->update([
                    'jam_pulang' => $request->jam_pulang,
                    'latitude_pulang' => $request->latitude_pulang,
                    'longitude_pulang' => $request->longitude_pulang,
                    'status' => 'hadir',
                ]);
            return response()->json([
                'success' => true,
                'message' => 'Absensi pulang berhasil'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Bukan waktu absensi pulang. Absensi pulang dibuka pada ' . $jam_pulang_dari->format('H:i') . ' sampai ' . $jam_pulang_sampai->format('H:i')
            ]);
        }
    }
}
