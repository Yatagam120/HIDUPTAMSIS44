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

        // 2. Deteksi Kolom Tabel 'subjects' & Isi Mapel
        $cols = Schema::getColumnListing('subjects');
        $kodeCol = collect(['kode_mapel', 'kode', 'code', 'singkatan'])->first(fn ($c) => in_array($c, $cols));
        $namaCol = collect(['nama_mapel', 'nama', 'name', 'judul', 'title'])->first(fn ($c) => in_array($c, $cols));

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

        // 3. Isi Jadwal Pelajaran XI RPL 1 (Senin - Jumat)
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