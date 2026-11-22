<?php

namespace App\Services;

use App\Models\Subject;
use App\Models\SubjectPost;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubjectBackupService
{
    /**
     * Pastikan setiap mapel memiliki 4 folder backup: Catatan, Tugas, PR, Event
     */
    public static function ensureFolders(Subject $subject): string
    {
        $mapelFolderName = Str::slug($subject->nama_mapel, '_');
        $basePath = storage_path('app/backup_mapel/' . $mapelFolderName);

        foreach (['Catatan', 'Tugas', 'PR', 'Event'] as $kategoriFolder) {
            $dir = $basePath . '/' . $kategoriFolder;
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        return $basePath;
    }

    /**
     * Auto-backup postingan beserta semua file lampirannya saat dibuat / diupdate
     */
    public static function backupPost(SubjectPost $post): void
    {
        $post->loadMissing(['subject', 'user', 'attachments']);
        if (!$post->subject) {
            return;
        }

        $basePath = self::ensureFolders($post->subject);

        $folderMap = [
            'catatan' => 'Catatan',
            'tugas'   => 'Tugas',
            'pr'      => 'PR',
            'event'   => 'Event',
        ];

        $katFolder = $folderMap[strtolower($post->kategori)] ?? 'Catatan';
        $timestamp = ($post->created_at ?? now())->format('Y-m-d_His');
        $slugJudul = Str::slug($post->judul, '_') ?: 'item_' . $post->id;

        $postDir = $basePath . '/' . $katFolder . '/' . $timestamp . '_ID' . $post->id . '_' . $slugJudul;
        if (!File::exists($postDir)) {
            File::makeDirectory($postDir, 0755, true);
        }

        // 1. Simpan metadata terstruktur (JSON) untuk keperluan restore otomatis
        $backupPayload = [
            'id'               => $post->id,
            'kode_mapel'       => $post->subject->kode_mapel,
            'nama_mapel'       => $post->subject->nama_mapel,
            'kategori'         => $post->kategori,
            'judul'            => $post->judul,
            'deskripsi'        => $post->deskripsi,
            'tanggal_deadline' => $post->tanggal_deadline,
            'pembuat'          => $post->user->name ?? 'Unknown',
            'dibuat_pada'      => optional($post->created_at)->toDateTimeString(),
            'diupdate_pada'    => now()->toDateTimeString(),
            'lampiran'         => [],
        ];

        // 2. Salin seluruh file fisik foto/video ke dalam folder backup ini
        foreach ($post->attachments as $idx => $att) {
            $sourceFile = storage_path('app/public/' . $att->file_path);
            if (File::exists($sourceFile)) {
                $originalName = basename($att->file_path);
                $destFile = $postDir . '/' . ($idx + 1) . '_' . $originalName;
                File::copy($sourceFile, $destFile);
                $backupPayload['lampiran'][] = ($idx + 1) . '_' . $originalName;
            }
        }

        File::put(
            $postDir . '/data_backup.json',
            json_encode($backupPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // 3. Simpan juga file teks yang mudah dibaca langsung oleh manusia (ringkasan.txt)
        $txtContent  = "MATA PELAJARAN : {$post->subject->nama_mapel} ({$post->subject->kode_mapel})\n";
        $txtContent .= "KATEGORI       : " . strtoupper($post->kategori) . "\n";
        $txtContent .= "JUDUL          : {$post->judul}\n";
        $txtContent .= "PEMBUAT        : " . ($post->user->name ?? '-') . "\n";
        $txtContent .= "DEADLINE       : " . ($post->tanggal_deadline ?? 'Tidak ada') . "\n";
        $txtContent .= "WAKTU BACKUP   : " . now()->format('d M Y H:i:s') . "\n";
        $txtContent .= str_repeat('=', 50) . "\n\n";
        $txtContent .= ($post->deskripsi ?? '(Tidak ada deskripsi)') . "\n";

        File::put($postDir . '/ringkasan.txt', $txtContent);
    }
}