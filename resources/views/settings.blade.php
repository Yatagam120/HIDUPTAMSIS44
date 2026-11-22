<x-app-layout>
    <style>
                .grid-5-cols {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.75rem;
        }
        .grid-3-cols {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.75rem;
        }
        .grid-4-cols {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
        }
        @media (max-width: 768px) {
            .grid-5-cols, .grid-4-cols { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .grid-3-cols { grid-template-columns: 1fr; }
        }
        .setting-pill {
            border: 1.5px solid var(--border-color);
            background: rgba(15, 23, 42, 0.25);
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
        }
        .setting-pill:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }
        .setting-pill.active-pill {
            border-color: var(--primary) !important;
            background: var(--primary-soft) !important;
            box-shadow: 0 0 14px rgba(59, 130, 246, 0.35);
        }
    </style>

    <div class="max-w-5xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-300 border border-red-500/40 text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Panel Pengaturan Tampilan Lengkap -->
        <div class="theme-card rounded-2xl shadow-lg p-6 sm:p-8 border theme-border space-y-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold" data-i18n="settings_title">Pengaturan Tampilan</h1>
                <p class="text-xs sm:text-sm opacity-75 mt-0.5" data-i18n="settings_sub">Sesuaikan tema gradien warna, gaya huruf, suara efek, dan bahasa aplikasi.</p>
            </div>

            <!-- Tema Gelap (Gradien) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2.5" data-i18n="dark_theme_label">Tema Gelap (Gradien)</h2>
                <div class="grid-5-cols">
                    @foreach([
                        ['id' => 'academic-trust', 'name' => 'Academic Trust', 'dot' => '#2563eb'],
                        ['id' => 'deep-ocean', 'name' => 'Deep Ocean', 'dot' => '#0891b2'],
                        ['id' => 'midnight-scholar', 'name' => 'Midnight Scholar', 'dot' => '#7c3aed'],
                        ['id' => 'forest-academy', 'name' => 'Forest Academy', 'dot' => '#059669'],
                        ['id' => 'mode-gelap', 'name' => 'Mode Gelap', 'dot' => '#18181b'],
                    ] as $t)
                        <button type="button" onclick="selectTheme('{{ $t['id'] }}')" data-theme-btn="{{ $t['id'] }}"
                                class="setting-pill rounded-full px-3.5 py-2.5 flex items-center gap-2.5 text-xs font-bold text-left">
                            <span class="w-4 h-4 rounded-full shrink-0 border border-white/40" style="background: {{ $t['dot'] }};"></span>
                            <span class="truncate">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tema Terang (Gradien) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2.5" data-i18n="light_theme_label">Tema Terang (Gradien)</h2>
                <div class="grid-5-cols">
                    @foreach([
                        ['id' => 'teal-growth', 'name' => 'Teal Growth', 'dot' => '#2dd4bf'],
                        ['id' => 'creative-spark', 'name' => 'Creative Spark', 'dot' => '#d946ef'],
                        ['id' => 'lavender-dream', 'name' => 'Lavender Dream', 'dot' => '#818cf8'],
                        ['id' => 'soft-berry', 'name' => 'Soft Berry', 'dot' => '#fb7185'],
                        ['id' => 'morning-assembly', 'name' => 'Morning Assembly', 'dot' => '#fde047'],
                    ] as $t)
                        <button type="button" onclick="selectTheme('{{ $t['id'] }}')" data-theme-btn="{{ $t['id'] }}"
                                class="setting-pill rounded-full px-3.5 py-2.5 flex items-center gap-2.5 text-xs font-bold text-left">
                            <span class="w-4 h-4 rounded-full shrink-0 border border-black/20" style="background: {{ $t['dot'] }};"></span>
                            <span class="truncate">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Gaya Huruf -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2.5" data-i18n="font_style_label">Gaya Huruf</h2>
                <div class="grid-3-cols">
                    <button type="button" onclick="selectFont('sans')" data-font-btn="sans"
                            class="setting-pill rounded-full px-4 py-2.5 text-xs font-bold text-center" style="font-family: 'Figtree', sans-serif;">
                        Modern (Sans)
                    </button>
                    <button type="button" onclick="selectFont('serif')" data-font-btn="serif"
                            class="setting-pill rounded-full px-4 py-2.5 text-xs font-bold text-center" style="font-family: Georgia, serif;">
                        Klasik (Serif)
                    </button>
                    <button type="button" onclick="selectFont('mono')" data-font-btn="mono"
                            class="setting-pill rounded-full px-4 py-2.5 text-xs font-bold text-center" style="font-family: monospace;">
                        Koding (Mono)
                    </button>
                </div>
            </div>

            <!-- Bahasa (4 Bahasa Full) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2.5" data-i18n="lang_label">Bahasa</h2>
                <div class="grid-4-cols"><button type="button" onclick="selectLang('id')" data-lang-btn="id"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🇮🇩 Indonesia
                    </button>
                    <button type="button" onclick="selectLang('en')" data-lang-btn="en"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🇬🇧 English
                    </button>
                    <button type="button" onclick="selectLang('ja')" data-lang-btn="ja"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🇯🇵 日本語 (Jepang)
                    </button>
                    <button type="button" onclick="selectLang('ru')" data-lang-btn="ru"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🇷🇺 Русский (Rusia)
                    </button>
                </div>
            </div>

            <!-- Efek Suara (SFX) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2.5" data-i18n="sfx_label">Efek Suara (SFX)</h2>
                <div class="space-y-2">
                    <button type="button" onclick="selectSfx('active')" data-sfx-btn="active"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🔊 <span data-i18n="sfx_on">Aktif</span>
                    </button>
                    <button type="button" onclick="selectSfx('muted')" data-sfx-btn="muted"
                            class="setting-pill w-full rounded-full px-4 py-2 text-xs font-bold text-center">
                        🔇 <span data-i18n="sfx_off">Senyap</span>
                    </button>
                </div>
            </div>

            <!-- Kode Unik (Easter Egg) -->
            <div class="pt-3 border-t border-gray-200/20">
                <h2 class="text-sm font-extrabold" data-i18n="easter_title">Kode Unik (Easter Egg) 🎁</h2>
                <p class="text-xs opacity-75 mt-0.5 mb-3" data-i18n="easter_sub">Punya kode rahasia kelas XI RPL 1? Masukkan di sini untuk membuka fitur tersembunyi!</p>

                <div class="flex gap-2.5">
                    <input type="text" id="easter-code-input" placeholder="MASUKKAN KODE UNIK..."
                           class="flex-1 rounded-xl border px-4 py-2.5 text-xs sm:text-sm uppercase tracking-wider font-bold">
                    <button type="button" onclick="claimEasterEgg()"
                            class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold theme-primary shadow-md hover:opacity-90 transition"
                            data-i18n="klaim_btn">
                        Klaim
                    </button>
                </div>
                <p id="easter-feedback" class="hidden mt-2 text-xs font-bold"></p>
            </div>
        </div>

        <!-- Kasih Saran & Laporan Bug -->
        <div class="theme-card rounded-2xl shadow-lg p-6 border theme-border">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold" data-i18n="saran_btn">Kasih Saran & Laporan Bug</h2>
                    <p class="text-xs opacity-75 mt-0.5" data-i18n="saran_sub">Beri rating bintang (bisa desimal seperti 4.5 / 3.4), komentar, atau kirim foto/video jika menemukan bug.</p>
                </div>

                <button type="button" onclick="playSfx('click'); document.getElementById('feedback-panel').classList.toggle('hidden')"
                        class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold theme-primary shadow-md hover:opacity-90 transition flex items-center gap-1.5">
                    <span>⭐</span>
                    <span data-i18n="saran_btn">Kasih Saran & Laporan Bug</span>
                </button>
            </div>

            <div id="feedback-panel" class="{{ $errors->any() ? '' : 'hidden' }} mt-5 pt-5 border-t border-gray-200/25">
                <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold mb-1.5" data-i18n="rating_label">Rating Web (0.0 – 5.0 Bintang)</label>
                        <div class="flex flex-wrap items-center gap-4">
                            <input type="range" id="rating-slider" min="0" max="5" step="0.1" value="5.0"
                                   oninput="syncStarRating(this.value)"
                                   class="w-48 accent-amber-400 cursor-pointer">

                            <div class="flex items-center gap-2">
                                <input type="number" id="rating-number" name="rating" min="0" max="5" step="0.1" value="5.0" required
                                       oninput="syncStarRating(this.value)"
                                       class="w-20 rounded-xl border p-2 text-sm font-extrabold text-center">
                                <span id="star-visual" class="text-amber-400 text-base font-bold tracking-wider">★★★★★ (5.0)</span>
                            </div>
                        </div>
                        <p class="text-[11px] opacity-70 mt-1" data-i18n="rating_hint">Geser slider atau ketik angka desimal seperti 4.5, 3.4, atau 5.0.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1" data-i18n="komentar_label">Komentar / Saran / Detail Bug</label>
                        <textarea name="komentar" rows="3" required
                                  placeholder="Tulis saran fitur, kritik tampilan, atau jelaskan bug yang ditemukan..."
                                  class="w-full rounded-xl border p-2.5 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1" data-i18n="lampiran_bug_label">Lampiran Foto / Video Bug (Opsional)</label>
                        <input type="file" name="media[]" multiple accept="image/*,video/*"
                               class="w-full rounded-xl border p-2 text-xs">
                    </div>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition"
                            data-i18n="kirim_saran_btn">
                        Kirim Saran ke Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function refreshActivePills() {
            const curTheme = localStorage.getItem('app_theme') || 'academic-trust';
            const curFont  = localStorage.getItem('app_font') || 'sans';
            const curLang  = localStorage.getItem('app_lang') || 'id';
            const curSfx   = localStorage.getItem('app_sfx') || 'active';

            document.querySelectorAll('[data-theme-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.themeBtn === curTheme));
            document.querySelectorAll('[data-font-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.fontBtn === curFont));
            document.querySelectorAll('[data-lang-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.langBtn === curLang));
            document.querySelectorAll('[data-sfx-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.sfxBtn === curSfx));
        }

        function selectTheme(theme) {
            localStorage.setItem('app_theme', theme);
            document.body.setAttribute('data-theme', theme);
            playSfx('click');
            refreshActivePills();
        }

        function selectFont(font) {
            localStorage.setItem('app_font', font);
            document.body.setAttribute('data-font', font);
            playSfx('click');
            refreshActivePills();
        }

        function selectLang(lang) {
            applyLanguage(lang);
            playSfx('click');
            refreshActivePills();
        }

        function selectSfx(mode) {
            localStorage.setItem('app_sfx', mode);
            if (mode === 'active') playSfx('enter');
            refreshActivePills();
        }

        function claimEasterEgg() {
            const code = (document.getElementById('easter-code-input').value || '').trim().toUpperCase();
            const fb = document.getElementById('easter-feedback');
            fb.classList.remove('hidden');

            if (code === 'XIRPL1' || code === 'TAMSIS' || code === 'ARCHIE' || code === 'BEBEK') {
                playSfx('secret');
                fb.className = 'mt-2 text-xs font-bold text-amber-300';
                fb.textContent = '🎉 Kode rahasia berhasil diklaim! Selamat datang anggota spesial XI RPL 1!';
            } else {
                playSfx('click');
                fb.className = 'mt-2 text-xs font-bold text-red-400';
                fb.textContent = '❌ Kode unik tidak valid. Coba lagi!';
            }
        }

        function syncStarRating(val) {
            let num = parseFloat(val);
            if (isNaN(num)) num = 0;
            if (num < 0) num = 0;
            if (num > 5) num = 5;

            document.getElementById('rating-slider').value = num;
            document.getElementById('rating-number').value = num.toFixed(1);

            const fullStars = Math.floor(num);
            const halfStar = (num - fullStars) >= 0.4 ? '⯪' : '';
            const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
            const starsStr = '★'.repeat(fullStars) + halfStar + '☆'.repeat(Math.max(0, emptyStars));

            document.getElementById('star-visual').textContent = `${starsStr} (${num.toFixed(1)})`;
        }

        document.addEventListener('DOMContentLoaded', refreshActivePills);
    </script>
</x-app-layout>