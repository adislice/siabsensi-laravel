<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LokasiAbsensi;
use App\Utils\Constant;
use Illuminate\Http\Request;

class LokasiAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi_absensi = LokasiAbsensi::latest()->paginate(Constant::ITEM_PER_PAGE);

        return view('pages.dashboard.lokasi_absensi.index', [
            'lokasi_absensi' => $lokasi_absensi
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.lokasi_absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric'
        ]);

        try {
            LokasiAbsensi::create($request->all());
            return redirect()->route('lokasi_absensi.index')->with('success', 'Data lokasi absensi berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data lokasi absensi gagal ditambahkan. <br>'.$th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lokasi_absensi = LokasiAbsensi::findOrFail($id);

        return view('pages.dashboard.lokasi_absensi.show', [
            'lokasi_absensi' => $lokasi_absensi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lokasi_absensi = LokasiAbsensi::findOrFail($id);

        return view('pages.dashboard.lokasi_absensi.edit', [
            'lokasi_absensi' => $lokasi_absensi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric'
        ]);

        try {
            $lokasi_absensi = LokasiAbsensi::findOrFail($id);
            $lokasi_absensi->update($request->all());
            return redirect()->route('lokasi_absensi.index')->with('success', 'Data lokasi absensi berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data lokasi absensi gagal diubah. <br>'.$th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lokasi_absensi = LokasiAbsensi::findOrFail($id);
            $lokasi_absensi->delete();
            return redirect()->route('lokasi_absensi.index')->with('success', 'Data lokasi absensi berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data lokasi absensi gagal dihapus. <br>'.$th->getMessage());
        }
    }
}
