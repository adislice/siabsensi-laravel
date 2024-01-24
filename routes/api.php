<?php

use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiCutiController;
use App\Http\Controllers\Api\ApiPegawaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/absensi', [ApiAbsensiController::class, 'index']);
Route::post('/absensi-masuk', [ApiAbsensiController::class, 'absensiMasuk']);
Route::post('/absensi-pulang', [ApiAbsensiController::class, 'absensiPulang']);
Route::post('/login-pegawai', [ApiPegawaiController::class, 'loginPegawai']);

Route::get('/cuti', [ApiCutiController::class, 'index']);
Route::post('/cuti/add', [ApiCutiController::class, 'store']);
