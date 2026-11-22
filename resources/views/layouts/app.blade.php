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

        /* Animasi Halaman & Kartu Jadwal Seperti Semula */
        @keyframes pageFadeSlide {
            0% { opacity: 0; transform: translateY(10px) scale(0.99); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .page-animate-in {
            animation: pageFadeSlide 0.32s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Animasi Hover Kotak Mapel & Tombol Interaktif */
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

        /* Hilangkan Bug Scrollbar Putih pada Navbar */
        .nav-links-wrap {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            overflow: visible !important;
        }
        .nav-links-wrap::-webkit-scrollbar {
            display: none;
        }

        /* Splash Screen Super Kilat (Hanya 1x per sesi) */
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

        /* Navbar Solid & Selalu Di Lapisan Paling Atas (Anti Tertimpa Konten) */
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

        /* Titik Kuning & Merah Deadline Selalu Muncul (Tidak Pernah Hilang) */
        @keyframes deadlineDotStay {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.78; transform: scale(1.18); }
        }
        .deadline-dot-fixed,
        span[class*="bg-amber-"],
        span[class*="bg-yellow-"],
        span[class*="bg-red-"].rounded-full {
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            animation: deadlineDotStay 1.6s ease-in-out infinite !important;
            z-index: 20 !important;
        }
    </style>
    <style>
        /* =========================================================
           INTEGRASI LAYAR HP, TABLET & LAPTOP (RESPONSIVE SUITE)
           ========================================================= */
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }

        main.page-animate-in {
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            nav.main-tamsis-nav > div {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            main.page-animate-in {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
                padding-top: 1.25rem !important;
            }
            .grid-5-cols {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }
            #tamsis-lightbox-modal .h-\[72vh\] {
                height: 62vh !important;
            }
        }

        @media (max-width: 640px) {
            nav.main-tamsis-nav > div {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                gap: 0.5rem !important;
            }
            .nav-links-wrap {
                width: 100%;
                justify-content: flex-start;
                gap: 5px !important;
            }
            .nav-btn-anim {
                padding: 5px 9px !important;
                font-size: 11px !important;
            }
            main.page-animate-in {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                padding-top: 1rem !important;
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
            .j-filter-btn {
                padding: 5px 10px !important;
                font-size: 11px !important;
            }
            table th, table td {
                font-size: 11px !important;
                padding: 6px 8px !important;
                white-space: nowrap;
            }
            #tamsis-lightbox-modal .h-\[72vh\] {
                height: 54vh !important;
            }
            #tamsis-editor-canvas {
                width: 100% !important;
                height: auto !important;
            }
        }

        video {
            position: relative;
            z-index: 15;
            max-width: 100%;
        }
    </style>
    <style id="tamsis-orientation-suite">
        @media (min-width: 1025px) {
            #tamsis-lightbox-modal .h-\[72vh\],
            #tamsis-lightbox-modal .h-\[62vh\],
            #tamsis-lightbox-modal .h-\[54vh\] {
                height: 72vh !important;
            }
        }

        @media (min-width: 641px) and (max-width: 1024px) and (orientation: portrait) {
            main.page-animate-in {
                padding: 1.15rem !important;
            }
            .grid-5-cols {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
            #tamsis-lightbox-modal .h-\[72vh\],
            #tamsis-lightbox-modal .h-\[62vh\],
            #tamsis-lightbox-modal .h-\[54vh\] {
                height: 56vh !important;
            }
        }

        @media (min-width: 768px) and (max-width: 1280px) and (orientation: landscape) {
            main.page-animate-in {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
                padding-top: 1rem !important;
            }
            .grid-5-cols {
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            }
            #tamsis-lightbox-modal .h-\[72vh\],
            #tamsis-lightbox-modal .h-\[62vh\],
            #tamsis-lightbox-modal .h-\[54vh\] {
                height: 66vh !important;
            }
        }

        @media (max-width: 640px) and (orientation: portrait) {
            nav.main-tamsis-nav > div {
                padding: 0.6rem 0.75rem !important;
            }
            main.page-animate-in {
                padding: 0.85rem 0.75rem 1.5rem 0.75rem !important;
            }
            #tamsis-lightbox-modal .h-\[72vh\],
            #tamsis-lightbox-modal .h-\[62vh\],
            #tamsis-lightbox-modal .h-\[54vh\] {
                height: 50vh !important;
            }
        }

        @media (max-height: 520px) and (orientation: landscape) {
            nav.main-tamsis-nav > div {
                padding-top: 0.35rem !important;
                padding-bottom: 0.35rem !important;
            }
            main.page-animate-in {
                padding-top: 0.65rem !important;
                padding-bottom: 0.85rem !important;
            }
            #tamsis-lightbox-modal {
                padding: 0.5rem !important;
            }
            #tamsis-lightbox-modal .h-\[72vh\],
            #tamsis-lightbox-modal .h-\[62vh\],
            #tamsis-lightbox-modal .h-\[54vh\] {
                height: 58vh !important;
            }
            #tamsis-img-editor-modal > div {
                padding: 0.85rem !important;
                max-height: 95vh !important;
            }
            #tamsis-editor-canvas {
                max-height: 44vh !important;
                width: auto !important;
            }
        }
    </style>
</head>
<body class="antialiased" data-theme="academic-trust" data-font="sans">

    <!-- Splash Screen Kilat (Otomatis dilewati saat pindah antar halaman) -->
    <div id="tamsis-splash">
        <img src="{{ asset('images/logo-tamsis.png') }}"
             onerror="this.style.display='none'"
             alt="Logo Tamsis"
             style="width: 68px; height: 68px; object-fit: contain; margin-bottom: 12px;">
        <span style="display:inline-flex;align-items:center;gap:8px;vertical-align:middle;flex-shrink:0;">
            <img src="{{ asset('images/tamsis.jpeg') }}" onerror="this.src='{{ asset('images/logo-tamsis.png') }}'" alt="Logo Perguruan Tamansiswa" style="width:36px;height:36px;border-radius:9999px;object-fit:cover;flex-shrink:0;" class="border border-white/30 shadow">
            <div style="font-size: 17px; font-weight: 800; letter-spacing: 0.04em;">
                PELAJAR TAMAN SISWA HEBAT!
            </div>
        </span>
        <div style="font-size: 11px; opacity: 0.85; margin-top: 4px;" data-i18n="splash_sub">
            Memuat Jadwal & Ruang Kelas XI RPL 1...
        </div>
        <div style="width: 200px; height: 3px; background: rgba(255,255,255,0.25); border-radius: 9999px; overflow: hidden; margin-top: 14px;">
            <div class="splash-progress-fill"></div>
        </div>
    </div>
    <script>
        if (sessionStorage.getItem('tamsis_booted')) {
            document.getElementById('tamsis-splash').style.display = 'none';
        }
    </script>

    <!-- Navbar Utama -->
    <nav class="main-tamsis-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[56px] py-1.5 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('dashboard') }}" onclick="playSfx('click')" class="flex items-center gap-2 shrink-0" style="gap:8px;">
                <img src="{{ asset('images/logo-tamsis.png') }}"
                     onerror="this.style.display='none'"
                     alt="Logo"
                     class="w-8 h-8 rounded-full object-contain">
                <div class="leading-tight">
                    <span style="display:inline-flex;align-items:center;gap:8px;vertical-align:middle;flex-shrink:0;">
                        <img src="{{ asset('images/tamsis.jpeg') }}" onerror="this.src='{{ asset('images/logo-tamsis.png') }}'" alt="Logo Perguruan Tamansiswa" style="width:36px;height:36px;border-radius:9999px;object-fit:cover;flex-shrink:0;" class="border border-white/30 shadow">
                        <div class="text-xs sm:text-sm font-extrabold tracking-wide" style="color: var(--primary);">
                            PELAJAR TAMAN SISWA HEBAT!
                        </div>
                    </span>
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
            const savedTheme = localStorage.getItem('app_theme') || 'academic-trust';
            const savedFont  = localStorage.getItem('app_font') || 'sans';
            document.body.setAttribute('data-theme', savedTheme);
            document.body.setAttribute('data-font', savedFont);
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
                jadwal_title: 'Jadwal Pelajaran XI RPL 1',
                jadwal_sub: 'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.',
                hari_jam: 'Hari / Jam',
                day_senin: 'Senin',
                day_selasa: 'Selasa',
                day_rabu: 'Rabu',
                day_kamis: 'Kamis',
                day_jumat: 'Jumat',
                settings_title: 'Pengaturan Tampilan',
                settings_sub: 'Sesuaikan tema gradien warna, gaya huruf, suara efek, dan bahasa aplikasi.',
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
                saran_sub: 'Beri rating bintang (bisa desimal seperti 4.5 / 3.4), komentar, atau kirim foto/video jika menemukan bug.',
                rating_label: 'Rating Web (0.0 – 5.0 Bintang)',
                rating_hint: 'Geser slider atau ketik angka desimal seperti 4.5, 3.4, atau 5.0.',
                komentar_label: 'Komentar / Saran / Detail Bug',
                lampiran_bug_label: 'Lampiran Foto / Video Bug (Opsional)',
                kirim_saran_btn: 'Kirim Saran ke Admin',
                ap_title: 'Admin Panel (AP)',
                ap_sub: 'Kelola persetujuan akun, role pengguna, dan tinjau kritik dari kelas XI RPL 1.',
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
                jadwal_title: 'XI RPL 1 Class Timetable',
                jadwal_sub: 'Click any subject box to view Notes, Assignments, Homework, or Events.',
                hari_jam: 'Day / Period',
                day_senin: 'Monday',
                day_selasa: 'Tuesday',
                day_rabu: 'Wednesday',
                day_kamis: 'Thursday',
                day_jumat: 'Friday',
                settings_title: 'Display Settings',
                settings_sub: 'Customize color gradient themes, font styles, sound effects, and app language.',
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
                lampiran_bug_label: 'Bug Photo / Video Attachment (Optional)',
                kirim_saran_btn: 'Submit Feedback to Admin',
                ap_title: 'Admin Panel (AP)',
                ap_sub: 'Manage account approvals, user roles, and review class feedback.',
                critic_title: 'Critic',
                critic_sub: 'Star ratings, feedback, and bug reports submitted by class users.',
                avg_rating_label: 'Average Web Rating',
                critic_empty: 'No feedback, criticism, or bug reports submitted yet.',
            },
            ja: {
                splash_sub: 'XI RPL 1 時間割と教室を読み込み中...',
                nav_ap: 'AP',
                nav_jadwal: '時間割',
                nav_list_tugas: '課題一覧',
                nav_kalender: 'カレンダー',
                nav_siswa: '生徒一覧',
                nav_profile: 'プロフィール',
                nav_pengaturan: '設定',
                jadwal_title: 'XI RPL 1 クラス時間割',
                jadwal_sub: '科目ボックスをクリックしてノート・課題・宿題・イベントを確認します。',
                hari_jam: '曜日 / 時限',
                day_senin: '月曜日',
                day_selasa: '火曜日',
                day_rabu: '水曜日',
                day_kamis: '木曜日',
                day_jumat: '金曜日',
                settings_title: '表示設定',
                settings_sub: 'カラーグラデーションテーマ、フォント、効果音、言語をカスタマイズします。',
                dark_theme_label: 'ダークテーマ（グラデーション）',
                light_theme_label: 'ライトテーマ（グラデーション）',
                font_style_label: 'フォントスタイル',
                lang_label: '言語',
                sfx_label: '効果音 (SFX)',
                sfx_on: 'オン',
                sfx_off: 'ミュート',
                easter_title: 'ユニークコード (Easter Egg) 🎁',
                easter_sub: 'XI RPL 1 の秘密コードをお持ちですか？入力して隠し機能を解放しましょう！',
                klaim_btn: '引き換え',
                saran_btn: 'ご意見・バグ報告を送る',
                saran_sub: '星評価（4.5や3.4などの小数も可）、コメント、バグの写真や動画を送信できます。',
                rating_label: 'ウェブ評価（0.0 ～ 5.0 星）',
                rating_hint: 'スライダーを動かすか、4.5・3.4・5.0などの数値を直接入力してください。',
                komentar_label: 'コメント / ご提案 / バグの詳細',
                lampiran_bug_label: 'バグの写真・動画添付（任意）',
                kirim_saran_btn: '管理者に送信する',
                ap_title: '管理パネル (AP)',
                ap_sub: 'アカウント承認、ユーザー権限、クラスからのご意見を管理します。',
                critic_title: 'ご意見・批評',
                critic_sub: 'クラスユーザーから寄せられた星評価・ご意見・バグ報告です。',
                avg_rating_label: 'ウェブ平均評価',
                critic_empty: 'まだご意見やバグ報告はありません。',
            },
            ru: {
                splash_sub: 'Загрузка расписания и класса XI RPL 1...',
                nav_ap: 'AP',
                nav_jadwal: 'Расписание',
                nav_list_tugas: 'Задания',
                nav_kalender: 'Календарь',
                nav_siswa: 'Ученики',
                nav_profile: 'Профиль',
                nav_pengaturan: 'Настройки',
                jadwal_title: 'Расписание уроков XI RPL 1',
                jadwal_sub: 'Нажмите на предмет, чтобы открыть конспекты, задания, ДЗ или события.',
                hari_jam: 'День / Урок',
                day_senin: 'Понедельник',
                day_selasa: 'Вторник',
                day_rabu: 'Среда',
                day_kamis: 'Четверг',
                day_jumat: 'Пятница',
                settings_title: 'Настройки отображения',
                settings_sub: 'Настройте цветовые градиенты, стиль шрифта, звуковые эффекты и язык.',
                dark_theme_label: 'Тёмная тема (Градиент)',
                light_theme_label: 'Светлая тема (Градиент)',
                font_style_label: 'Стиль шрифта',
                lang_label: 'Язык',
                sfx_label: 'Звуковые эффекты (SFX)',
                sfx_on: 'Включено',
                sfx_off: 'Без звука',
                easter_title: 'Уникальный код (Easter Egg) 🎁',
                easter_sub: 'Есть секретный код класса XI RPL 1? Введите его здесь, чтобы открыть скрытые функции!',
                klaim_btn: 'Активировать',
                saran_btn: 'Отправить отзыв и баг-репорт',
                saran_sub: 'Поставьте оценку звёздами (можно дробную, например 4.5 / 3.4), напишите отзыв или прикрепите фото/видео бага.',
                rating_label: 'Оценка сайта (0.0 – 5.0 звёзд)',
                rating_hint: 'Передвиньте ползунок или введите число, например 4.5, 3.4 или 5.0.',
                komentar_label: 'Комментарий / Предложение / Описание бага',
                lampiran_bug_label: 'Фото или видео бага (необязательно)',
                kirim_saran_btn: 'Отправить администратору',
                ap_title: 'Админ-панель (AP)',
                ap_sub: 'Управление подтверждением аккаунтов, ролями и отзывами класса XI RPL 1.',
                critic_title: 'Критика',
                critic_sub: 'Оценки, отзывы и сообщения об ошибках от пользователей класса.',
                avg_rating_label: 'Средний рейтинг сайта',
                critic_empty: 'Отзывов, предложений и баг-репортов пока нет.',
            }
        };

        const phraseDictionary = {
            "Daftar Tugas, PR & Event Kelas": { en: "Class Assignments, Homework & Events", ja: "クラスの課題・宿題・イベント一覧", ru: "Список заданий, ДЗ и событий класса" },
            "Gabungan seluruh tenggat dari semua mata pelajaran XI RPL 1.": { en: "All deadlines combined across all XI RPL 1 subjects.", ja: "XI RPL 1の全科目の締切一覧です。", ru: "Все сроки сдачи по всем предметам XI RPL 1." },
            "Belum ada tugas, PR, atau event yang tercatat.": { en: "No assignments, homework, or events recorded yet.", ja: "登録された課題・宿題・イベントはまだありません。", ru: "Заданий, ДЗ и событий пока нет." },
            "Semua": { en: "All", ja: "すべて", ru: "Все" },
            "📌 Tugas": { en: "📌 Assignments", ja: "📌 課題", ru: "📌 Задания" },
            "🏠 PR": { en: "🏠 Homework", ja: "🏠 宿題", ru: "🏠 ДЗ" },
            "🎉 Event": { en: "🎉 Events", ja: "🎉 イベント", ru: "🎉 События" },
            "☑️ Tandai Selesai": { en: "☑️ Mark Done", ja: "☑️ 完了にする", ru: "☑️ Отметить выполненным" },
            "✅ Selesai": { en: "✅ Completed", ja: "✅ 完了済み", ru: "✅ Выполнено" },
            "✅ Sudah Dikerjakan": { en: "✅ Completed", ja: "✅ 完了済み", ru: "✅ Выполнено" },
            "Buka Mapel →": { en: "Open Subject →", ja: "科目を開く →", ru: "Открыть предмет →" },
            "Anggota Kelas XI RPL 1": { en: "XI RPL 1 Class Members", ja: "XI RPL 1 クラスメンバー", ru: "Ученики класса XI RPL 1" },
            "Ketua Kelas": { en: "Class President", ja: "学級委員長", ru: "Староста класса" },
            "Wakil Ketua Kelas": { en: "Vice Class President", ja: "副学級委員長", ru: "Заместитель старосты" },
            "+ Tambah Siswa": { en: "+ Add Student", ja: "+ 生徒を追加", ru: "+ Добавить ученика" },
            "← Kembali ke Jadwal Utama": { en: "← Back to Main Timetable", ja: "← 時間割に戻る", ru: "← Назад к расписанию" },
            "Catatan": { en: "Notes", ja: "ノート", ru: "Конспекты" },
            "Tugas": { en: "Assignments", ja: "課題", ru: "Задания" },
            "PR": { en: "Homework", ja: "宿題", ru: "Домашнее задание" },
            "Event": { en: "Events", ja: "イベント", ru: "События" },
            "Nama": { en: "Name", ja: "名前", ru: "Имя" },
            "Role": { en: "Role", ja: "役割", ru: "Роль" },
            "Aksi": { en: "Action", ja: "操作", ru: "Действие" },
            "Setujui": { en: "Approve", ja: "承認", ru: "Одобрить" },
            "Hapus": { en: "Delete", ja: "削除", ru: "Удалить" },
            "Edit": { en: "Edit", ja: "編集", ru: "Изменить" }
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

            if (lang !== 'id') {
                const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
                let node;
                while ((node = walker.nextNode())) {
                    const trimmed = node.nodeValue.trim();
                    if (trimmed && phraseDictionary[trimmed] && phraseDictionary[trimmed][lang]) {
                        node.nodeValue = node.nodeValue.replace(trimmed, phraseDictionary[trimmed][lang]);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('app_lang') || 'id';
            applyLanguage(savedLang);
        });
    </script>
    <style>
        /* Titik Kuning (Tenggat), Merah (Deadline), Hijau (Selesai) Permanen Tidak Pernah Hilang */
        @keyframes dotPulseSafe {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.22); opacity: 0.92; }
        }
        .dot-tenggat-kuning {
            width: 11px !important;
            height: 11px !important;
            border-radius: 9999px !important;
            background-color: #facc15 !important;
            box-shadow: 0 0 8px #facc15, 0 0 14px rgba(250, 204, 21, 0.9) !important;
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            animation: dotPulseSafe 1.8s ease-in-out infinite !important;
            z-index: 30 !important;
        }
        .dot-deadline-merah {
            width: 11px !important;
            height: 11px !important;
            border-radius: 9999px !important;
            background-color: #ef4444 !important;
            box-shadow: 0 0 8px #ef4444, 0 0 14px rgba(239, 68, 68, 0.9) !important;
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            animation: dotPulseSafe 1.4s ease-in-out infinite !important;
            z-index: 30 !important;
        }
        .dot-selesai-hijau {
            width: 11px !important;
            height: 11px !important;
            border-radius: 9999px !important;
            background-color: #22c55e !important;
            box-shadow: 0 0 8px #22c55e, 0 0 14px rgba(34, 197, 94, 0.9) !important;
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            z-index: 30 !important;
        }

        /* Bar 8 Tombol Filter Jadwal */
        .jadwal-filter-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            margin-bottom: 6px;
        }
        .j-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 13px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            border: 1.5px solid var(--border-color);
            background: rgba(15, 23, 42, 0.45);
            color: var(--text-main);
            cursor: pointer;
            user-select: none;
            transition: transform 0.24s cubic-bezier(0.22, 1, 0.36, 1),
                        background-color 0.24s ease,
                        color 0.24s ease,
                        border-color 0.24s ease,
                        box-shadow 0.24s ease,
                        opacity 0.24s ease !important;
            will-change: transform;
        }
        body[data-theme="teal-growth"] .j-filter-btn,
        body[data-theme="creative-spark"] .j-filter-btn,
        body[data-theme="lavender-dream"] .j-filter-btn,
        body[data-theme="soft-berry"] .j-filter-btn,
        body[data-theme="morning-assembly"] .j-filter-btn {
            background: rgba(255, 255, 255, 0.85);
            color: #0f172a;
        }
        .j-filter-btn:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }
        @keyframes filterUnselectPop {
            0%   { transform: scale(1.06); }
            45%  { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
        .j-filter-btn.is-unselecting {
            animation: filterUnselectPop 0.26s cubic-bezier(0.22, 1, 0.36, 1) !important;
        }
        .j-filter-btn.active {
            background: var(--primary) !important;
            color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: 0 0 14px rgba(59, 130, 246, 0.6);
            transform: scale(1.06);
        }

        /* Sorot & Redup Kotak Mapel */
        .mapel-dimmed {
            opacity: 0.2 !important;
            filter: grayscale(75%);
            transform: scale(0.97) !important;
        }
        .mapel-highlighted {
            opacity: 1 !important;
            transform: translateY(-2px) scale(1.035) !important;
            box-shadow: 0 0 0 2.5px #38bdf8, 0 8px 22px rgba(56, 189, 248, 0.45) !important;
            z-index: 25 !important;
        }
    </style>

    <!-- Modal Lightbox Slide & Zoom (Tersembunyi Secara Default) -->
    <div id="tamsis-lightbox-modal" style="display: none;" class="hidden fixed inset-0 z-[9997] bg-black/90 backdrop-blur-md flex flex-col items-center justify-center p-4 select-none">
        <div class="w-full max-w-5xl flex items-center justify-between text-white mb-3 gap-2">
            <div class="text-xs sm:text-sm font-bold">
                <span id="lb-counter">1 / 1</span>
                <span id="lb-zoom-label" class="ml-3 px-2.5 py-0.5 rounded-full bg-white/15 text-xs">100%</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="lbZoom(-0.25)" class="px-3 py-1.5 rounded-lg bg-white/15 hover:bg-white/25 text-xs font-extrabold">🔍 -</button>
                <button type="button" onclick="lbZoom(0.25)" class="px-3 py-1.5 rounded-lg bg-white/15 hover:bg-white/25 text-xs font-extrabold">🔍 +</button>
                <button type="button" onclick="lbResetView()" class="px-3 py-1.5 rounded-lg bg-white/15 hover:bg-white/25 text-xs font-bold">Reset</button>
                <button type="button" onclick="closeTamsisLightbox()" class="px-3.5 py-1.5 rounded-lg bg-red-500/80 hover:bg-red-500 text-xs font-extrabold">✕ Tutup</button>
            </div>
        </div>

        <div class="relative w-full max-w-5xl h-[72vh] flex items-center justify-center overflow-hidden rounded-2xl border border-white/15 bg-black/50">
            <button type="button" id="lb-prev-btn" onclick="lbSlide(-1)"
                    class="hidden absolute left-3 z-20 w-11 h-11 rounded-full bg-black/65 hover:bg-black/90 text-white text-xl font-extrabold flex items-center justify-center border border-white/25">
                ◀
            </button>

            <img id="lb-image" src="" alt="Preview"
                 onmousedown="lbStartPan(event)" onwheel="lbWheelZoom(event)"
                 class="max-h-full max-w-full object-contain cursor-grab active:cursor-grabbing transition-transform duration-150 hidden">

            <video id="lb-video" src="" controls class="max-h-full max-w-full rounded-xl hidden"></video>

            <button type="button" id="lb-next-btn" onclick="lbSlide(1)"
                    class="hidden absolute right-3 z-20 w-11 h-11 rounded-full bg-black/65 hover:bg-black/90 text-white text-xl font-extrabold flex items-center justify-center border border-white/25">
                ▶
            </button>
        </div>

        <!-- Thumbnail Strip Jika Media Lebih Dari 1 -->
        <div id="lb-thumbs" class="flex items-center gap-2 mt-3 overflow-x-auto max-w-full py-1"></div>
    </div>

    <!-- Modal Editor Gambar (Tersembunyi Secara Default) -->
    <div id="tamsis-img-editor-modal" style="display: none;" class="hidden fixed inset-0 z-[9998] bg-black/85 backdrop-blur-md flex items-center justify-center p-4">
        <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-3xl w-full p-5 sm:p-6 space-y-4 max-h-[92vh] overflow-y-auto">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h3 class="text-base sm:text-lg font-extrabold">✂️ Edit Gambar (Crop, Coret & Atur Posisi)</h3>
                    <p id="ed-file-info" class="text-xs opacity-75">Sesuaikan posisi/skala, coret bagian penting, lalu crop sebelum diunggah.</p>
                </div>
                <button type="button" onclick="closeImgEditor()" class="px-3 py-1 rounded-lg border theme-border text-xs font-bold">✕ Batal</button>
            </div>

            <!-- Toolbar Mode & Alat -->
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="ed-mode-move" onclick="setEditorMode('move')" class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold theme-primary">
                    ✋ Atur Posisi
                </button>
                <button type="button" id="ed-mode-draw" onclick="setEditorMode('draw')" class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold border theme-border">
                    ✏️ Coret
                </button>
                <button type="button" id="ed-mode-crop" onclick="setEditorMode('crop')" class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold border theme-border">
                    ✂️ Area Crop
                </button>

                <div class="flex items-center gap-1.5 ml-1">
                    <span class="text-xs font-bold opacity-75">Skala:</span>
                    <input type="range" id="ed-scale-slider" min="0.4" max="2.5" step="0.05" value="1" oninput="onScaleChange(this.value)" class="w-24 accent-blue-500">
                </div>

                <div class="flex items-center gap-1.5 ml-1">
                    <span class="text-xs font-bold opacity-75">Warna Coret:</span>
                    <input type="color" id="ed-pen-color" value="#ef4444" class="w-7 h-7 rounded cursor-pointer border-0 bg-transparent">
                    <input type="range" id="ed-pen-size" min="2" max="18" step="1" value="4" class="w-16 accent-red-500">
                </div>

                <button type="button" onclick="clearEditorStrokes()" class="px-3 py-1.5 rounded-xl text-xs font-bold border theme-border hover:opacity-80">
                    🧹 Hapus Coretan
                </button>
                <button type="button" onclick="resetEditorCrop()" class="px-3 py-1.5 rounded-xl text-xs font-bold border theme-border hover:opacity-80">
                    ↺ Reset
                </button>
            </div>

            <!-- Canvas Area -->
            <div class="w-full flex justify-center bg-slate-950/80 rounded-2xl border theme-border p-3 overflow-hidden">
                <canvas id="tamsis-editor-canvas" width="640" height="380"
                        onmousedown="edPointerDown(event)" onmousemove="edPointerMove(event)" onmouseup="edPointerUp()" onmouseleave="edPointerUp()"
                        class="rounded-xl max-w-full cursor-grab active:cursor-grabbing"></canvas>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-1">
                <button type="button" onclick="skipEditOriginal()" class="px-4 py-2 rounded-xl border theme-border text-xs font-bold">
                    Gunakan Asli
                </button>
                <button type="button" onclick="applyEditedImageToInput()" class="px-5 py-2 rounded-xl theme-primary text-xs sm:text-sm font-extrabold shadow-lg">
                    ✅ Crop & Simpan Hasil Edit
                </button>
            </div>
        </div>
    </div>

    <script>
        // ==========================================
        // 1. LIGHTBOX SLIDE & ZOOM (SEMUA FOTO & VIDEO)
        // ==========================================
        let lbItems = [];
        let lbIndex = 0;
        let lbScale = 1;
        let lbPanX = 0;
        let lbPanY = 0;
        let lbDragging = false;
        let lbDragStartX = 0;
        let lbDragStartY = 0;

        function isMediaUrl(url) {
            if (!url) return false;
            return /\.(png|jpe?g|gif|webp|bmp|svg|heic|heif|avif|tiff|ico|mp4|webm|mov|avi|mkv|m4v|3gp|flv|wmv)(\?.*)?$/i.test(url)
                || url.includes('/storage/');
        }

        function isVideoUrl(url) {
            return /\.(mp4|webm|mov|avi|mkv|m4v|3gp|flv|wmv)(\?.*)?$/i.test(url || '');
        }

        function collectCardMedia(el) {
            let card = el.closest('article, .rounded-2xl, .rounded-xl, .border, .shadow') || el.parentElement;
            for (let i = 0; i < 3; i++) {
                if (!card || !card.parentElement) break;
                const found = card.querySelectorAll('img[src*="/storage/"], video source[src*="/storage/"], video[src*="/storage/"], a[href*="/storage/"]');
                if (found.length > 1) break;
                card = card.parentElement;
            }

            const scope = card || document;
            const seen = new Set();
            const items = [];

            scope.querySelectorAll('img, video, video source, a[href]').forEach(node => {
                let src = '';
                if (node.tagName === 'A') {
                    src = node.getAttribute('href') || '';
                } else {
                    src = node.getAttribute('src') || '';
                }
                if (!src || !isMediaUrl(src)) return;
                if (src.includes('logo-tamsis') || src.includes('crown') || src.includes('avatar')) return;

                const fullUrl = node.href || node.src || src;
                if (!seen.has(fullUrl)) {
                    seen.add(fullUrl);
                    items.push({ src: fullUrl, element: node });
                }
            });

            return items;
        }

        function renderLightboxSlide() {
            const item = lbItems[lbIndex];
            if (!item) return;

            lbResetView();
            const imgEl = document.getElementById('lb-image');
            const vidEl = document.getElementById('lb-video');
            const counterEl = document.getElementById('lb-counter');
            const prevBtn = document.getElementById('lb-prev-btn');
            const nextBtn = document.getElementById('lb-next-btn');
            const thumbsEl = document.getElementById('lb-thumbs');

            counterEl.textContent = `${lbIndex + 1} / ${lbItems.length}`;
            prevBtn.classList.toggle('hidden', lbItems.length <= 1);
            nextBtn.classList.toggle('hidden', lbItems.length <= 1);

            if (isVideoUrl(item.src)) {
                imgEl.classList.add('hidden');
                vidEl.classList.remove('hidden');
                vidEl.src = item.src;
            } else {
                vidEl.classList.add('hidden');
                vidEl.pause();
                imgEl.classList.remove('hidden');
                imgEl.src = item.src;
            }

            thumbsEl.innerHTML = '';
            if (lbItems.length > 1) {
                lbItems.forEach((it, idx) => {
                    const t = document.createElement('button');
                    t.type = 'button';
                    t.onclick = () => { lbIndex = idx; renderLightboxSlide(); };
                    t.className = `w-14 h-14 rounded-lg overflow-hidden border-2 shrink-0 ${idx === lbIndex ? 'border-sky-400 scale-105' : 'border-white/25 opacity-65'}`;
                    if (isVideoUrl(it.src)) {
                        t.innerHTML = `<div class="w-full h-full bg-slate-800 text-white text-[10px] font-bold flex items-center justify-center">VIDEO</div>`;
                    } else {
                        t.innerHTML = `<img src="${it.src}" class="w-full h-full object-cover">`;
                    }
                    thumbsEl.appendChild(t);
                });
            }
        }

        function openTamsisLightbox(items, startIndex = 0) {
            if (!items || items.length === 0) return;
            if (typeof playSfx === 'function') playSfx('click');
            lbItems = items;
            lbIndex = Math.max(0, Math.min(startIndex, items.length - 1));
            const modal = document.getElementById('tamsis-lightbox-modal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            renderLightboxSlide();
        }

        function closeTamsisLightbox() {
            const vidEl = document.getElementById('lb-video');
            if (vidEl) vidEl.pause();
            const modal = document.getElementById('tamsis-lightbox-modal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function lbSlide(dir) {
            if (lbItems.length <= 1) return;
            if (typeof playSfx === 'function') playSfx('click');
            lbIndex = (lbIndex + dir + lbItems.length) % lbItems.length;
            renderLightboxSlide();
        }

        function updateLbTransform() {
            const imgEl = document.getElementById('lb-image');
            if (!imgEl) return;
            imgEl.style.transform = `translate(${lbPanX}px, ${lbPanY}px) scale(${lbScale})`;
            document.getElementById('lb-zoom-label').textContent = `${Math.round(lbScale * 100)}%`;
        }

        function lbZoom(delta) {
            lbScale = Math.max(0.5, Math.min(5, lbScale + delta));
            if (lbScale <= 1) { lbPanX = 0; lbPanY = 0; }
            updateLbTransform();
        }

        function lbWheelZoom(e) {
            e.preventDefault();
            lbZoom(e.deltaY < 0 ? 0.2 : -0.2);
        }

        function lbResetView() {
            lbScale = 1;
            lbPanX = 0;
            lbPanY = 0;
            updateLbTransform();
        }

        function lbStartPan(e) {
            if (lbScale <= 1) return;
            lbDragging = true;
            lbDragStartX = e.clientX - lbPanX;
            lbDragStartY = e.clientY - lbPanY;
        }

        window.addEventListener('mousemove', (e) => {
            if (!lbDragging) return;
            lbPanX = e.clientX - lbDragStartX;
            lbPanY = e.clientY - lbDragStartY;
            updateLbTransform();
        });

        window.addEventListener('mouseup', () => {
            lbDragging = false;
        });

        window.addEventListener('keydown', (e) => {
            const modal = document.getElementById('tamsis-lightbox-modal');
            if (!modal || modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeTamsisLightbox();
            if (e.key === 'ArrowLeft') lbSlide(-1);
            if (e.key === 'ArrowRight') lbSlide(1);
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('#tamsis-lightbox-modal') || e.target.closest('#tamsis-img-editor-modal')) return;

            const anchor = e.target.closest('a[href]');
            if (anchor) {
                const href = anchor.getAttribute('href') || '';
                if (isMediaUrl(href) && !href.includes('/settings') && !href.includes('/pengaturan')) {
                    e.preventDefault();
                    const items = collectCardMedia(anchor);
                    const idx = Math.max(0, items.findIndex(it => it.src === anchor.href));
                    openTamsisLightbox(items.length ? items : [{ src: anchor.href }], idx);
                    return;
                }
            }

            const mediaEl = e.target.closest('img');
            if (mediaEl) {
                const src = mediaEl.currentSrc || mediaEl.src || '';
                if (src && isMediaUrl(src) && !src.includes('logo-tamsis') && !src.includes('crown')) {
                    e.preventDefault();
                    const items = collectCardMedia(mediaEl);
                    const idx = Math.max(0, items.findIndex(it => it.src === src));
                    openTamsisLightbox(items.length ? items : [{ src }], idx);
                }
            }
        });

        // ==========================================
        // 2. EDITOR GAMBAR (CROP, CORET, ATUR POSISI)
        // ==========================================
        let edInputEl = null;
        let edOriginalFile = null;
        let edImg = new Image();
        let edMode = 'move';
        let edPosX = 0;
        let edPosY = 0;
        let edScale = 1;
        let edStrokes = [];
        let edActiveStroke = null;
        let edCropRect = { x: 60, y: 40, w: 520, h: 300 };
        let edDragging = false;
        let edStartX = 0;
        let edStartY = 0;

        function setEditorMode(mode) {
            edMode = mode;
            ['move', 'draw', 'crop'].forEach(m => {
                const btn = document.getElementById(`ed-mode-${m}`);
                if (!btn) return;
                if (m === mode) {
                    btn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-extrabold theme-primary';
                } else {
                    btn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-extrabold border theme-border';
                }
            });
            drawEditorCanvas();
        }

        function onScaleChange(val) {
            edScale = parseFloat(val) || 1;
            drawEditorCanvas();
        }

        function clearEditorStrokes() {
            edStrokes = [];
            drawEditorCanvas();
        }

        function resetEditorCrop() {
            const canvas = document.getElementById('tamsis-editor-canvas');
            edScale = 1;
            document.getElementById('ed-scale-slider').value = 1;
            if (edImg.width && edImg.height) {
                const ratio = Math.min(canvas.width / edImg.width, canvas.height / edImg.height);
                const dw = edImg.width * ratio;
                const dh = edImg.height * ratio;
                edPosX = (canvas.width - dw) / 2;
                edPosY = (canvas.height - dh) / 2;
            } else {
                edPosX = 0;
                edPosY = 0;
            }
            edStrokes = [];
            edCropRect = { x: 40, y: 30, w: canvas.width - 80, h: canvas.height - 60 };
            drawEditorCanvas();
        }

        function drawEditorCanvas() {
            const canvas = document.getElementById('tamsis-editor-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            ctx.fillStyle = '#090d16';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            if (edImg.complete && edImg.width > 0) {
                const baseRatio = Math.min(canvas.width / edImg.width, canvas.height / edImg.height);
                const drawW = edImg.width * baseRatio * edScale;
                const drawH = edImg.height * baseRatio * edScale;
                ctx.drawImage(edImg, edPosX, edPosY, drawW, drawH);
            }

            edStrokes.forEach(st => {
                if (!st.points || st.points.length < 2) return;
                ctx.save();
                ctx.strokeStyle = st.color;
                ctx.lineWidth = st.size;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.beginPath();
                ctx.moveTo(st.points[0].x, st.points[0].y);
                for (let i = 1; i < st.points.length; i++) {
                    ctx.lineTo(st.points[i].x, st.points[i].y);
                }
                ctx.stroke();
                ctx.restore();
            });

            ctx.save();
            ctx.fillStyle = 'rgba(0, 0, 0, 0.45)';
            ctx.fillRect(0, 0, canvas.width, edCropRect.y);
            ctx.fillRect(0, edCropRect.y + edCropRect.h, canvas.width, canvas.height - (edCropRect.y + edCropRect.h));
            ctx.fillRect(0, edCropRect.y, edCropRect.x, edCropRect.h);
            ctx.fillRect(edCropRect.x + edCropRect.w, edCropRect.y, canvas.width - (edCropRect.x + edCropRect.w), edCropRect.h);

            ctx.strokeStyle = '#38bdf8';
            ctx.lineWidth = 2;
            ctx.setLineDash([6, 4]);
            ctx.strokeRect(edCropRect.x, edCropRect.y, edCropRect.w, edCropRect.h);
            ctx.restore();
        }

        function getCanvasCoords(e) {
            const canvas = document.getElementById('tamsis-editor-canvas');
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;
            return {
                x: (e.clientX - rect.left) * scaleX,
                y: (e.clientY - rect.top) * scaleY
            };
        }

        function edPointerDown(e) {
            const pt = getCanvasCoords(e);
            edDragging = true;
            edStartX = pt.x;
            edStartY = pt.y;

            if (edMode === 'draw') {
                edActiveStroke = {
                    color: document.getElementById('ed-pen-color').value || '#ef4444',
                    size: parseInt(document.getElementById('ed-pen-size').value || '4', 10),
                    points: [pt]
                };
                edStrokes.push(edActiveStroke);
            } else if (edMode === 'crop') {
                edCropRect = { x: pt.x, y: pt.y, w: 10, h: 10 };
            }
        }

        function edPointerMove(e) {
            if (!edDragging) return;
            const pt = getCanvasCoords(e);
            const canvas = document.getElementById('tamsis-editor-canvas');

            if (edMode === 'move') {
                edPosX += pt.x - edStartX;
                edPosY += pt.y - edStartY;
                edStartX = pt.x;
                edStartY = pt.y;
                drawEditorCanvas();
            } else if (edMode === 'draw' && edActiveStroke) {
                edActiveStroke.points.push(pt);
                drawEditorCanvas();
            } else if (edMode === 'crop') {
                const x1 = Math.max(0, Math.min(edStartX, pt.x));
                const y1 = Math.max(0, Math.min(edStartY, pt.y));
                const x2 = Math.min(canvas.width, Math.max(edStartX, pt.x));
                const y2 = Math.min(canvas.height, Math.max(edStartY, pt.y));
                edCropRect = {
                    x: x1,
                    y: y1,
                    w: Math.max(30, x2 - x1),
                    h: Math.max(30, y2 - y1)
                };
                drawEditorCanvas();
            }
        }

        function edPointerUp() {
            edDragging = false;
            edActiveStroke = null;
        }

        function openImgEditor(inputEl, file) {
            edInputEl = inputEl;
            edOriginalFile = file;
            document.getElementById('ed-file-info').textContent = `File: ${file.name} — Atur posisi, coret, lalu crop sebelum upload.`;

            const reader = new FileReader();
            reader.onload = (ev) => {
                edImg = new Image();
                edImg.onload = () => {
                    setEditorMode('move');
                    resetEditorCrop();
                    const modal = document.getElementById('tamsis-img-editor-modal');
                    modal.classList.remove('hidden');
                    modal.style.display = 'flex';
                };
                edImg.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }

        function closeImgEditor() {
            const modal = document.getElementById('tamsis-img-editor-modal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        function skipEditOriginal() {
            closeImgEditor();
        }

        function applyEditedImageToInput() {
            const canvas = document.getElementById('tamsis-editor-canvas');
            if (!canvas || !edInputEl || !edOriginalFile) {
                closeImgEditor();
                return;
            }

            const outCanvas = document.createElement('canvas');
            outCanvas.width = Math.max(1, Math.round(edCropRect.w));
            outCanvas.height = Math.max(1, Math.round(edCropRect.h));
            const outCtx = outCanvas.getContext('2d');
            outCtx.drawImage(
                canvas,
                edCropRect.x, edCropRect.y, edCropRect.w, edCropRect.h,
                0, 0, outCanvas.width, outCanvas.height
            );

            outCanvas.toBlob((blob) => {
                if (!blob) {
                    closeImgEditor();
                    return;
                }
                const cleanName = edOriginalFile.name.replace(/\.[^.]+$/, '') + '-edited.png';
                const editedFile = new File([blob], cleanName, { type: 'image/png', lastModified: Date.now() });

                try {
                    const dt = new DataTransfer();
                    Array.from(edInputEl.files || []).forEach((f, idx) => {
                        if (f === edOriginalFile || (idx === 0 && f.type.startsWith('image/'))) {
                            dt.items.add(editedFile);
                        } else {
                            dt.items.add(f);
                        }
                    });
                    edInputEl.dataset.skipEditorOnce = '1';
                    edInputEl.files = dt.files;
                } catch (err) {}

                if (typeof playSfx === 'function') playSfx('enter');
                closeImgEditor();
            }, 'image/png', 0.95);
        }

        document.addEventListener('change', (e) => {
            const input = e.target.closest('input[type="file"]');
            if (!input || !input.files || input.files.length === 0) return;

            if (input.dataset.skipEditorOnce === '1') {
                delete input.dataset.skipEditorOnce;
                return;
            }

            const firstImage = Array.from(input.files).find(f => f.type && f.type.startsWith('image/'));
            if (firstImage) {
                openImgEditor(input, firstImage);
            }
        });
    </script>
    <script>
        (function() {
            let isRestoring = false;
            const snapshots = new Map();

            document.addEventListener('DOMContentLoaded', () => {
                const targets = document.querySelectorAll('nav, .jadwal-filter-bar, [data-tamsis-locked="1"]');
                targets.forEach((el, idx) => {
                    if (el.closest('#tamsis-lightbox-modal') || el.closest('#tamsis-img-editor-modal')) return;
                    const key = el.id || `lock_node_${idx}`;
                    el.dataset.lockKey = key;
                    snapshots.set(key, {
                        className: el.className,
                        styleAttr: el.getAttribute('style') || ''
                    });
                });

                const observer = new MutationObserver((mutations) => {
                    if (isRestoring) return;
                    isRestoring = true;
                    try {
                        for (const m of mutations) {
                            const target = m.target.nodeType === 1 ? m.target : m.target.parentElement;
                            const host = target?.closest('[data-lock-key]') || (target?.dataset?.lockKey ? target : null);
                            if (!host) continue;
                            const snap = snapshots.get(host.dataset.lockKey);
                            if (!snap) continue;
                            if (host.className !== snap.className) {
                                host.className = snap.className;
                            }
                            const curStyle = host.getAttribute('style') || '';
                            if (curStyle !== snap.styleAttr) {
                                if (snap.styleAttr) host.setAttribute('style', snap.styleAttr);
                                else host.removeAttribute('style');
                            }
                        }
                    } finally {
                        setTimeout(() => { isRestoring = false; }, 50);
                    }
                });

                if (document.body) {
                    observer.observe(document.body, {
                        attributes: true,
                        attributeFilter: ['style', 'class', 'hidden']
                    });
                }
            });

            document.addEventListener('contextmenu', (e) => {
                if (e.target.closest('input, textarea, [contenteditable="true"], canvas')) return;
                e.preventDefault();
            });

            document.addEventListener('keydown', (e) => {
                const key = (e.key || '').toLowerCase();
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && ['i', 'j', 'c', 'k'].includes(key)) ||
                    (e.ctrlKey && ['u', 's'].includes(key))
                ) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        })();
    </script>
    <style>
        @keyframes tamsisCheckPop {
            0%   { transform: scale(0.35) rotate(-18deg); opacity: 0; }
            25%  { transform: scale(1.15) rotate(0deg); opacity: 1; }
            45%  { transform: scale(0.96); }
            70%  { transform: scale(1.04); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes tamsisCheckRing {
            0%   { transform: scale(0.8); opacity: 0.85; }
            100% { transform: scale(1.75); opacity: 0; }
        }
        #tamsis-10s-checkmark-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            pointer-events: none;
            display: none;
            align-items: center;
            justify-content: center;
        }
        #tamsis-10s-checkmark-overlay.is-active {
            display: flex;
        }
        .tamsis-check-card {
            position: relative;
            background: rgba(15, 23, 42, 0.92);
            border: 2px solid #22c55e;
            box-shadow: 0 0 35px rgba(34, 197, 94, 0.55);
            border-radius: 28px;
            padding: 24px 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            animation: tamsisCheckPop 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .tamsis-check-card.is-fading {
            opacity: 0;
            transform: scale(0.92);
        }
        .tamsis-check-circle {
            position: relative;
            width: 76px;
            height: 76px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 900;
            color: #ffffff;
            box-shadow: 0 0 24px rgba(34, 197, 94, 0.8);
        }
        .tamsis-check-circle::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            border: 3px solid #4ade80;
            animation: tamsisCheckRing 1.25s ease-out infinite;
        }
    </style>

    <div id="tamsis-10s-checkmark-overlay" aria-hidden="true">
        <div class="tamsis-check-card" id="tamsis-10s-checkmark-card">
            <div class="tamsis-check-circle">✓</div>
            <div class="text-sm sm:text-base font-extrabold tracking-wide text-emerald-300">
                Tugas Selesai Dikerjakan!
            </div>
            <div id="tamsis-10s-countdown" class="text-[11px] font-bold opacity-80">
                10s
            </div>
        </div>
    </div>

    <script>
        (function() {
            let checkTimer = null;
            let countdownInterval = null;

            window.triggerTenSecondCheckmark = function() {
                const overlay = document.getElementById('tamsis-10s-checkmark-overlay');
                const card = document.getElementById('tamsis-10s-checkmark-card');
                const cdEl = document.getElementById('tamsis-10s-countdown');
                if (!overlay || !card) return;

                if (checkTimer) clearTimeout(checkTimer);
                if (countdownInterval) clearInterval(countdownInterval);

                card.classList.remove('is-fading');
                overlay.classList.add('is-active');

                let remaining = 10;
                if (cdEl) cdEl.textContent = `${remaining}s`;

                countdownInterval = setInterval(() => {
                    remaining -= 1;
                    if (cdEl && remaining >= 0) {
                        cdEl.textContent = `${remaining}s`;
                    }
                    if (remaining <= 0 && countdownInterval) {
                        clearInterval(countdownInterval);
                    }
                }, 1000);

                checkTimer = setTimeout(() => {
                    card.classList.add('is-fading');
                    setTimeout(() => {
                        overlay.classList.remove('is-active');
                        card.classList.remove('is-fading');
                    }, 420);
                }, 10000);
            };

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('button, a, label');
                if (!btn) return;
                const txt = (btn.innerText || '').trim().toLowerCase();
                const isDoneAction =
                    txt === 'selesai' ||
                    txt.includes('tandai selesai') ||
                    btn.dataset.markDone === '1';

                const isAlreadyDone =
                    btn.classList.contains('completed') ||
                    btn.classList.contains('is-done') ||
                    btn.dataset.completed === '1';

                if (isDoneAction && !isAlreadyDone) {
                    if (typeof playSfx === 'function') playSfx('enter');
                    window.triggerTenSecondCheckmark();
                }
            });
        })();
    </script>
    <script>
        (function() {
            function pad2(n) { return String(n).padStart(2, '0'); }

            function getCreateFormElements() {
                const form = document.querySelector('form[action*="kalender"][method="POST"], form[action*="calendar"][method="POST"]');
                if (!form) return { form: null, wrapper: null, headingEl: null };

                const headingEl = Array.from(document.querySelectorAll('h1, h2, h3, h4, p, div, span')).find(el => {
                    const txt = (el.textContent || '').trim();
                    return (txt === 'Tandai Tanggal Kalender' || txt.toLowerCase().includes('tandai tanggal')) && !el.closest('#edit-calendar-modal');
                });

                let wrapper = form.parentElement;
                if (headingEl && headingEl.parentElement && headingEl.parentElement.contains(form)) {
                    wrapper = headingEl.parentElement;
                }
                return { form, wrapper, headingEl };
            }

            function setCreateFormVisible(visible) {
                const { form, wrapper, headingEl } = getCreateFormElements();
                if (!form) return;

                const disp = visible ? '' : 'none';
                form.style.display = disp;
                if (headingEl && headingEl !== wrapper && !headingEl.textContent.toLowerCase().includes('agenda bulan')) {
                    headingEl.style.display = disp;
                }
                if (wrapper && !(wrapper.textContent || '').includes('Agenda Bulan')) {
                    wrapper.style.display = disp;
                } else if (wrapper) {
                    Array.from(wrapper.children).forEach(child => {
                        const cText = child.textContent || '';
                        if (child === form || (headingEl && (child === headingEl || child.contains(headingEl))) || (!cText.includes('Agenda Bulan') && child.querySelector('input, select, textarea'))) {
                            child.style.display = disp;
                        }
                    });
                }
            }

            function detectMonthYear() {
                const monthMap = {
                    januari: 1, jan: 1, january: 1,
                    februari: 2, feb: 2, february: 2,
                    maret: 3, mar: 3, march: 3,
                    april: 4, apr: 4,
                    mei: 5, may: 5,
                    juni: 6, jun: 6, june: 6,
                    juli: 7, jul: 7, july: 7,
                    agustus: 8, agu: 8, agt: 8, august: 8, aug: 8,
                    september: 9, sep: 9,
                    oktober: 10, okt: 10, october: 10, oct: 10,
                    november: 11, nov: 11,
                    desember: 12, des: 12, december: 12, dec: 12
                };
                const allText = Array.from(document.querySelectorAll('h1, h2, h3, div, span')).map(e => (e.textContent || '').trim());
                for (const t of allText) {
                    const m = t.toLowerCase().match(/\b(januari|january|jan|februari|february|feb|maret|march|mar|april|apr|mei|may|juni|june|jun|juli|july|jul|agustus|august|agu|agt|aug|september|sep|oktober|october|okt|oct|november|nov|desember|december|des|dec)\s+(20\d{2})\b/);
                    if (m) return { month: monthMap[m[1]], year: parseInt(m[2], 10) };
                }
                const now = new Date();
                return { month: now.getMonth() + 1, year: now.getFullYear() };
            }

            document.addEventListener('DOMContentLoaded', () => {
                const isCalPage = window.location.pathname.includes('kalender') || window.location.pathname.includes('calendar') || !!document.querySelector('form[action*="kalender"], form[action*="calendar"]');
                if (!isCalPage) return;

                const hasErr = !!document.querySelector('.text-red-500, .text-red-400, .alert-danger');
                if (!hasErr) {
                    setCreateFormVisible(false);
                }

                const { month, year } = detectMonthYear();
                const dateInp = document.querySelector('input[type="date"][name*="tanggal"], input[type="date"][name*="date"], form[action*="kalender"] input[type="date"], form[action*="calendar"] input[type="date"]');
                const judulInp = document.querySelector('input[name*="judul"], input[name*="title"], form[action*="kalender"] input[type="text"], form[action*="calendar"] input[type="text"]');

                document.querySelectorAll('table td, .calendar-day, [data-date]').forEach(cell => {
                    if (cell.closest('thead')) return;
                    const rawAttr = (cell.getAttribute('data-date') || '').trim();
                    const dayMatch = (cell.innerText || '').trim().match(/^(\d{1,2})\b/);
                    if (!rawAttr && !dayMatch) return;

                    cell.style.cursor = 'pointer';
                    cell.addEventListener('click', (e) => {
                        if (e.target.closest('button, a, form, input, select, textarea')) return;

                        let isoDate = rawAttr;
                        if (!/^\d{4}-\d{2}-\d{2}$/.test(isoDate) && dayMatch) {
                            const dayNum = parseInt(dayMatch[1], 10);
                            isoDate = `${year}-${pad2(month)}-${pad2(dayNum)}`;
                        }

                        setCreateFormVisible(true);
                        if (dateInp && /^\d{4}-\d{2}-\d{2}$/.test(isoDate)) {
                            dateInp.value = isoDate;
                            dateInp.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        if (typeof playSfx === 'function') playSfx('click');
                        if (judulInp) {
                            setTimeout(() => judulInp.focus(), 100);
                        }
                    });
                });
            });
        })();
    </script>
</body>
</html>