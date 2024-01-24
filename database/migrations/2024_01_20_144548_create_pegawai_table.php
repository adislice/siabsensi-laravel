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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->integer('id_pegawai', true);
            $table->string('nama_pegawai');
            $table->string('nip')->unique();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->integer('id_jabatan', false);
            $table->string('foto')->nullable();
            $table->string('password');
            $table->timestamps();
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
