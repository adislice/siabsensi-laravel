<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Izin;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IzinController extends Controller
{
    public function index(Request $request) {
        $daftar_izin = Izin::latest()->paginate(Constant::ITEM_PER_PAGE);
        
        return view('pages.dashboard.izin.index', [
            'daftar_izin' => $daftar_izin
        ]);
    }

    public function show($id) {
        $izin = Izin::findOrFail($id);

        return view('pages.dashboard.izin.show', [
            'izin' => $izin
        ]);
    }

    public function updateStatus(Request $request, $id) {
        DB::beginTransaction();
        try {
            $izin = Izin::findOrFail($id);
            $izin->update([
                'status' => $request->status
            ]);

            $tanggal_izin = $izin->tanggal;

            if ($request->status == 'disetujui') {
                Absensi::create([
                    'id_pegawai' => $izin->id_pegawai,
                    'tanggal' => $tanggal_izin,
                    'status' => 'izin'
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Status izin berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
