<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nip' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $this->validation_error($validator->errors())
                ]);
            }

            $nip = $request->nip;
            $password = $request->password;

            $pegawai = Pegawai::with(['jabatan', 'lokasi_absensi'])->where('nip', $nip)->first();
            
            if (!$pegawai || !password_verify($password, $pegawai->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIP atau password salah. Silahkan coba kembali.'
                ]);
            }

            $info_absensi = [
                'jam_masuk_dari' => $this->getKonfigurasi('jam_masuk_dari'),
                'jam_masuk_sampai' => $this->getKonfigurasi('jam_masuk_sampai'),
                'jam_pulang_dari' => $this->getKonfigurasi('jam_pulang_dari'),
                'jam_pulang_sampai' => $this->getKonfigurasi('jam_pulang_sampai')
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'pegawai' => $pegawai,
                    'auth_token' => $pegawai->createToken($pegawai->nip)->plainTextToken,
                    'info_absensi' => $info_absensi
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function loginWithToken(Request $request)
    {
        try {
            $pegawai = Pegawai::with(['jabatan', 'lokasi_absensi'])->where('id_pegawai', auth()->user()->id_pegawai)->first();

            $info_absensi = [
                'jam_masuk_dari' => $this->getKonfigurasi('jam_masuk_dari'),
                'jam_masuk_sampai' => $this->getKonfigurasi('jam_masuk_sampai'),
                'jam_pulang_dari' => $this->getKonfigurasi('jam_pulang_dari'),
                'jam_pulang_sampai' => $this->getKonfigurasi('jam_pulang_sampai')
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'pegawai' => $pegawai,
                    'info_absensi' => $info_absensi
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function logout(Request $request) {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
