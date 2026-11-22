<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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

        // 2. Deteksi Kolom Tabel 'subjects' & Isi Seluruh Mapel XI RPL 1
        $cols = Schema::getColumnListing('subjects');
        $kodeCol = collect(['kode_mapel', 'kode', 'code', 'singkatan', 'short_name'])->first(fn ($c) => in_array($c, $cols));
        $namaCol = collect(['nama_mapel', 'nama', 'name', 'judul', 'title'])->first(fn ($c) => in_array($c, $cols));

        $mapelList = [
            'MBJ(J'    => 'Muatan Bahasa Jepang',
            'PP'       => 'Pendidikan Pancasila',
            'B.Ing'    => 'Bahasa Inggris',
            'BK'       => 'Bimbingan Konseling',
            'BI'       => 'Bahasa Indonesia',
            'MTK'      => 'Matematika',
            'KDI'      => 'Kreativitas & Desain Interaktif',
            'Penjas'   => 'Pendidikan Jasmani',
            'KTS'      => 'Ketamansiswaan',
            'STI'      => 'Sistem Teknologi Informasi',
            'PL(RPL1)' => 'Pemrograman Lanjut (RPL 1)',
            'SI'       => 'Sejarah Indonesia',
            'KWH'      => 'Kewirausahaan',
            'PAI'      => 'Pendidikan Agama Islam',
        ];

        $subjects = [];
        $now = now();

        foreach ($mapelList as $kode => $nama) {
            $lookup = [];
            $values = [];

            if ($kodeCol) {
                $lookup[$kodeCol] = $kode;
                $values[$kodeCol] = $kode;
            }
            if ($namaCol) {
                if (empty($lookup)) {
                    $lookup[$namaCol] = $nama;
                }
                $values[$namaCol] = $nama;
            }
            if (in_array('created_at', $cols)) {
                $values['created_at'] = $now;
            }
            if (in_array('updated_at', $cols)) {
                $values['updated_at'] = $now;
            }

            if (!empty($lookup)) {
                DB::table('subjects')->updateOrInsert($lookup, $values);
                $subjects[$kode] = DB::table('subjects')->where($lookup)->value('id');
            }
        }

        // 3. Isi Jadwal Pelajaran XI RPL 1 Sesuai Tabel Asli (Senin - Jumat)
        $jadwalList = [
            // Senin
            ['Senin',  'MBJ(J',    1, 2],
            ['Senin',  'PP',       3, 4],
            ['Senin',  'B.Ing',    5, 6],
            ['Senin',  'BK',       7, 7],
            ['Senin',  'BI',       8, 10],

            // Selasa
            ['Selasa', 'MTK',      1, 3],
            ['Selasa', 'KDI',      4, 6],
            ['Selasa', 'Penjas',   7, 8],
            ['Selasa', 'KTS',      9, 9],
            ['Selasa', 'STI',      10, 11],

            // Rabu
            ['Rabu',   'PL(RPL1)', 1, 5],
            ['Rabu',   'PL(RPL1)', 6, 10],

            // Kamis
            ['Kamis',  'SI',       1, 2],
            ['Kamis',  'KWH',      3, 4],
            ['Kamis',  'PAI',      5, 7],
            ['Kamis',  'B.Ing',    8, 9],

            // Jumat
            ['Jumat',  'PL(RPL1)', 1, 6],
            ['Jumat',  'PL(RPL1)', 7, 10],
        ];

        DB::table('schedules')->delete();

        foreach ($jadwalList as [$hari, $kode, $jamMulai, $jamSelesai]) {
            $subjectId = $subjects[$kode] ?? null;
            if (!$subjectId) {
                continue;
            }

            DB::table('schedules')->insert([
                'hari'        => $hari,
                'subject_id'  => $subjectId,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // 4. Hirarki & Daftar Siswa XI RPL 1
        $this->call(StudentSeeder::class);
    }
}