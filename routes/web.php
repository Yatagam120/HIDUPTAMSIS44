<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FrameRequestController;
use App\Http\Controllers\KomokController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectPostController;
use App\Http\Controllers\TeacherContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Jadwal Utama
    Route::get('/dashboard', [ScheduleController::class, 'index'])->name('dashboard');

    // Mata Pelajaran & Postingan (Catatan, Tugas, PR, Event) + Approval + Komentar
    Route::get('/mapel/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::get('/subject/{subject}', [SubjectController::class, 'show'])->name('subject.show');
    Route::post('/mapel/{subject}/items', [SubjectController::class, 'storeItem'])->name('subject.items.store');
    Route::patch('/mapel/{subject}/items/{item}', [SubjectController::class, 'updateItem'])->name('subject.items.update');
    Route::delete('/mapel/{subject}/items/{item}', [SubjectController::class, 'destroyItem'])->name('subject.items.destroy');
    Route::post('/items/{item}/approve', [SubjectController::class, 'approveItem'])->name('items.approve');
    Route::post('/items/{item}/toggle-complete', [SubjectController::class, 'toggleComplete'])->name('items.toggle-complete');

    // Komentar ala Facebook pada setiap Tugas / PR / Catatan / Event
    Route::post('/items/{item}/comments', [SubjectController::class, 'storeComment'])->name('items.comments.store');
    Route::delete('/comments/{comment}', [SubjectController::class, 'destroyComment'])->name('items.comments.destroy');

    // Route Kompatibilitas SubjectPostController
    Route::post('/mapel/{subject}/posts', [SubjectPostController::class, 'store'])->name('subject.posts.store');
    Route::get('/posts/{post}/edit', [SubjectPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [SubjectPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [SubjectPostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/react', [SubjectPostController::class, 'toggleReaction'])->name('posts.react');

    // List Tugas Gabungan
    Route::get('/list-tugas', [SubjectController::class, 'allTasks'])->name('tasks.index');

    // Kalender Interaktif
    Route::get('/kalender', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/kalender', [CalendarController::class, 'store'])->name('calendar.store');
    Route::delete('/kalender/{calendarEvent}', [CalendarController::class, 'destroy'])->name('calendar.destroy');
    Route::put('/kalender/{id}', [CalendarController::class, 'update'])->name('calendar.update');

    // Struktur & Biodata Siswa
    Route::resource('students', StudentController::class)->names('students');
    Route::get('/siswa', [StudentController::class, 'index'])->name('siswa.index');
    Route::patch('/students/{student}/profile', [StudentProfileController::class, 'update'])->name('students.profile.update');

    // Bingkai Profil
    Route::post('/siswa/bingkai-request', [FrameRequestController::class, 'store'])->name('siswa.frame.request');
    Route::post('/admin/frame-requests/{frameRequest}/approve', [FrameRequestController::class, 'approve'])->name('admin.frame.approve');
    Route::post('/admin/frame-requests/{frameRequest}/reject', [FrameRequestController::class, 'reject'])->name('admin.frame.reject');

    // Nmr Guru (Murid & Ex-PPTS butuh verifikasi admin, otoritas tinggi langsung tayang)
    Route::get('/nmr-guru', [TeacherContactController::class, 'index'])->name('teachers.phone');
    Route::post('/nmr-guru', [TeacherContactController::class, 'store'])->name('teachers.phone.store');
    Route::post('/nmr-guru/{id}/approve', [TeacherContactController::class, 'approve'])->name('teachers.phone.approve');
    Route::delete('/nmr-guru/{id}', [TeacherContactController::class, 'destroy'])->name('teachers.phone.destroy');

    // Materi (AAS, ATS, Ulangan, dll.)
    Route::get('/materi', [MaterialController::class, 'index'])->name('materials.index');
    Route::post('/materi', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materi/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy');

    // Komok (Eksklusif Ketua Kelas, Wakil Ketua Kelas, PPTS, Admin)
    Route::get('/komok', [KomokController::class, 'index'])->name('komok.index');
    Route::post('/komok', [KomokController::class, 'store'])->name('komok.store');
    Route::delete('/komok/{id}', [KomokController::class, 'destroy'])->name('komok.destroy');

    // Latihan Bercabang (Latihan MTK & Latihan Koding Pilihan Ganda)
    Route::get('/latihan', [PracticeController::class, 'index'])->name('practice.index');
    Route::get('/latihan/{topic}', [PracticeController::class, 'show'])->name('practice.show');

    // Musik & Request Lagu (Atur Admin, Request Siswa)
    Route::post('/music/upload', [MusicController::class, 'storeAdmin'])->name('music.admin.store');
    Route::post('/music/request', [MusicController::class, 'requestSong'])->name('music.request');
    Route::post('/music/{id}/approve', [MusicController::class, 'approve'])->name('music.approve');
    Route::delete('/music/{id}', [MusicController::class, 'destroy'])->name('music.destroy');

    // Pengaturan & Kasih Saran / Bug Report
    Route::view('/pengaturan', 'settings')->name('settings');
    Route::get('/pengaturan-index', fn () => redirect()->route('settings'))->name('settings.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Admin Panel (AP)
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/approve', [AdminUserController::class, 'approve'])->name('admin.users.approve');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.role');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';