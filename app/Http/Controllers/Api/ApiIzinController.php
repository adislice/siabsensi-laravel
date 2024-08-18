<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Validator;

class ApiIzinController extends Controller
{
    public function index(Request $request)
    {
        try {
            $id_pegawai = auth()->user()->id_pegawai;
            $status = $request->status ?? '';

            $data_izin = Izin::where('id_pegawai', $id_pegawai)
                ->where('status', 'like', '%' . $status . '%')
                ->orderBy('id_izin', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $data_izin
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tanggal' => 'required',
                'alasan' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $this->validation_error($validator->errors())
                ]);
            }
    
            $data_izin = [
                'id_pegawai' => auth()->user()->id_pegawai,
                'tanggal' => $request->tanggal,
                'alasan' => $request->alasan,
                'status' => 'pending'
            ];

            Izin::create($data_izin);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan izin berhasil diajukan'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($id_izin)
    {

    }

    public function update(Request $request, $id_izin)
    {
        try {

            $validator = Validator::make($request->all(), [
                'tanggal' => 'required',
                'alasan' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $this->validation_error($validator->errors())
                ]);
            }

            $izin = Izin::findOrFail($id_izin)->first();

            if (!$izin->status == 'pending') {
                throw new \Exception('Permohonan izin sudah disetujui atau ditolak');
            }

            $izin->update([
                'tanggal' => $request->tanggal,
                'alasan' => $request->alasan,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan izin berhasil diupdate'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id_izin)
    {
        try {
            $izin = Izin::where('id_izin', $id_izin)->first();
            $izin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan izin berhasil dihapus'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
