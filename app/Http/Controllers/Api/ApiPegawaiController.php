<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPegawaiController extends Controller
{
    public function show() {
        try {
            $pegawai = Pegawai::where('id_pegawai', auth()->user()->id_pegawai)->first();

            return response()->json([
                'success' => true,
                'data' => $pegawai
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
