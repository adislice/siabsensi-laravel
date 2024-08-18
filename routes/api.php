<?php

use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiCutiController;
use App\Http\Controllers\Api\ApiIzinController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/loginWithToken', [ApiAuthController::class, 'loginWithToken']);
    Route::get('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/absensi', [ApiAbsensiController::class, 'index']);
    Route::get('/absensi/{id_absensi}', [ApiAbsensiController::class, 'show']);
    Route::post('/absensi-masuk', [ApiAbsensiController::class, 'absensiMasuk']);
    Route::post('/absensi-pulang', [ApiAbsensiController::class, 'absensiPulang']);
    Route::get('/cuti', [ApiCutiController::class, 'index']);
    Route::get('/cuti/{id_cuti}', [ApiCutiController::class, 'show']);
    Route::post('/cuti/{id_cuti}/update', [ApiCutiController::class, 'update']);
    Route::post('/cuti/{id_cuti}/delete', [ApiCutiController::class, 'destroy']);
    Route::post('/cuti/add', [ApiCutiController::class, 'store']);
    Route::get('/izin', [ApiIzinController::class, 'index']);
    Route::get('/izin/{id_izin}', [ApiIzinController::class, 'show']);
    Route::post('/izin/{id_izin}/update', [ApiIzinController::class, 'update']);
    Route::post('/izin/{id_izin}/delete', [ApiIzinController::class, 'destroy']);
    Route::post('/izin/add', [ApiIzinController::class, 'store']);
    Route::get('/profil', [ApiPegawaiController::class, 'show']);
});

Route::post('/login', [ApiAuthController::class, 'login']);


