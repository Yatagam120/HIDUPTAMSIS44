<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['subject_posts', 'subject_items', 'komok_posts', 'study_materials'] as $tbl) {
            if (Schema::hasTable($tbl) && !Schema::hasColumn($tbl, 'media_data')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->longText('media_data')->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['subject_posts', 'subject_items', 'komok_posts', 'study_materials'] as $tbl) {
            if (Schema::hasTable($tbl) && Schema::hasColumn($tbl, 'media_data')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->dropColumn('media_data');
                });
            }
        }
    }
};