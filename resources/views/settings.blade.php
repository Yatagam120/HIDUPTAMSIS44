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
            .grid-5-cols, .grid-4-cols { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.5rem; }
            .grid-3-cols { grid-template-columns: 1fr; gap: 0.5rem; }
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

    <div class="max-w-5xl mx-auto space-y-5">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs sm:text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-300 border border-red-500/40 text-xs sm:text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-8 border theme-border space-y-5">
            <div>
                <h1 class="text-lg sm:text-2xl font-extrabold" data-i18n="settings_title">Pengaturan Tampilan</h1>
                <p class="text-xs sm:text-sm opacity-75 mt-0.5" data-i18n="settings_sub">Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.</p>
            </div>

            <!-- Tema Gelap (Gradien) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2" data-i18n="dark_theme_label">Tema Gelap (Gradien)</h2>
                <div class="grid-5-cols">
                    @foreach([
                        ['id' => 'academic-trust', 'name' => 'Academic Trust', 'dot' => '#2563eb'],
                        ['id' => 'deep-ocean', 'name' => 'Deep Ocean', 'dot' => '#0891b2'],
                        ['id' => 'midnight-scholar', 'name' => 'Midnight Scholar', 'dot' => '#7c3aed'],
                        ['id' => 'forest-academy', 'name' => 'Forest Academy', 'dot' => '#059669'],
                        ['id' => 'mode-gelap', 'name' => 'Mode Gelap', 'dot' => '#18181b'],
                    ] as $t)
                        <button type="button" onclick="selectTheme('{{ $t['id'] }}')" data-theme-btn="{{ $t['id'] }}"
                                class="setting-pill rounded-full px-3 py-2 flex items-center gap-2 text-[11px] sm:text-xs font-bold text-left">
                            <span class="w-3.5 h-3.5 rounded-full shrink-0 border border-white/40" style="background: {{ $t['dot'] }};"></span>
                            <span class="truncate">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Tema Terang (Gradien) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2" data-i18n="light_theme_label">Tema Terang (Gradien)</h2>
                <div class="grid-5-cols">
                    @foreach([
                        ['id' => 'teal-growth', 'name' => 'Teal Growth', 'dot' => '#2dd4bf'],
                        ['id' => 'creative-spark', 'name' => 'Creative Spark', 'dot' => '#d946ef'],
                        ['id' => 'lavender-dream', 'name' => 'Lavender Dream', 'dot' => '#818cf8'],
                        ['id' => 'soft-berry', 'name' => 'Soft Berry', 'dot' => '#fb7185'],
                        ['id' => 'morning-assembly', 'name' => 'Morning Assembly', 'dot' => '#fde047'],
                    ] as $t)
                        <button type="button" onclick="selectTheme('{{ $t['id'] }}')" data-theme-btn="{{ $t['id'] }}"
                                class="setting-pill rounded-full px-3 py-2 flex items-center gap-2 text-[11px] sm:text-xs font-bold text-left">
                            <span class="w-3.5 h-3.5 rounded-full shrink-0 border border-black/20" style="background: {{ $t['dot'] }};"></span>
                            <span class="truncate">{{ $t['name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Section Grafik (3 Style UI: Legacy, Minimalist, Style Simple + Toggle Animasi) -->
            <div class="space-y-3 pt-2 border-t border-gray-200/20">
                <div>
                    <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85" data-i18n="graphic_label">📊 Grafik</h2>
                    <p class="text-[11px] opacity-75 mt-0.5" data-i18n="graphic_sub">Style untuk header, button, dan panel web: Legacy (UI sekarang), Minimalist (tegas, simple & relaks), atau Style Simple (otomatis matikan animasi).</p>
                </div>

                <div class="grid-3-cols">
                    <button type="button" onclick="selectGraphicStyle('legacy')" data-graphic-btn="legacy"
                            class="setting-pill rounded-2xl px-4 py-2.5 text-xs font-extrabold text-left">
                        <div>🏛️ Legacy</div>
                        <div class="text-[10px] font-normal opacity-75" data-i18n="graphic_legacy_sub">UI style sekarang</div>
                    </button>

                    <button type="button" onclick="selectGraphicStyle('minimalist')" data-graphic-btn="minimalist"
                            class="setting-pill rounded-2xl px-4 py-2.5 text-xs font-extrabold text-left">
                        <div>💼 Minimalist</div>
                        <div class="text-[10px] font-normal opacity-75" data-i18n="graphic_min_sub">Simple, tegas & relaks</div>
                    </button>

                    <button type="button" onclick="selectGraphicStyle('simple')" data-graphic-btn="simple"
                            class="setting-pill rounded-2xl px-4 py-2.5 text-xs font-extrabold text-left">
                        <div>⚡ Style Simple</div>
                        <div class="text-[10px] font-normal opacity-75" data-i18n="graphic_simple_sub">Otomatis matikan animasi UI</div>
                    </button>
                </div>

                <div id="graphic-anim-control" class="p-3.5 rounded-2xl border theme-border theme-soft flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <div class="text-xs font-extrabold" data-i18n="anim_toggle_title">🎬 Toggle Animasi UI</div>
                        <div id="graphic-anim-desc" class="text-[11px] opacity-75">Aktifkan atau matikan animasi UI pada mode Legacy & Minimalist.</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="selectAnim('on')" data-anim-btn="on"
                                class="setting-pill rounded-full px-3.5 py-1.5 text-xs font-extrabold" data-i18n="anim_on">
                            ✨ Aktif
                        </button>
                        <button type="button" onclick="selectAnim('off')" data-anim-btn="off"
                                class="setting-pill rounded-full px-3.5 py-1.5 text-xs font-extrabold" data-i18n="anim_off">
                            🔇 Mati
                        </button>
                    </div>
                </div>
            </div>

            <!-- Gaya Huruf -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2" data-i18n="font_style_label">Gaya Huruf</h2>
                <div class="grid-3-cols">
                    <button type="button" onclick="selectFont('sans')" data-font-btn="sans"
                            class="setting-pill rounded-full px-4 py-2 text-xs font-bold text-center" style="font-family: 'Figtree', sans-serif;">
                        Modern (Sans)
                    </button>
                    <button type="button" onclick="selectFont('serif')" data-font-btn="serif"
                            class="setting-pill rounded-full px-4 py-2 text-xs font-bold text-center" style="font-family: Georgia, serif;">
                        Klasik (Serif)
                    </button>
                    <button type="button" onclick="selectFont('mono')" data-font-btn="mono"
                            class="setting-pill rounded-full px-4 py-2 text-xs font-bold text-center" style="font-family: monospace;">
                        Koding (Mono)
                    </button>
                </div>
            </div>

            <!-- Bahasa -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2" data-i18n="lang_label">Bahasa</h2>
                <div class="grid-4-cols">
                    <button type="button" onclick="selectLang('id')" data-lang-btn="id"
                            class="setting-pill w-full rounded-full px-3 py-2 text-[11px] sm:text-xs font-bold text-center">
                        🇮🇩 Indonesia
                    </button>
                    <button type="button" onclick="selectLang('en')" data-lang-btn="en"
                            class="setting-pill w-full rounded-full px-3 py-2 text-[11px] sm:text-xs font-bold text-center">
                        🇬🇧 English
                    </button>
                    <button type="button" onclick="selectLang('ja')" data-lang-btn="ja"
                            class="setting-pill w-full rounded-full px-3 py-2 text-[11px] sm:text-xs font-bold text-center">
                        🇯🇵 日本語 (Jepang)
                    </button>
                    <button type="button" onclick="selectLang('ru')" data-lang-btn="ru"
                            class="setting-pill w-full rounded-full px-3 py-2 text-[11px] sm:text-xs font-bold text-center">
                        🇷🇺 Русский (Rusia)
                    </button>
                </div>
            </div>

            <!-- Efek Suara (SFX) -->
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider opacity-85 mb-2" data-i18n="sfx_label">Efek Suara (SFX)</h2>
                <div class="grid grid-cols-2 gap-2.5">
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

                <div class="flex gap-2">
                    <input type="text" id="easter-code-input" placeholder="MASUKKAN KODE UNIK..."
                           class="flex-1 min-w-0 rounded-xl border px-3 py-2 text-xs sm:text-sm uppercase tracking-wider font-bold">
                    <button type="button" onclick="claimEasterEgg()"
                            class="px-4 sm:px-5 py-2 rounded-xl text-xs sm:text-sm font-extrabold theme-primary shadow-md hover:opacity-90 transition shrink-0"
                            data-i18n="klaim_btn">
                        Klaim
                    </button>
                </div>
                <p id="easter-feedback" class="hidden mt-2 text-xs font-bold"></p>
            </div>
        </div>

        <!-- Kasih Saran & Laporan Bug -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold" data-i18n="saran_btn">Kasih Saran & Laporan Bug</h2>
                    <p class="text-xs opacity-75 mt-0.5" data-i18n="saran_sub">Beri rating bintang (bisa desimal seperti 4.5 / 3.4), komentar, atau kirim banyak foto/video jika menemukan bug.</p>
                </div>

                <button type="button" onclick="playSfx('click'); document.getElementById('feedback-panel').classList.toggle('hidden')"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold theme-primary shadow-md hover:opacity-90 transition flex items-center gap-1.5">
                    <span>⭐</span>
                    <span data-i18n="saran_btn">Kasih Saran & Laporan Bug</span>
                </button>
            </div>

            <div id="feedback-panel" class="{{ $errors->any() ? '' : 'hidden' }} mt-5 pt-5 border-t border-gray-200/25">
                <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold mb-1.5" data-i18n="rating_label">Rating Web (0.0 – 5.0 Bintang)</label>
                        <div class="flex flex-wrap items-center gap-3">
                            <input type="range" id="rating-slider" min="0" max="5" step="0.1" value="5.0"
                                   oninput="syncStarRating(this.value)"
                                   class="w-40 sm:w-48 accent-amber-400 cursor-pointer">

                            <div class="flex items-center gap-2">
                                <input type="number" id="rating-number" name="rating" min="0" max="5" step="0.1" value="5.0" required
                                       oninput="syncStarRating(this.value)"
                                       class="w-20 rounded-xl border p-2 text-sm font-extrabold text-center">
                                <span id="star-visual" class="text-amber-400 text-sm sm:text-base font-bold tracking-wider">★★★★★ (5.0)</span>
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
                        <label class="block text-xs font-bold mb-1" data-i18n="lampiran_bug_label">Lampiran Foto / Video Bug (Bisa Lebih Dari 1 File)</label>
                        <div class="flex flex-wrap items-center gap-2">
                            <input type="file" id="feedback-media-input" name="media[]" multiple accept="image/*,video/*" class="hidden">
                            <button type="button" onclick="document.getElementById('feedback-media-input').click()"
                                    class="px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold hover:opacity-90 transition">
                                📎 + Tambah Foto / Video
                            </button>
                            <span id="feedback-file-count" class="text-xs opacity-75">Belum ada file dipilih</span>
                        </div>
                        <div id="feedback-file-list" class="mt-2.5 flex flex-wrap gap-2"></div>
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
        const feedbackDataTransfer = new DataTransfer();
        const fbMediaInput = document.getElementById('feedback-media-input');

        function renderFeedbackFiles() {
            const listEl = document.getElementById('feedback-file-list');
            const countEl = document.getElementById('feedback-file-count');
            if (!listEl || !countEl) return;

            listEl.innerHTML = '';
            const files = Array.from(feedbackDataTransfer.files);
            countEl.textContent = files.length > 0 ? `${files.length} file dipilih` : 'Belum ada file dipilih';

            files.forEach((file, idx) => {
                const chip = document.createElement('div');
                chip.className = 'inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border theme-border theme-soft text-[11px] font-bold max-w-full';
                const icon = file.type.startsWith('video/') ? '🎬' : '🖼️';
                chip.innerHTML = `
                    <span>${icon}</span>
                    <span class="truncate max-w-[160px]">${file.name}</span>
                    <button type="button" onclick="removeFeedbackFile(${idx})" class="text-red-400 hover:text-red-300 font-extrabold ml-1">✕</button>
                `;
                listEl.appendChild(chip);
            });
        }

        function removeFeedbackFile(index) {
            const nextDt = new DataTransfer();
            Array.from(feedbackDataTransfer.files).forEach((f, i) => {
                if (i !== index) nextDt.items.add(f);
            });
            feedbackDataTransfer.items.clear();
            Array.from(nextDt.files).forEach(f => feedbackDataTransfer.items.add(f));
            fbMediaInput.dataset.skipEditorOnce = '1';
            fbMediaInput.files = feedbackDataTransfer.files;
            renderFeedbackFiles();
        }

        if (fbMediaInput) {
            fbMediaInput.addEventListener('change', () => {
                Array.from(fbMediaInput.files || []).forEach(f => {
                    feedbackDataTransfer.items.add(f);
                });
                fbMediaInput.dataset.skipEditorOnce = '1';
                fbMediaInput.files = feedbackDataTransfer.files;
                renderFeedbackFiles();
            });
        }

        function syncGraphicControlUI() {
            const curGraphic = localStorage.getItem('app_graphic') || 'legacy';
            const curAnim    = curGraphic === 'simple' ? 'off' : (localStorage.getItem('app_anim') || 'on');

            document.querySelectorAll('[data-graphic-btn]').forEach(b => {
                b.classList.toggle('active-pill', b.dataset.graphicBtn === curGraphic);
            });
            document.querySelectorAll('[data-anim-btn]').forEach(b => {
                b.classList.toggle('active-pill', b.dataset.animBtn === curAnim);
            });

            const descEl = document.getElementById('graphic-anim-desc');
            if (descEl) {
                if (curGraphic === 'simple') {
                    descEl.textContent = 'Style Simple aktif: Animasi UI otomatis dimatikan.';
                } else if (curGraphic === 'minimalist') {
                    descEl.textContent = 'Mode Minimalist (Simple, tegas & relaks): Anda bisa mengaktifkan atau mematikan animasi UI.';
                } else {
                    descEl.textContent = 'Mode Legacy: Anda bisa mengaktifkan atau mematikan animasi UI.';
                }
            }
        }

        function refreshActivePills() {
            const curTheme = localStorage.getItem('app_theme') || 'academic-trust';
            const curFont  = localStorage.getItem('app_font') || 'sans';
            const curLang  = localStorage.getItem('app_lang') || 'id';
            const curSfx   = localStorage.getItem('app_sfx') || 'active';

            document.querySelectorAll('[data-theme-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.themeBtn === curTheme));
            document.querySelectorAll('[data-font-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.fontBtn === curFont));
            document.querySelectorAll('[data-lang-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.langBtn === curLang));
            document.querySelectorAll('[data-sfx-btn]').forEach(b => b.classList.toggle('active-pill', b.dataset.sfxBtn === curSfx));
            syncGraphicControlUI();
        }

        function selectTheme(theme) {
            localStorage.setItem('app_theme', theme);
            document.body.setAttribute('data-theme', theme);
            playSfx('click');
            refreshActivePills();
        }

        function selectGraphicStyle(style) {
            localStorage.setItem('app_graphic', style);
            document.body.setAttribute('data-graphic', style);

            if (style === 'simple') {
                localStorage.setItem('app_anim', 'off');
                document.body.setAttribute('data-anim', 'off');
            } else {
                const savedAnim = localStorage.getItem('app_anim') || 'on';
                document.body.setAttribute('data-anim', savedAnim);
            }

            playSfx('click');
            refreshActivePills();
        }

        function selectAnim(mode) {
            localStorage.setItem('app_anim', mode);
            document.body.setAttribute('data-anim', mode);
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