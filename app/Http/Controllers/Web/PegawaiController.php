<?php

namespace App\Http\Controllers\Web;

use App\Utils\Constant;
use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\LokasiAbsensi;
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
        $all_pegawai = Pegawai::latest()->paginate(Constant::ITEM_PER_PAGE)->withQueryString();
        return view('pages.dashboard.pegawai.index', [
            'all_pegawai' => $all_pegawai
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_jabatan = Jabatan::all();
        $data_lokasi_absensi = LokasiAbsensi::all();
        return view('pages.dashboard.pegawai.create', [
            'data_jabatan' => $data_jabatan,
            'data_lokasi_absensi' => $data_lokasi_absensi
        ]);
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
            'id_lokasi_absensi' => 'nullable',
            'password' => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z-_\d]{6,}$/'],
        ]);

        try {
            if ($request->file('foto')) {
                // $file = $request->file('foto');
                // $directory = '/uploads/pegawai/';
                // $nama_file = $request->nip . '.' . $file->getClientOriginalExtension();
                // $file_path = $directory . $nama_file;
                // Storage::disk('public')->put($file_path, file_get_contents($file));
                $file_path = $request->file('foto')->storeAs('uploads/pegawai', $request->nip.'.'.$request->file('foto')->getClientOriginalExtension(), 'public');
                // dd($path, url($path));
            
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
                'id_lokasi_absensi' => $request->id_lokasi_absensi,
                'foto' => $file_path
            ]);

            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Data pegawai gagal ditambahkan\n".$th->getMessage())->withInput($request->all());
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pages.dashboard.pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::find($id);
        $data_jabatan = Jabatan::all();
        $data_lokasi_absensi = LokasiAbsensi::all();

        return view('pages.dashboard.pegawai.edit', [
            'pegawai' => $pegawai,
            'data_jabatan' => $data_jabatan,
            'data_lokasi_absensi' => $data_lokasi_absensi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'nip' => 'required|unique:pegawai,nip,'.$id.',id_pegawai',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'id_jabatan' => 'required',
            'foto' => 'nullable|image',
            'status' => 'required',
            'id_lokasi_absensi' => 'nullable',
            'password' => ['nullable', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z-_\d]{6,}$/'],
        ]);

        try {
            $pegawai = Pegawai::find($id);

            $new_data = [
                'nip' => $request->nip,
                'nama_pegawai' => $request->nama_pegawai,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'id_jabatan' => $request->id_jabatan,
                'status' => $request->status,
                'id_lokasi_absensi' => $request->id_lokasi_absensi
            ];

            if ($request->file('foto')) {
                $file_path = $request->file('foto')->storeAs('uploads/pegawai', $request->nip.'.'.$request->file('foto')->getClientOriginalExtension(), 'public');
                $new_data['foto'] = $file_path;
            }

            if($request->password) {
                $new_password = bcrypt($request->password);
                $new_data['password'] = $new_password;
            }

            $pegawai->update($new_data);

            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diubah');
                        
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data pegawai gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pegawai = Pegawai::find($id);
            $pegawai->delete();
            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data pegawai gagal dihapus');
        }
    }
}
