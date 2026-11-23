<x-app-layout>
    @php
        $user = auth()->user();
        $rawRole = strtolower(trim((string) ($user->role ?? $user->jabatan ?? 'siswa')));
        $isAdminRole = $rawRole === 'admin';

        $approvedMusics = \Illuminate\Support\Facades\Schema::hasTable('app_musics')
            ? \Illuminate\Support\Facades\DB::table('app_musics')->where('status', 'approved')->orderByDesc('id')->get()
            : collect();

        $darkThemes = [
            ['id' => 'academic-trust',   'name' => 'Academic Trust',   'swatch' => 'linear-gradient(135deg, #0a192f, #3b82f6)'],
            ['id' => 'deep-ocean',       'name' => 'Deep Ocean',       'swatch' => 'linear-gradient(135deg, #041c32, #06b6d4)'],
            ['id' => 'midnight-scholar', 'name' => 'Midnight Scholar', 'swatch' => 'linear-gradient(135deg, #0f0c29, #8b5cf6)'],
            ['id' => 'forest-academy',   'name' => 'Forest Academy',   'swatch' => 'linear-gradient(135deg, #052e16, #10b981)'],
            ['id' => 'mode-gelap',       'name' => 'Mode Gelap',       'swatch' => 'linear-gradient(135deg, #09090b, #6366f1)'],
        ];

        $lightThemes = [
            ['id' => 'teal-growth',      'name' => 'Teal Growth',      'swatch' => 'linear-gradient(135deg, #ccfbf1, #0d9488)'],
            ['id' => 'creative-spark',   'name' => 'Creative Spark',   'swatch' => 'linear-gradient(135deg, #fae8ff, #c026d3)'],
            ['id' => 'lavender-dream',   'name' => 'Lavender Dream',   'swatch' => 'linear-gradient(135deg, #e0e7ff, #4f46e5)'],
            ['id' => 'soft-berry',       'name' => 'Soft Berry',       'swatch' => 'linear-gradient(135deg, #ffe4e6, #e11d48)'],
            ['id' => 'morning-assembly', 'name' => 'Morning Assembly', 'swatch' => 'linear-gradient(135deg, #fef3c7, #d97706)'],
        ];
    @endphp

    <!-- [REMOVED] LIVE PREVIEW TAMPILAN -->
    <div class="text-lg font-extrabold">Contoh Heading Jadwal XI RPL 1</div>
    <p class="text-sm opacity-85">Contoh teks deskripsi tugas, tenggat waktu, dan catatan mata pelajaran agar mudah dibaca.</p>
    <div class="pt-1 flex flex-wrap items-center gap-2">
        <span class="theme-primary px-3 py-1.5 rounded-lg text-xs font-bold inline-block">Contoh Tombol Utama</span>
        <span class="badge-success px-2.5 py-1 rounded-full text-xs font-bold border inline-block">Selesai</span>
        <span class="badge-warning px-2.5 py-1 rounded-full text-xs font-bold border inline-block">Tenggat</span>
    </div>
</div>
<!-- MODULE-POLISH-V6-END -->


<!-- SETTINGS-PERFECTION-START -->
<script id="settings-clean-binding">
(function () {
    const themeMap = {
        'academic trust': 'academic-trust',
        'deep ocean': 'deep-ocean',
        'midnight scholar': 'midnight-scholar',
        'forest academy': 'forest-academy',
        'mode gelap': 'mode-gelap',
        'tech growth': 'tech-growth',
        'creative spark': 'creative-spark',
        'lavender dream': 'lavender-dream',
        'soft berry': 'soft-berry',
        'morning assembly': 'morning-assembly'
    };
    const graphicMap = { 'legacy': 'legacy', 'minimalist': 'minimalist', 'simple': 'simple' };
    const fontMap = { 'modern sans': 'modern', 'klasik serif': 'serif', 'coding mono': 'mono' };
    const langMap = {
        'indonesia': 'id',
        'english': 'en',
        'jepang': 'ja',
        'ja': 'ja',
        'rusia': 'ru',
        'ru': 'ru'
    };

    function syncSettingsUI() {
        const curTheme = localStorage.getItem('app_theme') || 'mode-gelap';
        const curGraphic = localStorage.getItem('app_graphic') || 'simple';
        const curFont = localStorage.getItem('app_font') || 'modern';
        const curLang = localStorage.getItem('app_lang') || 'id';
        const curAnim = localStorage.getItem('app_anim') || 'on';

        document.documentElement.setAttribute('data-theme', curTheme);
        document.documentElement.setAttribute('data-graphic', curGraphic);
        document.documentElement.setAttribute('data-font', curFont);
        document.documentElement.setAttribute('data-anim', curAnim);

        document.querySelectorAll('main button').forEach(btn => {
            const rawTxt = (btn.textContent || '').trim().toLowerCase();

            for (const [k, slug] of Object.entries(themeMap)) {
                if (rawTxt.includes(k)) {
                    btn.classList.toggle('ring-2', slug === curTheme);
                    btn.classList.toggle('ring-sky-400', slug === curTheme);
                }
            }
            for (const [k, slug] of Object.entries(graphicMap)) {
                if (rawTxt === k) {
                    btn.classList.toggle('theme-primary', slug === curGraphic);
                    btn.classList.toggle('theme-soft', slug !== curGraphic);
                }
            }
            for (const [k, slug] of Object.entries(fontMap)) {
                if (rawTxt.includes(k)) {
                    btn.classList.toggle('theme-primary', slug === curFont);
                    btn.classList.toggle('theme-soft', slug !== curFont);
                }
            }
            for (const [k, code] of Object.entries(langMap)) {
                if (rawTxt.includes(k)) {
                    btn.classList.toggle('theme-primary', code === curLang);
                    btn.classList.toggle('theme-soft', code !== curLang);
                }
            }
            if ((rawTxt === 'aktif' || rawTxt === 'nonaktif') && (btn.closest('div')?.textContent || '').toLowerCase().includes('animasi')) {
                btn.textContent = curAnim === 'on' ? 'Aktif' : 'Nonaktif';
                btn.classList.toggle('theme-primary', curAnim === 'on');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('main button').forEach(btn => {
            const rawTxt = (btn.textContent || '').trim().toLowerCase();
            const isAnimBtn = (rawTxt === 'aktif' || rawTxt === 'nonaktif') && (btn.closest('div')?.textContent || '').toLowerCase().includes('animasi');
            const matchedTheme = Object.entries(themeMap).find(([k]) => rawTxt.includes(k));
            const matchedGraphic = Object.entries(graphicMap).find(([k]) => rawTxt === k);
            const matchedFont = Object.entries(fontMap).find(([k]) => rawTxt.includes(k));
            const matchedLang = Object.entries(langMap).find(([k]) => rawTxt.includes(k));

            if (!isAnimBtn && !matchedTheme && !matchedGraphic && !matchedFont && !matchedLang) return;

            btn.removeAttribute('onclick');
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                if (matchedTheme) {
                    localStorage.setItem('app_theme', matchedTheme[1]);
                } else if (matchedGraphic) {
                    localStorage.setItem('app_graphic', matchedGraphic[1]);
                } else if (matchedFont) {
                    localStorage.setItem('app_font', matchedFont[1]);
                } else if (matchedLang) {
                    localStorage.setItem('app_lang', matchedLang[1]);
                    if (typeof window.applyLanguage === 'function') {
                        window.applyLanguage(matchedLang[1]);
                    }
                } else if (isAnimBtn) {
                    const nextAnim = (localStorage.getItem('app_anim') || 'on') === 'on' ? 'off' : 'on';
                    localStorage.setItem('app_anim', nextAnim);
                }

                syncSettingsUI();
            }, true);
        });

        syncSettingsUI();
    });
})();
</script>
<!-- SETTINGS-PERFECTION-END -->
</x-app-layout>
