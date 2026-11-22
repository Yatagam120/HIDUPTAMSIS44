<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                if (!Schema::hasColumn('students', 'birth_date')) {
                    $table->date('birth_date')->nullable();
                }
                if (!Schema::hasColumn('students', 'age')) {
                    $table->unsignedTinyInteger('age')->nullable();
                }
                if (!Schema::hasColumn('students', 'gender')) {
                    $table->string('gender', 20)->nullable();
                }
                if (!Schema::hasColumn('students', 'quote')) {
                    $table->text('quote')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                foreach (['birth_date', 'age', 'gender', 'quote'] as $col) {
                    if (Schema::hasColumn('students', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};