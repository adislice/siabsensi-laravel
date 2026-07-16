<?php

namespace App\Http\Controllers\Web;

use App\Exports\AbsensiExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Utils\Constant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggal_dipilih = $request->tanggal ?? date('Y-m-d');
        $nip = $request->nip;

        $query = Pegawai::leftJoin('absensi', function($join) use ($tanggal_dipilih) {
            $join->on('pegawai.id_pegawai', '=', 'absensi.id_pegawai')
                 ->where('absensi.tanggal', '=', $tanggal_dipilih);
        })
        ->select('pegawai.id_pegawai AS id_pegawai', 'pegawai.nama_pegawai AS nama_pegawai', 'pegawai.nip', 'absensi.id_absensi AS id_absensi', 'absensi.tanggal', 'absensi.jam_masuk', 'absensi.jam_pulang', 'absensi.status')
        ->orderBy('pegawai.id_pegawai');

        // Filter by NIP if provided
        if ($nip) {
            $query->where('pegawai.nip', $nip);
        }

        $data_absensi = $query->paginate(Constant::ITEM_PER_PAGE);

        // Get pegawai name for display when filtering by NIP
        $pegawai_filter = $nip ? Pegawai::where('nip', $nip)->first() : null;

        return view('pages.dashboard.absensi.index', [
            'tanggal_dipilih' => $tanggal_dipilih,
            'data_absensi' => $data_absensi,
            'nip_filter' => $nip,
            'pegawai_filter' => $pegawai_filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $daftar_pegawai = Pegawai::all();

        return view('pages.dashboard.absensi.create', [
            'daftar_pegawai' => $daftar_pegawai
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_pegawai' => 'required',
                'tanggal' => 'required',
                'status' => 'required'
            ]);
            if ($request->status == "hadir") {
                $jam_masuk_default = $this->getKonfigurasi('jam_masuk_sampai');
                $jam_pulang_default = $this->getKonfigurasi('jam_pulang_sampai');
            } else {
                $jam_masuk_default = null;
                $jam_pulang_default = null;
            }

            Absensi::create([
                'id_pegawai' => $request->id_pegawai,
                'tanggal' => $request->tanggal,
                'status' => $request->status,
                'jam_masuk' => $jam_masuk_default,
                'jam_pulang' => $jam_pulang_default
            ]);

            return redirect()->back()->with('success', 'Data absensi berhasil ditambah');


        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data absensi gagal ditambah. Error: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

        try {
            $request->validate([
                'status' => 'required',
            ]);
            Absensi::findOrFail($id)->update([
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Data absensi berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data absensi gagal diupdate<br>Error: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required',
            'tanggal' => 'required',
            'status' => 'required'
        ]);
    }

    /**
     * Export absensi data to Excel by date range.
     */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $filename = 'absensi_' . $tanggalMulai . '_sd_' . $tanggalSelesai . '.xlsx';

        return Excel::download(
            new AbsensiExport($tanggalMulai, $tanggalSelesai),
            $filename
        );
    }
}
