<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPegawaiController extends Controller
{
    public function loginPegawai(Request $request) {
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

        $pegawai = Pegawai::where('nip', $nip)->first();
        if (!$pegawai && !password_verify($password, $pegawai->password)) {
            return response()->json([
                'success' => false,
                'message' => 'NIP atau password salah. Silahkan coba kembali.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'pegawai' => $pegawai,
                'auth_token' => $pegawai->createToken($pegawai->nip)->plainTextToken
            ]
        ]);

    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => $th->getMessage()
        ]);
    }
    }
}
