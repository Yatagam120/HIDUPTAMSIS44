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

    <div class="max-w-5xl mx-auto space-y-5">
        <!-- Header Pengaturan -->
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">⚙️ Pengaturan Tampilan</h1>
                <p class="text-xs opacity-75 mt-1">Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.</p>
            </div>
            <a href="{{ route('dashboard') }}" onclick="playSfx('click')"
               class="px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 rounded-xl bg-red-500/20 border border-red-500/40 text-red-400 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- 1. Tema Gelap & Tema Terang -->
        <div class="theme-card border theme-border rounded-2xl p-5 space-y-4 shadow-lg">
            <div class="space-y-2">
                <div class="text-xs font-extrabold tracking-wider opacity-75">TEMA GELAP (GRADIEN)</div>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                    @foreach($darkThemes as $t)
                        <button type="button"
                                data-theme-btn="{{ $t['id'] }}"
                                onclick="selectAppTheme('{{ $t['id'] }}')"
                                class="setting-pill p-2.5 rounded-xl border theme-border text-left flex items-center gap-2.5 hover:opacity-90">
                            <span class="w-5 h-5 rounded-full shrink-0 border border-white/30" style="background: {{ $t['swatch'] }};"></span>
                            <span class="text-xs font-extrabold leading-tight">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t theme-border">
                <div class="text-xs font-extrabold tracking-wider opacity-75">TEMA TERANG (GRADIEN)</div>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                    @foreach($lightThemes as $t)
                        <button type="button"
                                data-theme-btn="{{ $t['id'] }}"
                                onclick="selectAppTheme('{{ $t['id'] }}')"
                                class="setting-pill p-2.5 rounded-xl border theme-border text-left flex items-center gap-2.5 hover:opacity-90">
                            <span class="w-5 h-5 rounded-full shrink-0 border border-black/20" style="background: {{ $t['swatch'] }};"></span>
                            <span class="text-xs font-extrabold leading-tight">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2. Gaya Grafik, Animasi & Gaya Huruf -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
                <div class="text-xs font-extrabold tracking-wider opacity-75">GRAFIK & ANIMASI</div>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" data-graphic-btn="legacy" onclick="selectAppGraphic('legacy')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold">Legacy</button>
                    <button type="button" data-graphic-btn="minimalist" onclick="selectAppGraphic('minimalist')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold">Minimalist</button>
                    <button type="button" data-graphic-btn="simple" onclick="selectAppGraphic('simple')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold">Simple</button>
                </div>

                <div class="flex items-center justify-between pt-2 border-t theme-border">
                    <span class="text-xs font-bold">Animasi Transisi UI</span>
                    <button type="button" id="toggle-anim-btn" onclick="toggleAppAnim()"
                            class="px-3 py-1.5 rounded-xl border theme-border text-xs font-extrabold">
                        Mati
                    </button>
                </div>
            </div>

            <div class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
                <div class="text-xs font-extrabold tracking-wider opacity-75">GAYA HURUF</div>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" data-font-btn="sans" onclick="selectAppFont('sans')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold">Modern Sans</button>
                    <button type="button" data-font-btn="serif" onclick="selectAppFont('serif')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold font-serif">Klasik Serif</button>
                    <button type="button" data-font-btn="mono" onclick="selectAppFont('mono')"
                            class="setting-pill px-3 py-2 rounded-xl border theme-border text-xs font-extrabold font-mono">Coding Mono</button>
                </div>

                <div class="flex items-center justify-between pt-2 border-t theme-border">
                    <span class="text-xs font-bold">EFEK SUARA (SFX)</span>
                    <button type="button" id="toggle-sfx-btn" onclick="toggleAppSfx()"
                            class="px-3 py-1.5 rounded-xl border theme-border text-xs font-extrabold">
                        🔊 Aktif
                    </button>
                </div>
            </div>
        </div>

        <!-- 3. Bahasa (4 Bahasa Auto-Translate: Indonesia, English, Jepang, Rusia) -->
        <div class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
            <div class="text-xs font-extrabold tracking-wider opacity-75">BAHASA</div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <button type="button" data-lang-btn="id" onclick="selectAppLanguage('id')"
                        class="setting-pill px-3 py-2.5 rounded-xl border theme-border text-xs font-extrabold">
                    🇮🇩 Indonesia
                </button>
                <button type="button" data-lang-btn="en" onclick="selectAppLanguage('en')"
                        class="setting-pill px-3 py-2.5 rounded-xl border theme-border text-xs font-extrabold">
                    🇬🇧 English
                </button>
                <button type="button" data-lang-btn="ja" onclick="selectAppLanguage('ja')"
                        class="setting-pill px-3 py-2.5 rounded-xl border theme-border text-xs font-extrabold">
                    🇯🇵 日本語 (Jepang)
                </button>
                <button type="button" data-lang-btn="ru" onclick="selectAppLanguage('ru')"
                        class="setting-pill px-3 py-2.5 rounded-xl border theme-border text-xs font-extrabold">
                    🇷🇺 Русский (Rusia)
                </button>
            </div>
        </div>

        <!-- 4. Pemutar Musik Kelas & Request Lagu (#20) -->
        <div class="theme-card border theme-border rounded-2xl p-5 space-y-4 shadow-lg">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-extrabold">🎵 Pemutar Musik Kelas</h2>
                    <p class="text-xs opacity-75">Dengarkan musik santai saat belajar. Pengaturan playlist dikelola oleh Admin.</p>
                </div>
                @if($isAdminRole && \Illuminate\Support\Facades\Route::has('admin.users'))
                    <a href="{{ route('admin.users') }}" class="px-3 py-1.5 rounded-xl theme-soft border theme-border text-xs font-extrabold">
                        🛡️ Review Request Lagu di AP
                    </a>
                @endif
            </div>

            <!-- Daftar Lagu Aktif -->
            <div class="space-y-2.5">
                @forelse($approvedMusics as $song)
                    <div class="p-3 rounded-xl theme-soft border theme-border flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <div class="text-xs font-extrabold">{{ $song->title }}</div>
                            <div class="text-[11px] opacity-70">{{ $song->artist ?: 'Playlist XI RPL 1' }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($song->file_path)
                                <audio controls preload="none" class="h-8 max-w-[230px]">
                                    <source src="{{ asset($song->file_path) }}">
                                </audio>
                            @endif
                            @if($isAdminRole)
                                <form action="{{ route('music.destroy', $song->id) }}" method="POST" onsubmit="return confirm('Hapus lagu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 rounded-lg bg-red-500/20 text-red-400 text-[11px] font-extrabold">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-xs opacity-70 py-1">Belum ada lagu di playlist. Ajukan request lagu di bawah!</div>
                @endforelse
            </div>

            <!-- Form Upload Langsung (Khusus Admin) / Request Lagu (Untuk Murid) -->
            @if(\Illuminate\Support\Facades\Route::has('music.admin.store') && \Illuminate\Support\Facades\Route::has('music.request'))
                <form action="{{ $isAdminRole ? route('music.admin.store') : route('music.request') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="pt-3 border-t theme-border space-y-2.5">
                    @csrf
                    <div class="text-xs font-extrabold">
                        {{ $isAdminRole ? '➕ Tambah Lagu Langsung (Admin)' : '📩 Request Lagu ke Admin Panel (AP)' }}
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <input type="text" name="title" required placeholder="Judul Lagu..." class="rounded-xl border theme-border px-3 py-2 text-xs">
                        <input type="text" name="artist" placeholder="Penyanyi / Artis..." class="rounded-xl border theme-border px-3 py-2 text-xs">
                        <label class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold cursor-pointer hover:opacity-90">
                            <span class="text-sm font-black">+</span>
                            <span id="music-file-label">Pilih File Audio</span>
                            <input type="file" name="audio" {{ $isAdminRole ? 'required' : '' }} accept="audio/mp3,audio/wav,audio/ogg,audio/m4a" class="hidden" onchange="document.getElementById('music-file-label').textContent = this.files[0]?.name || 'Pilih File Audio'">
                        </label>
                    </div>
                    <button type="submit" class="theme-primary px-4 py-2 rounded-xl text-xs font-extrabold shadow">
                        {{ $isAdminRole ? 'Upload & Tayangkan Lagu' : 'Kirim Request Lagu' }}
                    </button>
                </form>
            @endif
        </div>

        <!-- 5. Kasih Saran & Laporan Bug + Easter Egg -->
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow">
            <button type="button"
                    onclick="document.getElementById('feedback-modal').classList.remove('hidden'); document.getElementById('feedback-modal').classList.add('flex'); playSfx('click');"
                    class="theme-primary px-4 py-2.5 rounded-xl text-xs font-extrabold shadow">
                💌 Kasih Saran & Laporan Bug
            </button>

            <button type="button" onclick="triggerEasterEgg()" class="text-[11px] opacity-60 hover:opacity-100 font-mono">
                XI RPL 1 • Tamsis Build v2.6
            </button>
        </div>
    </div>

    <!-- Modal Kasih Saran & Laporan Bug -->
    <div id="feedback-modal" class="fixed inset-0 z-[99990] hidden items-center justify-center bg-black/75 p-4">
        <div class="theme-card border theme-border rounded-2xl max-w-md w-full p-5 space-y-3 shadow-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-extrabold">💌 Kasih Saran & Laporan Bug</h3>
                <button type="button" onclick="document.getElementById('feedback-modal').classList.add('hidden')" class="px-2 py-1 rounded border theme-border text-xs font-bold">✕</button>
            </div>
            @if(\Illuminate\Support\Facades\Route::has('feedback.store'))
                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <select name="category" class="w-full rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                        <option value="Saran Fitur">💡 Saran Fitur</option>
                        <option value="Laporan Bug">🐞 Laporan Bug</option>
                    </select>
                    <textarea name="message" rows="4" required placeholder="Tuliskan saran atau detail bug yang kamu temukan..."
                              class="w-full rounded-xl border theme-border px-3 py-2 text-xs"></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('feedback-modal').classList.add('hidden')" class="px-3 py-1.5 rounded-xl border theme-border text-xs font-bold">Batal</button>
                        <button type="submit" class="theme-primary px-4 py-1.5 rounded-xl text-xs font-extrabold">Kirim</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        let eggTapCount = 0;
        function triggerEasterEgg() {
            eggTapCount++;
            playSfx(eggTapCount >= 5 ? 'secret' : 'click');
            if (eggTapCount >= 5) {
                eggTapCount = 0;
                alert('🎉 Easter Egg XI RPL 1 Aktif! Pelajar Taman Siswa Hebat: Niat, Jujur, Unggul, Nasionalis!');
            }
        }

        function refreshSettingsButtonsState() {
            const curTheme   = localStorage.getItem('app_theme') || 'mode-gelap';
            const curFont    = localStorage.getItem('app_font') || 'sans';
            const curGraphic = localStorage.getItem('app_graphic') || 'simple';
            const curLang    = localStorage.getItem('app_lang') || 'id';
            const isSimple   = curGraphic === 'simple';
            const curAnim    = isSimple ? 'off' : (localStorage.getItem('app_anim') || 'off');
            const curSfx     = localStorage.getItem('app_sfx') || 'active';

            document.querySelectorAll('[data-theme-btn]').forEach(btn => {
                btn.classList.toggle('theme-primary', btn.dataset.themeBtn === curTheme);
            });
            document.querySelectorAll('[data-graphic-btn]').forEach(btn => {
                btn.classList.toggle('theme-primary', btn.dataset.graphicBtn === curGraphic);
            });
            document.querySelectorAll('[data-font-btn]').forEach(btn => {
                btn.classList.toggle('theme-primary', btn.dataset.fontBtn === curFont);
            });
            document.querySelectorAll('[data-lang-btn]').forEach(btn => {
                btn.classList.toggle('theme-primary', btn.dataset.langBtn === curLang);
            });

            const animBtn = document.getElementById('toggle-anim-btn');
            if (animBtn) {
                animBtn.disabled = isSimple;
                if (isSimple) {
                    animBtn.textContent = 'Nonaktif (Simple)';
                    animBtn.className = 'px-3 py-1.5 rounded-xl border border-zinc-600/40 bg-zinc-700/40 text-zinc-400 text-xs font-extrabold cursor-not-allowed opacity-60';
                } else {
                    animBtn.textContent = curAnim === 'on' ? '✨ Aktif' : 'Mati';
                    animBtn.className = 'px-3 py-1.5 rounded-xl border theme-border text-xs font-extrabold ' + (curAnim === 'on' ? 'theme-primary' : 'theme-soft');
                }
            }

            const sfxBtn = document.getElementById('toggle-sfx-btn');
            if (sfxBtn) sfxBtn.textContent = curSfx === 'muted' ? '🔇 Nonaktif' : '🔊 Aktif';
        }

        function selectAppTheme(themeId) {
            localStorage.setItem('app_theme', themeId);
            if (typeof applySavedAppearance === 'function') applySavedAppearance();
            refreshSettingsButtonsState();
            playSfx('click');
        }

        function selectAppGraphic(graphicId) {
            localStorage.setItem('app_graphic', graphicId);
            if (graphicId === 'simple') localStorage.setItem('app_anim', 'off');
            if (typeof applySavedAppearance === 'function') applySavedAppearance();
            refreshSettingsButtonsState();
            playSfx('click');
        }

        function toggleAppAnim() {
            if ((localStorage.getItem('app_graphic') || 'simple') === 'simple') {
                return; // Terkunci abu-abu saat mode Simple
            }
            const cur = localStorage.getItem('app_anim') || 'off';
            const next = cur === 'on' ? 'off' : 'on';
            localStorage.setItem('app_anim', next);
            if (typeof applySavedAppearance === 'function') applySavedAppearance();
            refreshSettingsButtonsState();
            playSfx('click');
        }

        function selectAppFont(fontId) {
            localStorage.setItem('app_font', fontId);
            if (typeof applySavedAppearance === 'function') applySavedAppearance();
            refreshSettingsButtonsState();
            playSfx('click');
        }

        function toggleAppSfx() {
            const cur = localStorage.getItem('app_sfx') || 'active';
            const next = cur === 'muted' ? 'active' : 'muted';
            localStorage.setItem('app_sfx', next);
            refreshSettingsButtonsState();
            if (next === 'active') playSfx('enter');
        }

        function selectAppLanguage(langCode) {
            localStorage.setItem('app_lang', langCode);
            if (typeof applyLanguage === 'function') {
                applyLanguage(langCode);
            }
            refreshSettingsButtonsState();
            playSfx('enter');
        }

        document.addEventListener('DOMContentLoaded', refreshSettingsButtonsState);
    </script>
    
<script id="settings-interactive-binding">
document.addEventListener('DOMContentLoaded', function () {
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
    const langMap = { 'indonesia': 'id', 'english': 'en', '日本語': 'ja', 'jepang': 'ja', 'русский': 'ru', 'rusia': 'ru' };

    function refreshSettingsHighlight() {
        const curTheme = localStorage.getItem('app_theme') || 'mode-gelap';
        const curGraphic = localStorage.getItem('app_graphic') || 'simple';
        const curFont = localStorage.getItem('app_font') || 'modern';
        const curLang = localStorage.getItem('app_lang') || 'id';
        const curAnim = localStorage.getItem('app_anim') || 'on';

        document.querySelectorAll('main button').forEach(btn => {
            const t = (btn.textContent || '').trim().toLowerCase();

            for (const [k, slug] of Object.entries(themeMap)) {
                if (t.includes(k)) {
                    btn.classList.toggle('theme-primary', slug === curTheme);
                    btn.classList.toggle('ring-2', slug === curTheme);
                }
            }
            for (const [k, slug] of Object.entries(graphicMap)) {
                if (t === k) {
                    btn.classList.toggle('theme-primary', slug === curGraphic);
                    btn.classList.toggle('theme-soft', slug !== curGraphic);
                }
            }
            for (const [k, slug] of Object.entries(fontMap)) {
                if (t.includes(k)) {
                    btn.classList.toggle('theme-primary', slug === curFont);
                    btn.classList.toggle('theme-soft', slug !== curFont);
                }
            }
            for (const [k, code] of Object.entries(langMap)) {
                if (t.includes(k)) {
                    btn.classList.toggle('theme-primary', code === curLang);
                    btn.classList.toggle('theme-soft', code !== curLang);
                }
            }
            if (t === 'aktif' || t === 'nonaktif') {
                const animRow = btn.closest('div')?.textContent?.toLowerCase() || '';
                if (animRow.includes('animasi')) {
                    btn.textContent = curAnim === 'on' ? 'Aktif' : 'Nonaktif';
                    btn.classList.toggle('theme-primary', curAnim === 'on');
                }
            }
        });
    }

    document.querySelectorAll('main button').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const t = (this.textContent || '').trim().toLowerCase();

            for (const [k, slug] of Object.entries(themeMap)) {
                if (t.includes(k)) {
                    e.preventDefault();
                    window.setAppTheme(slug);
                    refreshSettingsHighlight();
                    return;
                }
            }
            for (const [k, slug] of Object.entries(graphicMap)) {
                if (t === k) {
                    e.preventDefault();
                    window.setAppGraphic(slug);
                    refreshSettingsHighlight();
                    return;
                }
            }
            for (const [k, slug] of Object.entries(fontMap)) {
                if (t.includes(k)) {
                    e.preventDefault();
                    window.setAppFont(slug);
                    refreshSettingsHighlight();
                    return;
                }
            }
            for (const [k, code] of Object.entries(langMap)) {
                if (t.includes(k)) {
                    e.preventDefault();
                    localStorage.setItem('app_lang', code);
                    window.applyLanguage(code);
                    refreshSettingsHighlight();
                    return;
                }
            }
            if (t === 'aktif' || t === 'nonaktif') {
                const animRow = this.closest('div')?.textContent?.toLowerCase() || '';
                if (animRow.includes('animasi')) {
                    e.preventDefault();
                    window.toggleAppAnim();
                    refreshSettingsHighlight();
                }
            }
        });
    });

    refreshSettingsHighlight();
});
</script>
</x-app-layout>