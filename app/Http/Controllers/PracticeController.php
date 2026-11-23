<?php

namespace App\Http\Controllers;

class PracticeController extends Controller
{
    private function getBanks(): array
    {
        return [
            'mtk' => [
                'title' => 'Latihan Matematika (MTK)',
                'subtitle' => 'Soal pilihan ganda Aljabar, Fungsi, Matriks, dan Logika Matematika XI RPL 1.',
                'questions' => [
                    [
                        'q' => 'Jika $f(x) = 3x - 5$, maka nilai dari $f(4)$ adalah...',
                        'options' => ['5', '7', '12', '17'],
                        'answer' => 1,
                        'explain' => '$f(4) = 3(4) - 5 = 12 - 5 = 7$.',
                    ],
                    [
                        'q' => 'Nilai dari $^2\\log 32$ adalah...',
                        'options' => ['4', '5', '6', '8'],
                        'answer' => 1,
                        'explain' => '$2^5 = 32$, sehingga $^2\\log 32 = 5$.',
                    ],
                    [
                        'q' => 'Suku ke-10 dari barisan aritmetika $2, 5, 8, 11, \\dots$ adalah...',
                        'options' => ['27', '29', '31', '32'],
                        'answer' => 1,
                        'explain' => '$U_{10} = a + 9b = 2 + 9(3) = 29$.',
                    ],
                    [
                        'q' => 'Determinan dari matriks $A = \\begin{pmatrix} 4 & 2 \\\\ 3 & 5 \\end{pmatrix}$ adalah...',
                        'options' => ['14', '20', '26', '6'],
                        'answer' => 0,
                        'explain' => '$\\det(A) = (4 \\times 5) - (2 \\times 3) = 20 - 6 = 14$.',
                    ],
                    [
                        'q' => 'Turunan pertama dari $f(x) = 4x^3 - 2x^2 + 7$ adalah...',
                        'options' => ['12x^2 - 4x', '12x^2 - 2x', '4x^2 - 4x', '12x^3 - 4x'],
                        'answer' => 0,
                        'explain' => '$f\'(x) = 3(4)x^2 - 2(2)x = 12x^2 - 4x$.',
                    ],
                ],
            ],
            'koding' => [
                'title' => 'Latihan Koding (RPL)',
                'subtitle' => 'Soal pilihan ganda PHP/Laravel, SQL Database, HTML/JS, dan Logika Pemrograman.',
                'questions' => [
                    [
                        'q' => 'Perintah Artisan di Laravel untuk menjalankan seluruh file migration yang belum dieksekusi adalah...',
                        'options' => ['php artisan serve', 'php artisan migrate', 'php artisan make:model', 'php artisan route:list'],
                        'answer' => 1,
                        'explain' => '`php artisan migrate` mengeksekusi schema tabel baru ke database.',
                    ],
                    [
                        'q' => 'Dalam query SQL, klausa apa yang digunakan untuk memfilter hasil setelah proses agregasi `GROUP BY`?',
                        'options' => ['WHERE', 'ORDER BY', 'HAVING', 'DISTINCT'],
                        'answer' => 2,
                        'explain' => '`HAVING` dipakai untuk memfilter hasil fungsi agregat setelah `GROUP BY`.',
                    ],
                    [
                        'q' => 'Directive Blade di Laravel yang wajib disertakan di dalam form `POST` untuk mencegah serangan CSRF adalah...',
                        'options' => ['@auth', '@csrf', '@yield', '@section'],
                        'answer' => 1,
                        'explain' => '`@csrf` menghasilkan token hidden `_token` untuk validasi keamanan form.',
                    ],
                    [
                        'q' => 'Apa output dari kode PHP berikut: `echo count([10, 20, 30, 40]);`?',
                        'options' => ['3', '4', '40', '100'],
                        'answer' => 1,
                        'explain' => 'Array berisi 4 elemen sehingga `count()` mengembalikan angka `4`.',
                    ],
                    [
                        'q' => 'HTTP Status Code `419` pada aplikasi web Laravel menandakan error apa?',
                        'options' => ['Not Found', 'Server Internal Error', 'Page Expired / CSRF Token Mismatch', 'Unauthorized'],
                        'answer' => 2,
                        'explain' => 'Status `419 Page Expired` terjadi saat token CSRF atau session sudah habis/tidak cocok.',
                    ],
                ],
            ],
        ];
    }

    public function index()
    {
        $banks = $this->getBanks();
        return view('practice.index', compact('banks'));
    }

    public function show(string $topic)
    {
        $banks = $this->getBanks();
        $key = strtolower(trim($topic));
        if (!isset($banks[$key])) {
            abort(404);
        }

        $quiz = $banks[$key];
        return view('practice.show', compact('quiz', 'key'));
    }
}