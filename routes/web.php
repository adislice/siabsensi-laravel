<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PegawaiController;
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
        return view('pages.dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/dashboard/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/dashboard/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/dashboard/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('/dashboard/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/dashboard/pegawai/{id}/delete', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
});
