<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konfigurasi', function (Blueprint $table) {
            $table->integer('id_konfigurasi', true);
            $table->double('lokasi_absensi_latitude');
            $table->double('lokasi_absensi_longitude');
            $table->double('radius_absensi');
            $table->time('jam_masuk_dari');
            $table->time('jam_masuk_sampai');
            $table->time('jam_pulang_dari');
            $table->time('jam_pulang_sampai');
            $table->time('jam_max_terlambat');
            $table->boolean('is_absensi_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi');
    }
};
