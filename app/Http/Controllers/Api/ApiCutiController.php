<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiCutiController extends Controller
{
    public function index(Request $request)
    {
        $id_pegawai = auth()->user()->id_pegawai;
        $status = $request->status ?? '';


        $data_cuti = Cuti::where('id_pegawai', $id_pegawai)
            ->where('status', 'like', '%' . $status . '%')
            ->orderBy('id_cuti', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data_cuti
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
                'alasan' => 'required',
                'lampiran' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $this->validation_error($validator->errors())
                ]);
            }

            $file = $request->file('lampiran');
            $directory = '/uploads/lampiran/';
            $nama_file = $this->generateUid() . '.' . $file->getClientOriginalExtension();
            $file_path = $directory . $nama_file;
            Storage::disk('public')->put($file_path, file_get_contents($file));

            $data_cuti = [
                'id_pegawai' => auth()->user()->id_pegawai,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'alasan' => $request->alasan,
                'lampiran' => $file_path,
                'status' => 'pending'
            ];

            Cuti::create($data_cuti);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan cuti berhasil diajukan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($id_cuti) {
        try {
            $cuti = Cuti::where('id_cuti', $id_cuti)->first();

            return response()->json([
                'success' => true,
                'data' => $cuti
            ]);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
