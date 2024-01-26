<?php

use App\Http\Controllers\Api\ApiAbsensiController;
use App\Http\Controllers\Api\ApiAuthController;
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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/validateToken', [ApiAuthController::class, 'validateToken']);
    Route::get('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/absensi', [ApiAbsensiController::class, 'index']);
    Route::post('/absensi-masuk', [ApiAbsensiController::class, 'absensiMasuk']);
    Route::post('/absensi-pulang', [ApiAbsensiController::class, 'absensiPulang']);
    Route::get('/cuti', [ApiCutiController::class, 'index']);
    Route::get('/cuti/{id_cuti}', [ApiCutiController::class, 'show']);
    Route::post('/cuti/add', [ApiCutiController::class, 'store']);
    Route::get('/profil', [ApiPegawaiController::class, 'show']);
});

Route::post('/login', [ApiAuthController::class, 'login']);


