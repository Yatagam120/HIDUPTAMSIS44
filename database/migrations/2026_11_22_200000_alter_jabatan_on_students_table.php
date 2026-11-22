<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE students MODIFY jabatan VARCHAR(30) NOT NULL DEFAULT 'siswa'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE students MODIFY jabatan ENUM('walas', 'ketua_kelas', 'wakil_ketua', 'siswa') NOT NULL DEFAULT 'siswa'");
    }
};