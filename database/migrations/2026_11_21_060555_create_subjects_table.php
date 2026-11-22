<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('subject_posts')) {
            Schema::create('subject_posts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('kategori', 20); // catatan, tugas, pr, event
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal_deadline')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('post_attachments')) {
            Schema::create('post_attachments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subject_post_id')->constrained('subject_posts')->cascadeOnDelete();
                $table->string('file_path');
                $table->string('file_type', 20)->default('image');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('post_reactions')) {
            Schema::create('post_reactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subject_post_id')->constrained('subject_posts')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('emoji', 20);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('post_reactions');
        Schema::dropIfExists('post_attachments');
        Schema::dropIfExists('subject_posts');
    }
};