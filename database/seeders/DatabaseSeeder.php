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
            // isi daftar mapel kamu di sini sesuai yang sudah ada
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
    }
}