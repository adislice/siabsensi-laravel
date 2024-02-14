<?php

namespace App\Http\Controllers\Web;

use App\Utils\Constant;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_jabatan = Jabatan::latest()->paginate(Constant::ITEM_PER_PAGE)->withQueryString();
        

        return view('pages.dashboard.jabatan.index', [
            'data_jabatan' => $data_jabatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required'
        ]);

        try {
            Jabatan::create([
                'nama_jabatan' => $request->nama_jabatan
            ]);
            return redirect()->route('jabatan.index')->with('success', 'Data Jabatan Berhasilsil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Data Jabatan gagal ditambahkan\n".$th->getMessage())->withInput($request->all());
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
        $data_jabatan = Jabatan::find($id);
        return view('pages.dashboard.jabatan.edit', [
            'data_jabatan' => $data_jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jabatan' => 'required'
        ]);

        try {
            Jabatan::find($id)->update([
                'nama_jabatan' => $request->nama_jabatan
            ]);
            return redirect()->route('jabatan.index')->with('success', 'Data jabatan berhasil diupdate');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Data jabatan gagal diupdate. Alasan: \n".$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Jabatan::find($id)->delete();
            return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Data Jabatan gagal dihapus. Alasan: \n".$th->getMessage());
        }
    }
}
