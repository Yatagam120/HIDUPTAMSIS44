<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'MBJ'    => 'Muatan Bahasa Jepang',
            'PP'     => 'Pendidikan Pancasila',
            'B.Ing'  => 'Bahasa Inggris',
            'BK'     => 'Bimbingan Konseling',
            'BI'     => 'Bahasa Indonesia',
            'MTK'    => 'Matematika',
            'KDI'    => 'Kreativitas & Desain Interaktif',
            'Penjas' => 'Pendidikan Jasmani',
        ];

        $subjects = [];
        $now = now();
        foreach ($mapelList as $kode => $nama) {
            DB::table('subjects')->updateOrInsert(
                ['kode_mapel' => $kode],
                [
                    'nama_mapel' => $nama,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
            $subjects[$kode] = DB::table('subjects')
                ->where('kode_mapel', $kode)
                ->value('id');
        }

        // 3. Jadwal Pelajaran XI RPL 1 (Senin - Jumat)
        // Format: ['hari', 'kode_mapel', jam_mulai, jam_selesai]
        $jadwalList = [
            ['Senin',  'PP',     1, 2],
            ['Senin',  'MTK',    3, 5],
            ['Senin',  'B.Ing',  6, 8],
            ['Selasa', 'KDI',    1, 4],
            ['Selasa', 'BI',     5, 7],
            ['Rabu',   'MTK',    1, 3],
            ['Rabu',   'MBJ',    4, 6],
            ['Kamis',  'Penjas', 1, 3],
            ['Kamis',  'BK',     4, 5],
            ['Jumat',  'BI',     1, 3],
            ['Jumat',  'KDI',    4, 6],
        ];

        foreach ($jadwalList as [$hari, $kode, $jamMulai, $jamSelesai]) {
            $subjectId = $subjects[$kode] ?? null;
            if (!$subjectId) {
                continue;
            }

            DB::table('schedules')->updateOrInsert(
                [
                    'hari'        => $hari,
                    'jam_mulai'   => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                ],
                [
                    'subject_id'  => $subjectId,
                    'updated_at'  => $now,
                    'created_at'  => $now,
                ]
            );
        }

        // 4. Hirarki & Daftar Siswa XI RPL 1
        $this->call(StudentSeeder::class);
    }
}