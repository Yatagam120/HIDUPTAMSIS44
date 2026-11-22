<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'frame_path')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('frame_path')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('students') && Schema::hasColumn('students', 'frame_path')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('frame_path');
            });
        }
    }
};