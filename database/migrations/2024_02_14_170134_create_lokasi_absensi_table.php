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
        Schema::create('lokasi_absensi', function (Blueprint $table) {
            $table->integer('id_lokasi_absensi', true);
            $table->string('nama_lokasi');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('radius');
            $table->timestamps();
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $table->integer('id_lokasi_absensi', false)->nullable();
            $table->foreign('id_lokasi_absensi')->references('id_lokasi_absensi')->on('lokasi_absensi')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_absensi');
    }
};
