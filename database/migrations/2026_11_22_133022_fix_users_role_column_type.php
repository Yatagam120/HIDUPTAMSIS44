<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `users` MODIFY COLUMN `role` VARCHAR(50) NOT NULL DEFAULT 'murid'");
            }
        }
    }

    public function down(): void
    {
        //
    }
};