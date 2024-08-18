<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Utils\Constant;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggal_dipilih = $request->tanggal ?? date('Y-m-d');
        // $data_absensi = Absensi::latest()->paginate(Constant::ITEM_PER_PAGE);
        $data_absensi = Pegawai::leftJoin('absensi', function($join) use ($tanggal_dipilih) {
            $join->on('pegawai.id_pegawai', '=', 'absensi.id_pegawai')
                 ->where('absensi.tanggal', '=', $tanggal_dipilih);
        })
        ->select('pegawai.id_pegawai AS id_pegawai', 'pegawai.nama_pegawai AS nama_pegawai', 'absensi.id_absensi AS id_absensi', 'absensi.tanggal', 'absensi.jam_masuk', 'absensi.jam_pulang', 'absensi.status')
        ->orderBy('pegawai.id_pegawai')
        ->paginate(Constant::ITEM_PER_PAGE);

        // dd($data_absensi);

        return view('pages.dashboard.absensi.index', [
            'tanggal_dipilih' => $tanggal_dipilih,
            'data_absensi' => $data_absensi
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
}
