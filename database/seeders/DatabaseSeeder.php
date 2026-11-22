<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Default
        User::updateOrCreate(
            ['email' => 'schrodinger453@gmail.com'],
            [
                'name' => 'Admin XI RPL 1',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_approved' => true,
            ]
        );

        // 2. Daftar Mata Pelajaran
        $mapelList = [
            'MBJ(J)' => 'Muatan Bahasa Jepang',
            'PP' => 'Pendidikan Pancasila',
            'B.Ing' => 'Bahasa Inggris',
            'BK' => 'Bimbingan Konseling',
            'BI' => 'Bahasa Indonesia',
            'MTK' => 'Matematika',
            'KDI' => 'Kreativitas & Desain Interaktif',
            'Penjas' => 'Pendidikan Jasmani',
            'KTS' => 'Pelajaran Ki Denis',
            'STI' => 'Senyuman Samsung Faris',
            'PL(RPL1)' => 'Pemrograman Lanjut RPL 1',
            'SI' => 'Sejarah Indonesia',
            'KWH' => 'Kewirausahaan',
            'PAI' => 'Pendidikan Agama Islam',
        ];

        $subjects = [];
        foreach ($mapelList as $kode => $nama) {
            $subjects[$kode] = Subject::updateOrCreate(
                ['kode_mapel' => $kode],
                ['nama_mapel' => $nama]
            )->id;
        }

        // 3. Jadwal Pelajaran Sesuai Gambar Asli
        Schedule::truncate();

        $jadwal = [
            // SENIN (BI berhenti di jam ke-10)
            ['hari' => 'Senin', 'subject_id' => $subjects['MBJ(J)'], 'jam_mulai' => 1, 'jam_selesai' => 2],
            ['hari' => 'Senin', 'subject_id' => $subjects['PP'], 'jam_mulai' => 3, 'jam_selesai' => 4],
            ['hari' => 'Senin', 'subject_id' => $subjects['B.Ing'], 'jam_mulai' => 5, 'jam_selesai' => 6],
            ['hari' => 'Senin', 'subject_id' => $subjects['BK'], 'jam_mulai' => 7, 'jam_selesai' => 7],
            ['hari' => 'Senin', 'subject_id' => $subjects['BI'], 'jam_mulai' => 8, 'jam_selesai' => 10],

            // SELASA (Hanya STI yang sampai jam ke-11)
            ['hari' => 'Selasa', 'subject_id' => $subjects['MTK'], 'jam_mulai' => 1, 'jam_selesai' => 3],
            ['hari' => 'Selasa', 'subject_id' => $subjects['KDI'], 'jam_mulai' => 4, 'jam_selesai' => 6],
            ['hari' => 'Selasa', 'subject_id' => $subjects['Penjas'], 'jam_mulai' => 7, 'jam_selesai' => 8],
            ['hari' => 'Selasa', 'subject_id' => $subjects['KTS'], 'jam_mulai' => 9, 'jam_selesai' => 9],
            ['hari' => 'Selasa', 'subject_id' => $subjects['STI'], 'jam_mulai' => 10, 'jam_selesai' => 11],

            // RABU (PL sesi kedua berhenti di jam ke-10)
            ['hari' => 'Rabu', 'subject_id' => $subjects['PL(RPL1)'], 'jam_mulai' => 1, 'jam_selesai' => 5],
            ['hari' => 'Rabu', 'subject_id' => $subjects['PL(RPL1)'], 'jam_mulai' => 6, 'jam_selesai' => 10],

            // KAMIS (B.Ing berhenti di jam ke-9)
            ['hari' => 'Kamis', 'subject_id' => $subjects['SI'], 'jam_mulai' => 1, 'jam_selesai' => 2],
            ['hari' => 'Kamis', 'subject_id' => $subjects['KWH'], 'jam_mulai' => 3, 'jam_selesai' => 4],
            ['hari' => 'Kamis', 'subject_id' => $subjects['PAI'], 'jam_mulai' => 5, 'jam_selesai' => 7],
            ['hari' => 'Kamis', 'subject_id' => $subjects['B.Ing'], 'jam_mulai' => 8, 'jam_selesai' => 9],

            // JUMAT (PL sesi kedua berhenti di jam ke-10)
            ['hari' => 'Jumat', 'subject_id' => $subjects['PL(RPL1)'], 'jam_mulai' => 1, 'jam_selesai' => 6],
            ['hari' => 'Jumat', 'subject_id' => $subjects['PL(RPL1)'], 'jam_mulai' => 7, 'jam_selesai' => 10],
        ];

        foreach ($jadwal as $row) {
            Schedule::create($row);
        }
    }
}