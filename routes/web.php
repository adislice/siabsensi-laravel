<?php

use App\Http\Controllers\Web\AbsensiController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CutiController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\IzinController;
use App\Http\Controllers\Web\JabatanController;
use App\Http\Controllers\Web\KonfigurasiController;
use App\Http\Controllers\Web\LokasiAbsensiController;
use App\Http\Controllers\Web\PegawaiController;
use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction']);



Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/dashboard/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/dashboard/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/dashboard/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('/dashboard/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/dashboard/pegawai/{id}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    Route::get('/dashboard/pegawai/{id}/show', [PegawaiController::class, 'show'])->name('pegawai.show');

    Route::get('/dashboard/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
    Route::get('/dashboard/jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create');
    Route::post('/dashboard/jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
    Route::get('/dashboard/jabatan/{id}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::post('/dashboard/jabatan/{id}/update', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('/dashboard/jabatan/{id}/delete', [JabatanController::class, 'destroy'])->name('jabatan.delete');

    Route::get('/dashboard/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/dashboard/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/dashboard/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/dashboard/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::post('/dashboard/absensi/{id}/update', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('/dashboard/absensi/{id}/delete', [AbsensiController::class, 'destroy'])->name('absensi.delete');
    Route::post('/dashboard/absensi/{id}/update-status', [AbsensiController::class, 'updateStatus'])->name('absensi.update_status');

    Route::get('/dashboard/lokasi-absensi', [LokasiAbsensiController::class, 'index'])->name('lokasi_absensi.index');
    Route::get('/dashboard/lokasi-absensi/create', [LokasiAbsensiController::class, 'create'])->name('lokasi_absensi.create');
    Route::post('/dashboard/lokasi-absensi/store', [LokasiAbsensiController::class, 'store'])->name('lokasi_absensi.store');
    Route::get('/dashboard/lokasi-absensi/{id}/edit', [LokasiAbsensiController::class, 'edit'])->name('lokasi_absensi.edit');
    Route::post('/dashboard/lokasi-absensi/{id}/update', [LokasiAbsensiController::class, 'update'])->name('lokasi_absensi.update');
    Route::delete('/dashboard/lokasi-absensi/{id}/delete', [LokasiAbsensiController::class, 'destroy'])->name('lokasi_absensi.delete');
    Route::get('/dashboard/lokasi-absensi/{id}/show', [LokasiAbsensiController::class, 'show'])->name('lokasi_absensi.show');

    Route::get('/dashboard/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('/dashboard/izin/{id}/show', [IzinController::class, 'show'])->name('izin.show');
    Route::post('/dashboard/izin/{id}/update-status', [IzinController::class, 'updateStatus'])->name('izin.update_status');
    Route::delete('/dashboard/izin/{id}/delete', [IzinController::class, 'destroy'])->name('izin.delete');

    Route::get('/dashboard/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/dashboard/cuti/{id}/show', [CutiController::class, 'show'])->name('cuti.show');
    Route::post('/dashboard/cuti/{id}/update-status', [CutiController::class, 'updateStatus'])->name('cuti.update_status');
    Route::delete('/dashboard/cuti/{id}/delete', [CutiController::class, 'destroy'])->name('cuti.delete');

    Route::get('/dashboard/konfigurasi', [KonfigurasiController::class, 'index'])->name('konfigurasi.index');
    Route::post('/dashboard/konfigurasi', [KonfigurasiController::class, 'save'])->name('konfigurasi.save');

    Route::get('/dashboard/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/cek/{id}', function ($id) {
    $pegawai = Pegawai::find($id);
    dd($pegawai);
});


Livewire::setScriptRoute(function ($handle) {
    return Route::get('/livewire/livewire-js', $handle);
});