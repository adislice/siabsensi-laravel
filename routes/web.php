<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\JabatanController;
use App\Http\Controllers\Web\PegawaiController;
use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction']);



Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', function () {
        $jml_pegawai = Pegawai::count();
        $absensi = Absensi::all();
        $total_absensi = $absensi->count();
        $jml_hadir = $absensi->where('status', 'hadir')->count();
        $persentase_hadir = $jml_hadir / $total_absensi * 100;
        // dd($total_absensi, $jml_hadir, $persentase_hadir);
        return view('pages.dashboard.index', [
            'jml_pegawai' => $jml_pegawai,
            'persentase_hadir' => round($persentase_hadir, 1),
        ]);
    })->name('dashboard');

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
    
});
