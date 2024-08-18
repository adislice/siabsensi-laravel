<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Pegawai;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function index() {
        $jml_pegawai = Pegawai::count();
        $absensi = Absensi::all();
        $total_absensi = $absensi->count();
        $jml_hadir = $absensi->where('status', 'hadir')->count();
        $persentase_hadir = $jml_hadir / $total_absensi * 100;
        $jml_izin = Izin::count();
        $jml_cuti = Cuti::count();
        
        $currentMonth = Carbon::now();
        $startOfMonth = $currentMonth->copy()->startOfMonth();
        $endOfMonth = $currentMonth->copy()->endOfMonth();

        $allDates = [];
        $period = Carbon::parse($startOfMonth)->toPeriod($endOfMonth);

        foreach ($period as $date) {
            if ($date->isWeekend()) {
                continue;
            }
            $allDates[$date->format('Y-m-d')] = 0; // Set default nilai 0 untuk setiap tanggal
        }

        $hadirData = Absensi::selectRaw('DATE(tanggal) as date, COUNT(*) as jumlah_hadir')
            ->where('status', 'hadir')
            ->where('tanggal', 'like', $currentMonth->format('Y-m') . '%')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('jumlah_hadir', 'date')
            ->toArray();

        foreach ($allDates as $date => $count) {
            if (isset($hadirData[$date])) {
                $allDates[$date] = $hadirData[$date];
            }
        }
        
            
        return view('pages.dashboard.index', [
            'jml_pegawai' => $jml_pegawai,
            'persentase_hadir' => round($persentase_hadir, 1),
            'summary_absensi' => $allDates,
            'jml_cuti' => $jml_cuti,
            'jml_izin' => $jml_izin
        ]);
        
    }
}