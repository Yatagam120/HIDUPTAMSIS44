<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>XI RPL 1 - Tamsis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #0a192f 0%, #102a4c 50%, #071120 100%);
            --bg-card: rgba(15, 32, 60, 0.85);
            --text-main: #f8fafc;
            --primary: #3b82f6;
            --primary-soft: rgba(59, 130, 246, 0.18);
            --border-color: rgba(96, 165, 250, 0.28);
            --font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }

        /* Tema Gelap (Gradien) */
        body[data-theme="academic-trust"] {
            --bg-gradient: linear-gradient(135deg, #0a192f 0%, #102a4c 50%, #071120 100%);
            --bg-card: rgba(15, 32, 60, 0.85);
            --text-main: #f8fafc;
            --primary: #3b82f6;
            --primary-soft: rgba(59, 130, 246, 0.18);
            --border-color: rgba(96, 165, 250, 0.28);
        }
        body[data-theme="deep-ocean"] {
            --bg-gradient: linear-gradient(135deg, #041c32 0%, #064663 55%, #04293a 100%);
            --bg-card: rgba(6, 45, 70, 0.85);
            --text-main: #f0f9ff;
            --primary: #06b6d4;
            --primary-soft: rgba(6, 182, 212, 0.18);
            --border-color: rgba(34, 211, 238, 0.28);
        }
        body[data-theme="midnight-scholar"] {
            --bg-gradient: linear-gradient(135deg, #0f0c29 0%, #1e1b4b 55%, #13112b 100%);
            --bg-card: rgba(30, 27, 75, 0.85);
            --text-main: #f5f3ff;
            --primary: #8b5cf6;
            --primary-soft: rgba(139, 92, 246, 0.18);
            --border-color: rgba(167, 139, 250, 0.28);
        }
        body[data-theme="forest-academy"] {
            --bg-gradient: linear-gradient(135deg, #052e16 0%, #064e3b 55%, #022c22 100%);
            --bg-card: rgba(6, 65, 50, 0.85);
            --text-main: #ecfdf5;
            --primary: #10b981;
            --primary-soft: rgba(16, 185, 129, 0.18);
            --border-color: rgba(52, 211, 153, 0.28);
        }
        body[data-theme="mode-gelap"] {
            --bg-gradient: linear-gradient(135deg, #09090b 0%, #18181b 55%, #09090b 100%);
            --bg-card: rgba(24, 24, 27, 0.9);
            --text-main: #fafafa;
            --primary: #6366f1;
            --primary-soft: rgba(99, 102, 241, 0.18);
            --border-color: rgba(161, 161, 170, 0.25);
        }

        /* Tema Terang (Gradien) */
        body[data-theme="teal-growth"] {
            --bg-gradient: linear-gradient(135deg, #ecfdf5 0%, #ccfbf1 55%, #e0f2fe 100%);
            --bg-card: rgba(255, 255, 255, 0.88);
            --text-main: #0f172a;
            --primary: #0d9488;
            --primary-soft: rgba(13, 148, 136, 0.14);
            --border-color: rgba(13, 148, 136, 0.28);
        }
        body[data-theme="creative-spark"] {
            --bg-gradient: linear-gradient(135deg, #fdf4ff 0%, #fae8ff 55%, #fce7f3 100%);
            --bg-card: rgba(255, 255, 255, 0.9);
            --text-main: #1e1b4b;
            --primary: #c026d3;
            --primary-soft: rgba(192, 38, 211, 0.12);
            --border-color: rgba(192, 38, 211, 0.26);
        }
        body[data-theme="lavender-dream"] {
            --bg-gradient: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 55%, #f3e8ff 100%);
            --bg-card: rgba(255, 255, 255, 0.9);
            --text-main: #1e1b4b;
            --primary: #4f46e5;
            --primary-soft: rgba(79, 70, 229, 0.12);
            --border-color: rgba(79, 70, 229, 0.25);
        }
        body[data-theme="soft-berry"] {
            --bg-gradient: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 55%, #fce7f3 100%);
            --bg-card: rgba(255, 255, 255, 0.9);
            --text-main: #1f2937;
            --primary: #e11d48;
            --primary-soft: rgba(225, 29, 72, 0.12);
            --border-color: rgba(225, 29, 72, 0.25);
        }
        body[data-theme="morning-assembly"] {
            --bg-gradient: linear-gradient(135deg, #fefce8 0%, #fef3c7 55%, #ffedd5 100%);
            --bg-card: rgba(255, 255, 255, 0.92);
            --text-main: #1c1917;
            --primary: #d97706;
            --primary-soft: rgba(217, 119, 6, 0.14);
            --border-color: rgba(217, 119, 6, 0.28);
        }

        /* Gaya Huruf */
        body[data-font="sans"] { --font-family: 'Figtree', system-ui, -apple-system, sans-serif; }
        body[data-font="serif"] { --font-family: Georgia, 'Times New Roman', serif; }
        body[data-font="mono"] { --font-family: 'Fira Code', 'Consolas', monospace; }

        body {
            background: var(--bg-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            font-family: var(--font-family);
            min-height: 100vh;
            margin: 0;
            transition: background 0.35s ease, color 0.25s ease;
        }

        .theme-card {
            background-color: var(--bg-card);
            color: var(--text-main);
            backdrop-filter: blur(12px);
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s ease, background-color 0.3s ease;
        }

        .theme-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .theme-soft {
            background-color: var(--primary-soft);
        }

        .theme-border {
            border-color: var(--border-color);
        }

        /* Gaya Grafik: Minimalist (Style Kantoran) */
        body[data-graphic="minimalist"] .theme-card {
            backdrop-filter: none !important;
            border-radius: 10px !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.14) !important;
            border-width: 1px !important;
        }
        body[data-graphic="minimalist"] nav.main-tamsis-nav {
            backdrop-filter: none !important;
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.18) !important;
        }
        body[data-graphic="minimalist"] .nav-btn-anim,
        body[data-graphic="minimalist"] button,
        body[data-graphic="minimalist"] a.rounded-xl,
        body[data-graphic="minimalist"] a.rounded-lg {
            border-radius: 8px !important;
        }

        /* Gaya Grafik: Simple (Otomatis Matikan Animasi UI) */
        body[data-graphic="simple"],
        body[data-graphic="simple"] *,
        body[data-graphic="simple"] *::before,
        body[data-graphic="simple"] *::after {
            animation: none !important;
            transition: none !important;
        }
        body[data-graphic="simple"] .theme-card,
        body[data-graphic="simple"] nav.main-tamsis-nav {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            box-shadow: none !important;
        }
        body[data-graphic="simple"] #tamsis-splash {
            display: none !important;
        }

        /* Mode Hemat Performa (Saat Toggle Animasi Dimatikan di Legacy / Minimalist) */
        body[data-anim="off"] *,
        body[data-anim="off"] *::before,
        body[data-anim="off"] *::after {
            animation: none !important;
            transition: none !important;
            scroll-behavior: auto !important;
        }
        body[data-anim="off"] .theme-card,
        body[data-anim="off"] nav.main-tamsis-nav {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }
        body[data-anim="off"] #tamsis-splash {
            display: none !important;
        }

        @keyframes pageFadeSlide {
            0% { opacity: 0; transform: translateY(10px) scale(0.99); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .page-animate-in {
            animation: pageFadeSlide 0.32s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        table a, .subject-box, .theme-card a[href*="/mapel/"] {
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.22s ease, border-color 0.22s ease, background-color 0.22s ease !important;
        }
        table a:hover, .subject-box:hover, .theme-card a[href*="/mapel/"]:hover {
            transform: translateY(-3px) scale(1.025) !important;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.32) !important;
            border-color: var(--primary) !important;
        }
        table a:active, .subject-box:active {
            transform: scale(0.97) !important;
        }

        .nav-btn-anim {
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .nav-btn-anim:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.28);
        }
        .nav-btn-anim:active {
            transform: scale(0.95);
        }

        .nav-links-wrap {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            overflow: visible !important;
        }

        #tamsis-splash {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: radial-gradient(circle at center, #0284c7 0%, #0b2447 75%, #061326 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            transition: opacity 0.22s ease, visibility 0.22s ease;
        }
        #tamsis-splash.splash-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        @keyframes splashFastBar {
            0% { width: 20%; }
            100% { width: 100%; }
        }
        .splash-progress-fill {
            height: 100%;
            background: #ffffff;
            border-radius: 9999px;
            animation: splashFastBar 0.2s ease-out forwards;
        }

        input, select, textarea {
            background-color: rgba(15, 23, 42, 0.35);
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body[data-theme="teal-growth"] input,
        body[data-theme="creative-spark"] input,
        body[data-theme="lavender-dream"] input,
        body[data-theme="soft-berry"] input,
        body[data-theme="morning-assembly"] input,
        body[data-theme="teal-growth"] select,
        body[data-theme="creative-spark"] select,
        body[data-theme="lavender-dream"] select,
        body[data-theme="soft-berry"] select,
        body[data-theme="morning-assembly"] select,
        body[data-theme="teal-growth"] textarea,
        body[data-theme="creative-spark"] textarea,
        body[data-theme="lavender-dream"] textarea,
        body[data-theme="soft-berry"] textarea,
        body[data-theme="morning-assembly"] textarea {
            background-color: rgba(255, 255, 255, 0.85);
            color: #0f172a;
        }

        nav.main-tamsis-nav {
            position: sticky;
            top: 0;
            z-index: 9990 !important;
            background: rgba(10, 22, 44, 0.96) !important;
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
        }
        body[data-theme="midnight-scholar"] nav.main-tamsis-nav { background: rgba(19, 17, 48, 0.96) !important; }
        body[data-theme="deep-ocean"] nav.main-tamsis-nav { background: rgba(4, 34, 56, 0.96) !important; }
        body[data-theme="forest-academy"] nav.main-tamsis-nav { background: rgba(5, 46, 26, 0.96) !important; }
        body[data-theme="mode-gelap"] nav.main-tamsis-nav { background: rgba(14, 14, 18, 0.97) !important; }
        body[data-theme="teal-growth"] nav.main-tamsis-nav,
        body[data-theme="creative-spark"] nav.main-tamsis-nav,
        body[data-theme="lavender-dream"] nav.main-tamsis-nav,
        body[data-theme="soft-berry"] nav.main-tamsis-nav,
        body[data-theme="morning-assembly"] nav.main-tamsis-nav {
            background: rgba(255, 255, 255, 0.96) !important;
        }

        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }

        main.page-animate-in {
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 640px) {
            nav.main-tamsis-nav > div {
                padding: 0.45rem 0.5rem !important;
                gap: 0.35rem !important;
            }
            .nav-links-wrap {
                width: 100%;
                display: flex !important;
                flex-wrap: nowrap !important;
                justify-content: space-between;
                gap: 2.5px !important;
                overflow-x: auto !important;
            }
            .nav-btn-anim {
                padding: 4px 5.5px !important;
                font-size: 9.5px !important;
                border-radius: 7px !important;
                letter-spacing: -0.02em;
                flex-shrink: 0;
            }
            main.page-animate-in {
                padding-left: 0.55rem !important;
                padding-right: 0.55rem !important;
                padding-top: 0.75rem !important;
            }
            .grid-5-cols,
            .grid-4-cols {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 0.5rem !important;
            }
            .grid-3-cols {
                grid-template-columns: 1fr !important;
                gap: 0.5rem !important;
            }
            /* Jadwal di HP pas dalam layar tanpa scroll kiri-kanan */
            .timetable-grid {
                width: 100% !important;
                min-width: 0 !important;
                table-layout: fixed !important;
            }
            .timetable-grid tbody tr {
                height: 50px !important;
            }
            .timetable-grid th,
            .timetable-grid td {
                font-size: 8px !important;
                padding: 2px 1.5px !important;
                line-height: 1.1 !important;
                word-break: break-word;
            }
            table th, table td {
                font-size: 9.5px !important;
                padding: 4px !important;
            }
        }
    </style>
</head>
<body class="antialiased" data-theme="academic-trust" data-font="sans" data-graphic="legacy" data-anim="on">

    <!-- Splash Screen Kilat -->
    <div id="tamsis-splash">
        <img src="{{ asset('images/logo-tamsis.png') }}"
             onerror="this.style.display='none'"
             alt="Logo Tamsis"
             style="width: 68px; height: 68px; object-fit: contain; margin-bottom: 12px;">
        <div style="font-size: 17px; font-weight: 800; letter-spacing: 0.04em;">
            PELAJAR TAMAN SISWA HEBAT!
        </div>
        <div style="font-size: 11px; opacity: 0.85; margin-top: 4px;" data-i18n="splash_sub">
            Memuat Jadwal & Ruang Kelas XI RPL 1...
        </div>
        <div style="width: 200px; height: 3px; background: rgba(255,255,255,0.25); border-radius: 9999px; overflow: hidden; margin-top: 14px;">
            <div class="splash-progress-fill"></div>
        </div>
    </div>
    <script>
        if (sessionStorage.getItem('tamsis_booted') || localStorage.getItem('app_anim') === 'off' || localStorage.getItem('app_graphic') === 'simple') {
            const sp = document.getElementById('tamsis-splash');
            if (sp) sp.style.display = 'none';
        }
    </script>

    <!-- Navbar Utama -->
    <nav class="main-tamsis-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[52px] py-1.5 flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('dashboard') }}" onclick="playSfx('click')" class="flex items-center gap-2 shrink-0" style="gap:8px;">
                <img src="{{ asset('images/tamsis.jpeg') }}" onerror="this.src='{{ asset('images/logo-tamsis.png') }}'" alt="Logo Perguruan Tamansiswa" class="w-7 h-7 sm:w-9 sm:h-9 rounded-full object-cover shrink-0 border border-white/30 shadow">
                <div class="leading-tight">
                    <div class="text-[11px] sm:text-sm font-extrabold tracking-wide" style="color: var(--primary);">
                        PELAJAR TAMAN SISWA HEBAT!
                    </div>
                    <div class="text-[9px] opacity-70 hidden md:block">
                        Pelajar Tamsis Harus: N (Niat), N (Nalar), I (Ikhlas), U (Unggul), N (Nasionalis)
                    </div>
                </div>
            </a>

            <div class="nav-links-wrap">
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" onclick="playSfx('enter')"
                       class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-extrabold whitespace-nowrap {{ request()->routeIs('admin.*') ? 'theme-primary shadow-sm' : 'border theme-border' }}"
                       style="{{ request()->routeIs('admin.*') ? '' : 'background-color: var(--primary-soft); color: var(--primary);' }}"
                       data-i18n="nav_ap">AP</a>
                @endif

                <a href="{{ route('dashboard') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('dashboard') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_jadwal">Jadwal</a>

                <a href="{{ route('tasks.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('tasks.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_list_tugas">List Tugas</a>

                <a href="{{ route('calendar.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('calendar.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_kalender">Kalender</a>

                <a href="{{ route('siswa.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('siswa.*') || request()->routeIs('students.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_siswa">Siswa</a>

                <a href="{{ route('profile.edit') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('profile.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_profile">Profil</a>

                <a href="{{ route('settings') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('settings') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_pengaturan">Pengaturan</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Halaman -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 page-animate-in">
        {{ $slot }}
    </main>

    <script>
        function applySavedAppearance() {
            const savedTheme   = localStorage.getItem('app_theme') || 'academic-trust';
            const savedFont    = localStorage.getItem('app_font') || 'sans';
            const savedGraphic = localStorage.getItem('app_graphic') || 'legacy';
            const savedAnim    = savedGraphic === 'simple' ? 'off' : (localStorage.getItem('app_anim') || 'on');

            document.body.setAttribute('data-theme', savedTheme);
            document.body.setAttribute('data-font', savedFont);
            document.body.setAttribute('data-graphic', savedGraphic);
            document.body.setAttribute('data-anim', savedAnim);
        }
        applySavedAppearance();

        function hideTamsisSplash() {
            sessionStorage.setItem('tamsis_booted', '1');
            const splash = document.getElementById('tamsis-splash');
            if (splash && !splash.classList.contains('splash-hidden')) {
                splash.classList.add('splash-hidden');
                setTimeout(() => splash.remove(), 220);
            }
        }
        setTimeout(hideTamsisSplash, 200);

        function playSfx(type = 'click') {
            if (localStorage.getItem('app_sfx') === 'muted') return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                if (type === 'enter') {
                    osc.frequency.setValueAtTime(587.33, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.09);
                } else if (type === 'secret') {
                    osc.frequency.setValueAtTime(523.25, ctx.currentTime);
                    osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.07);
                    osc.frequency.setValueAtTime(1046.5, ctx.currentTime + 0.14);
                } else {
                    osc.frequency.setValueAtTime(620, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(440, ctx.currentTime + 0.06);
                }
                gain.gain.setValueAtTime(0.05, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.18);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.19);
            } catch (e) {}
        }

        const translations = {
            id: {
                splash_sub: 'Memuat Jadwal & Ruang Kelas XI RPL 1...',
                nav_ap: 'AP',
                nav_jadwal: 'Jadwal',
                nav_list_tugas: 'List Tugas',
                nav_kalender: 'Kalender',
                nav_siswa: 'Siswa',
                nav_profile: 'Profil',
                nav_pengaturan: 'Pengaturan',
                settings_title: 'Pengaturan Tampilan',
                settings_sub: 'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.',
                dark_theme_label: 'Tema Gelap (Gradien)',
                light_theme_label: 'Tema Terang (Gradien)',
                font_style_label: 'Gaya Huruf',
                lang_label: 'Bahasa',
                sfx_label: 'Efek Suara (SFX)',
                sfx_on: 'Aktif',
                sfx_off: 'Senyap',
                easter_title: 'Kode Unik (Easter Egg) 🎁',
                easter_sub: 'Punya kode rahasia kelas XI RPL 1? Masukkan di sini untuk membuka fitur tersembunyi!',
                klaim_btn: 'Klaim',
                saran_btn: 'Kasih Saran & Laporan Bug',
                saran_sub: 'Beri rating bintang (bisa desimal seperti 4.5 / 3.4), komentar, atau kirim banyak foto/video jika menemukan bug.',
                rating_label: 'Rating Web (0.0 – 5.0 Bintang)',
                rating_hint: 'Geser slider atau ketik angka desimal seperti 4.5, 3.4, atau 5.0.',
                komentar_label: 'Komentar / Saran / Detail Bug',
                lampiran_bug_label: 'Lampiran Foto / Video Bug (Bisa Lebih Dari 1 File)',
                kirim_saran_btn: 'Kirim Saran ke Admin',
                ap_title: 'Admin Panel (AP)',
                ap_sub: 'Kelola persetujuan akun, role pengguna, izin bingkai siswa, dan tinjau kritik dari kelas XI RPL 1.',
                critic_title: 'Kritik',
                critic_sub: 'Ulasan bintang, masukan, dan laporan bug dari pengguna web kelas.',
                avg_rating_label: 'Rata-rata Rating Web',
                critic_empty: 'Belum ada kritik, saran, atau laporan bug yang masuk.',
            },
            en: {
                splash_sub: 'Loading XI RPL 1 Timetable & Classroom...',
                nav_ap: 'AP',
                nav_jadwal: 'Schedule',
                nav_list_tugas: 'Task List',
                nav_kalender: 'Calendar',
                nav_siswa: 'Students',
                nav_profile: 'Profile',
                nav_pengaturan: 'Settings',
                settings_title: 'Display Settings',
                settings_sub: 'Customize color gradients, graphics style, animations, sound effects, and language.',
                dark_theme_label: 'Dark Theme (Gradient)',
                light_theme_label: 'Light Theme (Gradient)',
                font_style_label: 'Font Style',
                lang_label: 'Language',
                sfx_label: 'Sound Effects (SFX)',
                sfx_on: 'Active',
                sfx_off: 'Muted',
                easter_title: 'Unique Code (Easter Egg) 🎁',
                easter_sub: 'Have a secret XI RPL 1 class code? Enter it here to unlock hidden features!',
                klaim_btn: 'Claim',
                saran_btn: 'Send Feedback & Bug Report',
                saran_sub: 'Rate with stars (decimals like 4.5 / 3.4 supported), leave a comment, or attach photos/videos of bugs.',
                rating_label: 'Web Rating (0.0 – 5.0 Stars)',
                rating_hint: 'Drag the slider or enter a decimal value such as 4.5, 3.4, or 5.0.',
                komentar_label: 'Comment / Suggestion / Bug Details',
                lampiran_bug_label: 'Bug Photo / Video Attachment (Multiple Files Supported)',
                kirim_saran_btn: 'Submit Feedback to Admin',
                ap_title: 'Admin Panel (AP)',
                ap_sub: 'Manage account approvals, user roles, frame approvals, and class feedback.',
                critic_title: 'Critic',
                critic_sub: 'Star ratings, feedback, and bug reports submitted by class users.',
                avg_rating_label: 'Average Web Rating',
                critic_empty: 'No feedback, criticism, or bug reports submitted yet.',
            }
        };

        function applyLanguage(lang) {
            if (!translations[lang]) lang = 'id';
            localStorage.setItem('app_lang', lang);
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (translations[lang][key]) {
                    el.textContent = translations[lang][key];
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyLanguage(localStorage.getItem('app_lang') || 'id');
        });
    </script>
</body>
</html>