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
        Schema::dropIfExists('students'); // Hapus tabel versi lama jika terlanjur dibuat file migration sebelumnya
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jabatan', ['walas', 'ketua_kelas', 'wakil_ketua', 'siswa'])->default('siswa');
            $table->integer('umur');
            $table->date('tanggal_lahir');
            $table->string('hobi');
            $table->string('skill');
            $table->text('quote');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
