<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_pegawai = Pegawai::all();
        return view('pages.dashboard.pegawai.index', compact('all_pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jabatan = Jabatan::all();
        return view('pages.dashboard.pegawai.create', compact('data_jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'nip' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'id_jabatan' => 'required',
            'foto' => 'nullable|image',
            'status' => 'required',
            'password' => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z-_\d]{6,}$/'],
        ]);

        try {
            if ($request->file('foto')) {
                $file = $request->file('foto');
                $directory = '/uploads/pegawai/';
                $nama_file = $request->nip . '.' . $file->getClientOriginalExtension();
                $file_path = $directory . $nama_file;
                Storage::disk('public')->put($file_path, file_get_contents($file));
            } else {
                $file_path = null;
            }

            $new_password = bcrypt($request->password);

            Pegawai::create([
                'nip' => $request->nip,
                'nama_pegawai' => $request->nama_pegawai,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'id_jabatan' => $request->id_jabatan,
                'password' => $new_password,
                'foto' => $file_path
            ]);

            return redirect()->route('pegawai.index')->with('toast-success', 'Data pegawai berhasil ditambahkan');

        } catch (\Throwable $th) {
            return redirect()->back()->with('alert-error', 'Data pegawai gagal ditambahkan')->withInput($request->all());
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
        $pegawai = Pegawai::find($id);
        $data_jabatan = Jabatan::all();

        return view('pages.dashboard.pegawai.edit', compact('pegawai', 'data_jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pegawai = Pegawai::find($id);
            $pegawai->delete();
            return redirect()->route('pegawai.index')->with('toast-success', 'Data pegawai berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast-error', 'Data pegawai gagal dihapus');
        }
    }
}
