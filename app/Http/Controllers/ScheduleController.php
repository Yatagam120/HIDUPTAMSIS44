<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SubjectPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $schedules = Schedule::with('subject')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        // Ambil semua postingan untuk status alert (kiri atas) & ikon kategori (kanan atas)
        $allPosts = SubjectPost::with('reactions')->get();

        $today = Carbon::today();
        $userId = Auth::id();
        $subjectAlerts = [];
        $subjectBadges = [];

        foreach ($allPosts as $post) {
            $subId = $post->subject_id;
            $kat = $post->kategori; // catatan, tugas, pr, event

            // 1. Catat kategori yang ada isinya di mapel ini (untuk ikon pojok kanan atas)
            if (in_array($kat, ['catatan', 'tugas', 'pr', 'event'])) {
                $subjectBadges[$subId][$kat] = ($subjectBadges[$subId][$kat] ?? 0) + 1;
            }

            // 2. Cek alert deadline mepet / lewat untuk Tugas, PR, dan Event (pojok kiri atas)
            if (!in_array($kat, ['tugas', 'pr', 'event']) || !$post->tanggal_deadline) {
                continue;
            }

            $isChecked = $post->reactions
                ->where('emoji', '✅')
                ->where('user_id', $userId)
                ->isNotEmpty();

            if ($isChecked) {
                continue;
            }

            $deadline = Carbon::parse($post->tanggal_deadline)->startOfDay();
            $diffDays = $today->diffInDays($deadline, false);

            if ($diffDays <= 0) {
                $subjectAlerts[$subId] = [
                    'type' => 'red',
                    'post_ids' => array_merge($subjectAlerts[$subId]['post_ids'] ?? [], [$post->id]),
                ];
            } elseif ($diffDays <= 2) {
                if (($subjectAlerts[$subId]['type'] ?? '') !== 'red') {
                    $subjectAlerts[$subId]['type'] = 'yellow';
                }
                $subjectAlerts[$subId]['post_ids'][] = $post->id;
            }
        }

        return view('dashboard', compact('days', 'schedules', 'subjectAlerts', 'subjectBadges'));
    }
}