<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::query()->delete();

        $anggotaKelas = [
            // === HIRARKI ATAS (Wali Kelas, Ketua Kelas, Wakil Ketua Kelas) ===
            [
                'nama' => 'Gunadi',
                'jabatan' => 'walas',
                'umur' => 35,
                'tanggal_lahir' => '1990-05-12',
                'hobi' => 'Membimbing & Ngoding',
                'skill' => 'Full-Stack Development & Manajemen Kelas',
                'quote' => 'Jadilah programmer yang tidak hanya bisa menulis kode, tapi juga memberi solusi.',
                'foto' => null,
            ],
            [
                'nama' => 'Agung Ismail',
                'jabatan' => 'ketua_kelas',
                'umur' => 16,
                'tanggal_lahir' => '2009-08-17',
                'hobi' => 'Olahraga & Gaming',
                'skill' => 'Leadership & Web Development',
                'quote' => 'Solid terus XI RPL 1!',
                'foto' => null,
            ],
            [
                'nama' => 'Kayla Nabilla Putri',
                'jabatan' => 'wakil_ketua',
                'umur' => 16,
                'tanggal_lahir' => '2009-04-21',
                'hobi' => 'Desain & Membaca',
                'skill' => 'UI/UX Design & Administrasi',
                'quote' => 'Kerja keras tidak pernah mengkhianati hasil.',
                'foto' => null,
            ],

            // === DAFTAR SISWA XI RPL 1 ===
            ['nama' => 'Adianku', 'jabatan' => 'siswa'],
            ['nama' => 'Ahmad Rafi', 'jabatan' => 'siswa'],
            ['nama' => 'Amelia Yohana', 'jabatan' => 'siswa'],
            ['nama' => 'Anisha Putri Andriyani', 'jabatan' => 'siswa'],
            ['nama' => 'Azzahra Ramadana Putri Herawati', 'jabatan' => 'siswa'],
            ['nama' => 'Azzahro Ramadani Putri Herwati', 'jabatan' => 'siswa'],
            ['nama' => 'Butet Citra Aritonang', 'jabatan' => 'siswa'],
            ['nama' => 'Chika Putria Safana', 'jabatan' => 'siswa'],
            ['nama' => 'Dafa Alfiansyah', 'jabatan' => 'siswa'],
            ['nama' => 'Damar Revianto', 'jabatan' => 'siswa'],
            ['nama' => 'Davidolfi Fabian', 'jabatan' => 'siswa'],
            ['nama' => 'Devin Hermawan', 'jabatan' => 'siswa'],
            ['nama' => 'Dzaki Novrianto', 'jabatan' => 'siswa'],
            ['nama' => 'Dzakki Pratama', 'jabatan' => 'siswa'],
            ['nama' => 'Fadil Pratama', 'jabatan' => 'siswa'],
            ['nama' => 'Fakhri Widya Rismanto', 'jabatan' => 'siswa'],
            ['nama' => 'Fakhrizi Tian Putra', 'jabatan' => 'siswa'],
            ['nama' => 'Faris Dharmawan', 'jabatan' => 'siswa'],
            ['nama' => 'Faulin Lovelia Oktavia', 'jabatan' => 'siswa'],
            ['nama' => 'Fazril Saputra', 'jabatan' => 'siswa'],
            ['nama' => 'Febriansyah Frastiago', 'jabatan' => 'siswa'],
            ['nama' => 'Fiorenza Cira Amabel Haloho', 'jabatan' => 'siswa'],
            ['nama' => 'Muhammad Arya Azizan', 'jabatan' => 'siswa'],
            ['nama' => 'Gugun Gumalayan', 'jabatan' => 'siswa'],
            ['nama' => 'Gwen Adriano Sule', 'jabatan' => 'siswa'],
            ['nama' => 'Hazwan Adji Sasongko Iswat', 'jabatan' => 'siswa'],
            ['nama' => 'Janeta Dhini Rahmawati', 'jabatan' => 'siswa'],
            ['nama' => 'Jelita Agustin', 'jabatan' => 'siswa'],
            ['nama' => 'Jonathan Stevanus', 'jabatan' => 'siswa'],
            ['nama' => 'Kenzo Winata', 'jabatan' => 'siswa'],
            ['nama' => 'Keysa Meylika Zahra', 'jabatan' => 'siswa'],
            ['nama' => 'M Raffi Az Zarqy Siregar', 'jabatan' => 'siswa'],
            ['nama' => 'Miftahul Shidiq Febryandy', 'jabatan' => 'siswa'],
        ];

        foreach ($anggotaKelas as $data) {
            Student::create([
                'nama' => $data['nama'],
                'jabatan' => $data['jabatan'],
                'umur' => $data['umur'] ?? 16,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? '2009-01-01',
                'hobi' => $data['hobi'] ?? 'Ngoding & Eksplorasi Teknologi',
                'skill' => $data['skill'] ?? 'HTML, CSS, PHP & Laravel',
                'quote' => $data['quote'] ?? 'Tetap semangat belajar di XI RPL 1!',
                'foto' => $data['foto'] ?? null,
            ]);
        }
    }
}