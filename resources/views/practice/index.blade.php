<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">🧠 Pusat Latihan Soal XI RPL 1</h1>
                <p class="text-xs opacity-75 mt-1">Pilih cabang materi latihan pilihan ganda interaktif lengkap dengan nilai otomatis dan pembahasan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">← Kembali</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('practice.show', 'mtk') }}"
               class="theme-card border theme-border rounded-2xl p-6 space-y-3 shadow-lg hover:scale-[1.01] transition">
                <div class="w-12 h-12 rounded-2xl theme-primary flex items-center justify-center text-xl font-extrabold shadow">∑</div>
                <h2 class="text-lg font-extrabold">Latihan MTK (Matematika)</h2>
                <p class="text-xs opacity-80">Pilihan ganda Fungsi, Logaritma, Barisan Aritmetika, Matriks, dan Turunan Dasar.</p>
                <div class="inline-block px-3 py-1.5 rounded-xl theme-soft border theme-border text-xs font-extrabold">
                    Mulai Latihan MTK →
                </div>
            </a>

            <a href="{{ route('practice.show', 'koding') }}"
               class="theme-card border theme-border rounded-2xl p-6 space-y-3 shadow-lg hover:scale-[1.01] transition">
                <div class="w-12 h-12 rounded-2xl theme-primary flex items-center justify-center text-xl font-extrabold shadow">&lt;/&gt;</div>
                <h2 class="text-lg font-extrabold">Latihan Koding (RPL)</h2>
                <p class="text-xs opacity-80">Pilihan ganda Laravel Artisan, SQL Query, Keamanan CSRF/419, dan Logika Pemrograman.</p>
                <div class="inline-block px-3 py-1.5 rounded-xl theme-soft border theme-border text-xs font-extrabold">
                    Mulai Latihan Koding →
                </div>
            </a>
        </div>
    </div>
</x-app-layout>