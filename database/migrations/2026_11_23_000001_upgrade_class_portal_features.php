<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update users: last_seen_at untuk Active Member
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'last_seen_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('last_seen_at')->nullable();
            });
        }

        // 2. Update tabel postingan mapel (subject_posts / subject_items): approval & media
        foreach (['subject_posts', 'subject_items'] as $tbl) {
            if (Schema::hasTable($tbl)) {
                Schema::table($tbl, function (Blueprint $table) use ($tbl) {
                    if (!Schema::hasColumn($tbl, 'status')) {
                        $table->string('status')->default('approved'); // approved | pending
                    }
                    if (!Schema::hasColumn($tbl, 'media_path')) {
                        $table->string('media_path')->nullable();
                    }
                    if (!Schema::hasColumn($tbl, 'media_type')) {
                        $table->string('media_type')->nullable(); // image | video
                    }
                    if (!Schema::hasColumn($tbl, 'completed_by')) {
                        $table->json('completed_by')->nullable();
                    }
                });
            }
        }

        // 3. Tabel Komentar ala Facebook pada setiap Tugas / PR / Catatan / Event
        if (!Schema::hasTable('item_comments')) {
            Schema::create('item_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('item_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->text('body');
                $table->string('media_path')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabel Nomor WA Guru (dengan verifikasi untuk siswa/ex_ppts)
        if (!Schema::hasTable('teacher_contacts')) {
            Schema::create('teacher_contacts', function (Blueprint $table) {
                $table->id();
                $table->string('teacher_name');
                $table->string('subject_name')->nullable();
                $table->string('phone_number');
                $table->string('status')->default('approved'); // approved | pending
                $table->unsignedBigInteger('submitted_by')->nullable();
                $table->timestamps();
            });
        }

        // 5. Tabel Materi (AAS, ATS, Ulangan, dll.)
        if (!Schema::hasTable('study_materials')) {
            Schema::create('study_materials', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('exam_type')->default('AAS'); // AAS, ATS, Ulangan, Rangkuman
                $table->string('subject_name')->nullable();
                $table->text('description')->nullable();
                $table->string('file_path')->nullable();
                $table->string('file_type')->nullable(); // image, video, pdf, doc
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
            });
        }

        // 6. Tabel Komok (Eksklusif Ketua Kelas, Wakil, PPTS, Admin)
        if (!Schema::hasTable('komok_posts')) {
            Schema::create('komok_posts', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('caption')->nullable();
                $table->string('media_path');
                $table->string('media_type')->default('image'); // image | video
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
            });
        }

        // 7. Tabel Musik & Request Lagu Admin Panel
        if (!Schema::hasTable('app_musics')) {
            Schema::create('app_musics', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('artist')->nullable();
                $table->string('file_path');
                $table->string('status')->default('approved'); // approved | pending
                $table->unsignedBigInteger('requested_by')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('item_comments');
        Schema::dropIfExists('teacher_contacts');
        Schema::dropIfExists('study_materials');
        Schema::dropIfExists('komok_posts');
        Schema::dropIfExists('app_musics');
    }
};