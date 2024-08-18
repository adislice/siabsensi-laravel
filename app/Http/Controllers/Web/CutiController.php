<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CutiController extends Controller
{
    public function index()
    {
        $daftar_cuti = Cuti::latest()->paginate(Constant::ITEM_PER_PAGE);

        return view('pages.dashboard.cuti.index', [
            'daftar_cuti' => $daftar_cuti
        ]);
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        return view('pages.dashboard.cuti.show', [
            'cuti' => $cuti,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required'
            ]);
    
            if ($request->status == 'disetujui') {
                if (!$request->file('lampiran_disetujui')) {
                    throw new \Exception('Lampiran harus diisi');
                }
                $file = $request->file('lampiran_disetujui');
                $filename = bin2hex(random_bytes(16));
                $file_path = $file->storeAs('uploads/cuti', $filename . '.' . $file->getClientOriginalExtension(), 'public');

                $cuti = Cuti::findOrFail($id);
                $cuti->update([
                    'status' => 'disetujui',
                    'lampiran_disetujui' => $file_path
                ]);

                $tgl_mulai = Carbon::parse($cuti->tanggal_mulai);
                $tgl_selesai = Carbon::parse($cuti->tanggal_selesai);
                
                foreach (range(1, $tgl_selesai->diffInDays($tgl_mulai) + 1) as $day) {
                    Absensi::create([
                        'id_pegawai' => $cuti->id_pegawai,
                        'tanggal' => $tgl_mulai->copy()->addDay($day)->format('Y-m-d'),
                        'status' => 'cuti'
                    ]);
                }

                DB::commit();

                return redirect()->back()->with('success', 'Pengajuan cuti berhasil disetujui');

            } else {
                if (!$request->alasan_ditolak) {
                    return redirect()->back()->with('error', 'Alasan ditolak harus diisi')->withInput([
                        'alasan_ditolak' => $request->alasan_ditolak
                    ]);
                }
                $cuti = Cuti::findOrFail($id);
                $cuti->update([
                    'status' => 'ditolak',
                    'alasan_ditolak' => $request->alasan_ditolak
                ]);

                DB::commit();

                return redirect()->back()->with('success', 'Pengajuan cuti ditolak');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Kesalahan terjadi ketika mengubah status pengajuan cuti. Error: ' . $th->getMessage());
        }
    }
}
