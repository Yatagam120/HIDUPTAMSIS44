<x-app-layout>
    <style>
        /* Kontras warna tema gelap */
        body[data-theme="mode-gelap"],
        body[data-theme="academic-trust"],
        body[data-theme="deep-ocean"],
        body[data-theme="midnight-scholar"],
        body[data-theme="forest-academy"] {
            --text-main: #f1f5f9 !important;
            --card-bg: rgba(15, 23, 42, 0.9) !important;
            --border-color: rgba(148, 163, 184, 0.28) !important;
            color: #f1f5f9 !important;
        }

        /* Kontras warna tema terang */
        body[data-theme="teal-growth"],
        body[data-theme="creative-spark"],
        body[data-theme="lavender-dream"],
        body[data-theme="soft-berry"],
        body[data-theme="morning-assembly"] {
            --text-main: #0f172a !important;
            --card-bg: rgba(255, 255, 255, 0.95) !important;
            --border-color: rgba(15, 23, 42, 0.16) !important;
            color: #0f172a !important;
        }

        .settings-container .theme-card {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .settings-option-btn {
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease, background-color 0.18s ease;
            border: 1.5px solid var(--border-color) !important;
            opacity: 1 !important;
        }

        body[data-theme="mode-gelap"] .settings-option-btn:not(.is-selected),
        body[data-theme="academic-trust"] .settings-option-btn:not(.is-selected),
        body[data-theme="deep-ocean"] .settings-option-btn:not(.is-selected),
        body[data-theme="midnight-scholar"] .settings-option-btn:not(.is-selected),
        body[data-theme="forest-academy"] .settings-option-btn:not(.is-selected) {
            background-color: rgba(30, 41, 59, 0.82) !important;
            color: #f8fafc !important;
        }

        body[data-theme="teal-growth"] .settings-option-btn:not(.is-selected),
        body[data-theme="creative-spark"] .settings-option-btn:not(.is-selected),
        body[data-theme="lavender-dream"] .settings-option-btn:not(.is-selected),
        body[data-theme="soft-berry"] .settings-option-btn:not(.is-selected),
        body[data-theme="morning-assembly"] .settings-option-btn:not(.is-selected) {
            background-color: rgba(248, 250, 252, 0.96) !important;
            color: #0f172a !important;
        }

        .settings-option-btn.is-selected {
            background-color: var(--primary) !important;
            color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: 0 0 0 2px var(--primary), 0 6px 16px rgba(59, 130, 246, 0.35);
        }

        .settings-input {
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
        }

        body[data-theme="mode-gelap"] .settings-input,
        body[data-theme="academic-trust"] .settings-input,
        body[data-theme="deep-ocean"] .settings-input,
        body[data-theme="midnight-scholar"] .settings-input,
        body[data-theme="forest-academy"] .settings-input {
            background-color: rgba(15, 23, 42, 0.75) !important;
            color: #f8fafc !important;
        }

        body[data-theme="teal-growth"] .settings-input,
        body[data-theme="creative-spark"] .settings-input,
        body[data-theme="lavender-dream"] .settings-input,
        body[data-theme="soft-berry"] .settings-input,
        body[data-theme="morning-assembly"] .settings-input {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
    </style>

    <div class="settings-container max-w-4xl mx-auto space-y-5 px-2 sm:px-0">
        <div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold hover:opacity-80" style="color: var(--primary);">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs sm:text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="theme-card rounded-2xl p-5 sm:p-6 border space-y-1">
            <h1 class="text-xl sm:text-2xl font-extrabold">Pengaturan Tampilan & Aplikasi</h1>
            <p class="text-xs sm:text-sm opacity-75">Sesuaikan tema warna, gaya grafik, huruf, bahasa, dan efek suara.</p>
        </div>

        <!-- 1. Tema Warna -->
        <div class="theme-card rounded-2xl p-5 border space-y-3">
            <h2 class="text-sm sm:text-base font-extrabold">🎨 Tema Warna Antarmuka</h2>
            @php
                $themes = [
                    ['id' => 'mode-gelap',       'name' => 'Mode Gelap',       'swatch' => '#3b82f6'],
                    ['id' => 'academic-trust',   'name' => 'Academic Trust',   'swatch' => '#2563eb'],
                    ['id' => 'deep-ocean',       'name' => 'Deep Ocean',       'swatch' => '#0284c7'],
                    ['id' => 'midnight-scholar', 'name' => 'Midnight Scholar', 'swatch' => '#6366f1'],
                    ['id' => 'forest-academy',   'name' => 'Forest Academy',   'swatch' => '#10b981'],
                    ['id' => 'teal-growth',      'name' => 'Teal Growth',      'swatch' => '#0d9488'],
                    ['id' => 'creative-spark',   'name' => 'Creative Spark',   'swatch' => '#f59e0b'],
                    ['id' => 'lavender-dream',   'name' => 'Lavender Dream',   'swatch' => '#8b5cf6'],
                    ['id' => 'soft-berry',       'name' => 'Soft Berry',       'swatch' => '#ec4899'],
                    ['id' => 'morning-assembly', 'name' => 'Morning Assembly', 'swatch' => '#ea580c'],
                ];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                @foreach($themes as $th)
                    <button type="button"
                            data-setting-group="theme"
                            data-setting-value="{{ $th['id'] }}"
                            onclick="setSettingTheme('{{ $th['id'] }}')"
                            class="settings-option-btn rounded-xl p-3 text-left flex items-center gap-2 text-xs font-extrabold">
                        <span class="w-4 h-4 rounded-full shrink-0 border border-white/40" style="background-color: {{ $th['swatch'] }};"></span>
                        <span class="truncate">{{ $th['name'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- 2. Mode Grafik -->
        <div class="theme-card rounded-2xl p-5 border space-y-3">
            <h2 class="text-sm sm:text-base font-extrabold">✨ Gaya Grafik & Animasi</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <button type="button" data-setting-group="graphic" data-setting-value="simple" onclick="setSettingGraphic('simple')" class="settings-option-btn rounded-xl p-3 text-xs font-extrabold text-center">Style Simple</button>
                <button type="button" data-setting-group="graphic" data-setting-value="minimalist" onclick="setSettingGraphic('minimalist')" class="settings-option-btn rounded-xl p-3 text-xs font-extrabold text-center">Minimalist</button>
                <button type="button" data-setting-group="graphic" data-setting-value="legacy" onclick="setSettingGraphic('legacy')" class="settings-option-btn rounded-xl p-3 text-xs font-extrabold text-center">Legacy</button>
                <button type="button" data-setting-group="graphic" data-setting-value="modern" onclick="setSettingGraphic('modern')" class="settings-option-btn rounded-xl p-3 text-xs font-extrabold text-center">Modern Glow</button>
            </div>
        </div>

        <!-- 3. Jenis Huruf & Bahasa & SFX -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="theme-card rounded-2xl p-5 border space-y-3">
                <h2 class="text-sm font-extrabold">🔤 Jenis Huruf</h2>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" data-setting-group="font" data-setting-value="sans" onclick="setSettingFont('sans')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Sans</button>
                    <button type="button" data-setting-group="font" data-setting-value="serif" onclick="setSettingFont('serif')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Serif</button>
                    <button type="button" data-setting-group="font" data-setting-value="mono" onclick="setSettingFont('mono')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Mono</button>
                </div>
            </div>

            <div class="theme-card rounded-2xl p-5 border space-y-3">
                <h2 class="text-sm font-extrabold">🌐 Bahasa</h2>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" data-setting-group="lang" data-setting-value="id" onclick="setSettingLang('id')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Indonesia</button>
                    <button type="button" data-setting-group="lang" data-setting-value="en" onclick="setSettingLang('en')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">English</button>
                </div>
            </div>

            <div class="theme-card rounded-2xl p-5 border space-y-3">
                <h2 class="text-sm font-extrabold">🔊 Efek Suara (SFX)</h2>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" data-setting-group="sfx" data-setting-value="on" onclick="setSettingSfx('on')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Aktif</button>
                    <button type="button" data-setting-group="sfx" data-setting-value="off" onclick="setSettingSfx('off')" class="settings-option-btn rounded-xl py-2.5 px-2 text-xs font-extrabold">Mati</button>
                </div>
            </div>
        </div>

        <!-- 4. Kirim Saran / Laporan Bug -->
        @if(\Illuminate\Support\Facades\Route::has('feedback.store'))
            <div class="theme-card rounded-2xl p-5 border space-y-3">
                <h2 class="text-sm sm:text-base font-extrabold">💬 Kasih Saran / Laporan Bug</h2>
                <form method="POST" action="{{ route('feedback.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold mb-1">Pesan / Saran</label>
                        <textarea name="message" rows="3" required placeholder="Tulis saran atau kendala yang ditemukan..." class="settings-input w-full rounded-xl p-3 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary text-white">Kirim Masukan</button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <script>
        function highlightSettingGroup(group, value) {
            document.querySelectorAll(`[data-setting-group="${group}"]`).forEach(btn => {
                if (btn.getAttribute('data-setting-value') === value) {
                    btn.classList.add('is-selected');
                } else {
                    btn.classList.remove('is-selected');
                }
            });
        }

        function setSettingTheme(theme) {
            if (typeof playSfx === 'function') playSfx('click');
            document.body.style.removeProperty('color');
            document.body.style.removeProperty('background');
            document.body.style.removeProperty('background-color');
            document.body.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('app_theme', theme);
            highlightSettingGroup('theme', theme);
        }

        function setSettingGraphic(graphic) {
            if (typeof playSfx === 'function') playSfx('click');
            document.body.setAttribute('data-graphic', graphic);
            localStorage.setItem('app_graphic', graphic);
            highlightSettingGroup('graphic', graphic);
        }

        function setSettingFont(font) {
            if (typeof playSfx === 'function') playSfx('click');
            document.body.setAttribute('data-font', font);
            localStorage.setItem('app_font', font);
            highlightSettingGroup('font', font);
        }

        function setSettingLang(lang) {
            if (typeof playSfx === 'function') playSfx('click');
            localStorage.setItem('app_lang', lang);
            if (typeof applyLanguage === 'function') applyLanguage(lang);
            highlightSettingGroup('lang', lang);
        }

        function setSettingSfx(state) {
            localStorage.setItem('app_sfx', state);
            if (state === 'on' && typeof playSfx === 'function') playSfx('click');
            highlightSettingGroup('sfx', state);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const curTheme   = localStorage.getItem('app_theme')   || document.body.getAttribute('data-theme')   || 'mode-gelap';
            const curGraphic = localStorage.getItem('app_graphic') || document.body.getAttribute('data-graphic') || 'simple';
            const curFont    = localStorage.getItem('app_font')    || document.body.getAttribute('data-font')    || 'sans';
            const curLang    = localStorage.getItem('app_lang')    || 'id';
            const curSfx     = localStorage.getItem('app_sfx')     || 'on';

            setSettingTheme(curTheme);
            highlightSettingGroup('graphic', curGraphic);
            highlightSettingGroup('font', curFont);
            highlightSettingGroup('lang', curLang);
            highlightSettingGroup('sfx', curSfx);
        });
    </script>
</x-app-layout>