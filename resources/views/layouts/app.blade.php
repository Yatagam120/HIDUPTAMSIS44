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
            --bg-gradient: linear-gradient(135deg, #09090b 0%, #18181b 55%, #09090b 100%);
            --bg-card: rgba(24, 24, 27, 0.92);
            --text-main: #fafafa;
            --primary: #6366f1;
            --primary-soft: rgba(99, 102, 241, 0.18);
            --border-color: rgba(161, 161, 170, 0.25);
            --font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }

        /* Tema Gelap */
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
            --bg-card: rgba(24, 24, 27, 0.92);
            --text-main: #fafafa;
            --primary: #6366f1;
            --primary-soft: rgba(99, 102, 241, 0.18);
            --border-color: rgba(161, 161, 170, 0.25);
        }

        /* Tema Terang */
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

        body[data-font="sans"] { --font-family: 'Figtree', system-ui, -apple-system, sans-serif; }
        body[data-font="serif"] { --font-family: Georgia, 'Times New Roman', serif; }
        body[data-font="mono"] { --font-family: 'Fira Code', 'Consolas', monospace; }

        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }

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
        .theme-primary { background-color: var(--primary); color: #ffffff; }
        .theme-soft { background-color: var(--primary-soft); }
        .theme-border { border-color: var(--border-color); }

        /* Minimalist */
        body[data-graphic="minimalist"] {
            --bg-gradient: #0f172a;
            --bg-card: #162033;
            --border-color: rgba(148, 163, 184, 0.22);
        }
        body[data-graphic="minimalist"][data-theme="teal-growth"],
        body[data-graphic="minimalist"][data-theme="creative-spark"],
        body[data-graphic="minimalist"][data-theme="lavender-dream"],
        body[data-graphic="minimalist"][data-theme="soft-berry"],
        body[data-graphic="minimalist"][data-theme="morning-assembly"] {
            --bg-gradient: #f1f5f9;
            --bg-card: #ffffff;
            --border-color: rgba(15, 23, 42, 0.14);
        }
        body[data-graphic="minimalist"] nav.main-tamsis-nav,
        body[data-graphic="minimalist"] .theme-card {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            box-shadow: none !important;
            border-radius: 8px !important;
        }

        /* Style Simple (Default user baru) */
        body[data-graphic="simple"] {
            --bg-gradient: #121215;
            --bg-card: #1c1c21;
        }
        body[data-graphic="simple"],
        body[data-graphic="simple"] *,
        body[data-graphic="simple"] *::before,
        body[data-graphic="simple"] *::after {
            animation: none !important;
            transition: none !important;
        }
        body[data-graphic="simple"] nav.main-tamsis-nav,
        body[data-graphic="simple"] .theme-card {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            box-shadow: none !important;
            border-radius: 10px !important;
        }
        body[data-graphic="simple"] #tamsis-splash {
            display: none !important;
        }

        /* Toggle Animasi */
        body[data-anim="off"] *,
        body[data-anim="off"] *::before,
        body[data-anim="off"] *::after {
            animation: none !important;
            transition: none !important;
        }
        body[data-anim="off"] #tamsis-splash {
            display: none !important;
        }

        .nav-links-wrap {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        nav.main-tamsis-nav {
            position: sticky;
            top: 0;
            z-index: 9990 !important;
            background: rgba(18, 18, 22, 0.97) !important;
            border-bottom: 1px solid var(--border-color);
        }
        body[data-theme="academic-trust"] nav.main-tamsis-nav { background: rgba(10, 22, 44, 0.96) !important; }
        body[data-theme="midnight-scholar"] nav.main-tamsis-nav { background: rgba(19, 17, 48, 0.96) !important; }
        body[data-theme="deep-ocean"] nav.main-tamsis-nav { background: rgba(4, 34, 56, 0.96) !important; }
        body[data-theme="forest-academy"] nav.main-tamsis-nav { background: rgba(5, 46, 26, 0.96) !important; }
        body[data-theme="teal-growth"] nav.main-tamsis-nav,
        body[data-theme="creative-spark"] nav.main-tamsis-nav,
        body[data-theme="lavender-dream"] nav.main-tamsis-nav,
        body[data-theme="soft-berry"] nav.main-tamsis-nav,
        body[data-theme="morning-assembly"] nav.main-tamsis-nav {
            background: rgba(255, 255, 255, 0.96) !important;
        }

        input, select, textarea {
            background-color: rgba(15, 23, 42, 0.45);
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
            background-color: rgba(255, 255, 255, 0.9);
            color: #0f172a;
        }

        /* Badge notifikasi tab sumber pada halaman detail mapel */
        .tab-source-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 11px;
            height: 11px;
            border-radius: 9999px;
            margin-right: 6px;
            vertical-align: middle;
            flex-shrink: 0;
        }
        .tab-source-badge.badge-yellow {
            background-color: #facc15;
            box-shadow: 0 0 8px rgba(250, 204, 21, 0.85);
        }
        .tab-source-badge.badge-red {
            background-color: #ef4444;
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.85);
        }
        .tab-source-badge.badge-blue {
            background-color: #38bdf8;
            box-shadow: 0 0 8px rgba(56, 189, 248, 0.85);
        }

        /* Pill Member Aktif Online (10+) di Jadwal */
        #online-members-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.16);
            border: 1px solid rgba(16, 185, 129, 0.55);
            color: #34d399;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
        }
        #online-members-pill .online-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        /* =========================================================
           PERBAIKAN LAYOUT & FILTER HP (MUAT LAYAR & RAPI)
           ========================================================= */
        @media (max-width: 640px) {
            nav.main-tamsis-nav > div {
                padding: 0.4rem 0.45rem !important;
                gap: 0.35rem !important;
            }
            .nav-links-wrap {
                width: 100%;
                display: flex !important;
                flex-wrap: nowrap !important;
                justify-content: space-between;
                gap: 2px !important;
                overflow-x: hidden !important;
            }
            .nav-btn-anim {
                padding: 4px 4.5px !important;
                font-size: 8.5px !important;
                border-radius: 6px !important;
                letter-spacing: -0.02em;
                white-space: nowrap !important;
            }
            main.page-animate-in {
                padding: 0.5rem 0.35rem !important;
            }

            /* Filter jadwal rapi dalam grid 2 kolom di HP */
            .filter-bar-mobile-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 6px !important;
                width: 100% !important;
            }
            .filter-bar-mobile-grid button,
            .filter-bar-mobile-grid a {
                width: 100% !important;
                justify-content: center !important;
                padding: 6px 8px !important;
                font-size: 11px !important;
                border-radius: 10px !important;
                margin: 0 !important;
            }

            /* Tabel jadwal muat layar HP tanpa huruf terpotong per karakter */
            .timetable-wrap-scroll {
                overflow-x: hidden !important;
                width: 100% !important;
            }
            .timetable-grid {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
                table-layout: fixed !important;
                border-collapse: separate !important;
                border-spacing: 2px !important;
            }
            .timetable-grid th,
            .timetable-grid td {
                font-size: 6px !important;
                padding: 1.5px 1px !important;
                line-height: 1.08 !important;
                vertical-align: middle !important;
                overflow: hidden !important;
            }
            .timetable-grid th:first-child,
            .timetable-grid td:first-child {
                width: 32px !important;
                font-size: 6.5px !important;
                text-align: center !important;
            }
            .timetable-grid a,
            .timetable-grid .subject-box {
                position: relative !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                width: 100% !important;
                min-height: 44px !important;
                padding: 11px 2px 3px 2px !important;
                border-radius: 6px !important;
                font-size: 6.2px !important;
                line-height: 1.12 !important;
                white-space: normal !important;
                word-break: normal !important;
                overflow-wrap: break-word !important;
                hyphens: auto;
            }
            .timetable-grid a span.rounded-full,
            .timetable-grid .subject-box span.rounded-full {
                width: 7px !important;
                height: 7px !important;
                top: 2px !important;
            }
        }
    </style>
</head>
<body class="antialiased" data-theme="mode-gelap" data-font="sans" data-graphic="simple" data-anim="off">
    @php
        // Hitung jumlah tugas & PR yang belum dikerjakan oleh user saat ini
        $pendingTaskCount = 0;
        if (Auth::check() && \Illuminate\Support\Facades\Schema::hasTable('subject_items')) {
            $userId = Auth::id();
            $taskItems = \App\Models\SubjectItem::whereIn('type', ['tugas', 'pr'])->get();
            foreach ($taskItems as $ti) {
                $doneByList = is_array($ti->completed_by ?? null) ? $ti->completed_by : json_decode($ti->completed_by ?? '[]', true);
                $isDone = !empty($ti->is_completed) || (is_array($doneByList) && in_array($userId, $doneByList));
                if (!$isDone) {
                    $pendingTaskCount++;
                }
            }
        }

        // Update aktivitas online user saat ini
        $onlineUsersCount = 0;
        if (Auth::check() && \Illuminate\Support\Facades\Schema::hasColumn('users', 'last_seen_at')) {
            \App\Models\User::where('id', Auth::id())->update(['last_seen_at' => now()]);
            $onlineUsersCount = \App\Models\User::where('last_seen_at', '>=', now()->subMinutes(5))->count();
        } elseif (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
            $onlineUsersCount = \Illuminate\Support\Facades\DB::table('sessions')
                ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
                ->count();
        }
    @endphp

    <!-- Navbar Utama -->
    <nav class="main-tamsis-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[52px] py-1.5 flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('dashboard') }}" onclick="playSfx('click')" class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('images/tamsis.jpeg') }}" onerror="this.src='{{ asset('images/logo-tamsis.png') }}'" alt="Logo Perguruan Tamansiswa" class="w-7 h-7 sm:w-9 sm:h-9 rounded-full object-cover shrink-0 border border-white/30 shadow">
                <div class="leading-tight">
                    <div class="text-[11px] sm:text-sm font-extrabold tracking-wide" style="color: var(--primary);">
                        PELAJAR TAMAN SISWA HEBAT!
                    </div>
                    <div class="text-[9px] opacity-70 hidden md:block">
                        Pelajar Tamsis Harus: N (Niat), J (Jujur), U (Unggul), N (Nasionalis)
                    </div>
                </div>
            </a>

            <div class="nav-links-wrap">
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" onclick="playSfx('enter')"
                       class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-extrabold whitespace-nowrap {{ request()->routeIs('admin.*') ? 'theme-primary shadow-sm' : 'border theme-border' }}"
                       style="{{ request()->routeIs('admin.*') ? '' : 'background-color: var(--primary-soft); color: var(--primary);' }}">AP</a>
                @endif

                <a href="{{ route('dashboard') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('dashboard') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">Jadwal</a>

                <a href="{{ route('tasks.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('tasks.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">
                    {{ $pendingTaskCount > 0 ? "({$pendingTaskCount}) Tugas" : 'List Tugas' }}
                </a>

                <a href="{{ route('calendar.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('calendar.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">Kalender</a>

                <a href="{{ route('siswa.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('siswa.*') || request()->routeIs('students.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">Siswa</a>

                <a href="{{ route('profile.edit') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('profile.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">Profil</a>

                <a href="{{ route('settings') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-3 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('settings') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">Pengaturan</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Halaman -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 page-animate-in">
        {{ $slot }}
    </main>

    <script>
        function applySavedAppearance() {
            // Default user baru/fresh: Mode Gelap + Grafik Simple
            const savedTheme   = localStorage.getItem('app_theme') || 'mode-gelap';
            const savedFont    = localStorage.getItem('app_font') || 'sans';
            const savedGraphic = localStorage.getItem('app_graphic') || 'simple';
            const savedAnim    = savedGraphic === 'simple' ? 'off' : (localStorage.getItem('app_anim') || 'off');

            document.body.setAttribute('data-theme', savedTheme);
            document.body.setAttribute('data-font', savedFont);
            document.body.setAttribute('data-graphic', savedGraphic);
            document.body.setAttribute('data-anim', savedAnim);
        }
        applySavedAppearance();

        // 1. Rapikan bar filter & tabel jadwal di HP
        function enhanceScheduleMobileLayout() {
            document.querySelectorAll('table.timetable-grid, main table').forEach(tbl => {
                if (tbl.closest('.overflow-x-auto')) {
                    tbl.closest('.overflow-x-auto').classList.add('timetable-wrap-scroll');
                }
                if (tbl.querySelector('thead') && tbl.querySelectorAll('tbody tr').length >= 3) {
                    tbl.classList.add('timetable-grid');
                }
            });

            // Temukan baris tombol filter jadwal (Tenggat, Deadline, Selesai, Reset)
            const resetBtn = Array.from(document.querySelectorAll('button, a')).find(el => el.textContent.trim() === 'Reset');
            if (resetBtn && resetBtn.parentElement) {
                const container = resetBtn.parentElement.parentElement && resetBtn.parentElement.parentElement.querySelectorAll('button, a').length >= 3
                    ? resetBtn.parentElement.parentElement
                    : resetBtn.parentElement;
                container.classList.add('filter-bar-mobile-grid');
            }
        }

        // 2. Tampilkan indikator Member Aktif (10+) di pojok atas Jadwal/Dashboard
        function renderOnlineMemberPill() {
            const isDashboard = {{ request()->routeIs('dashboard') ? 'true' : 'false' }};
            const onlineCount = {{ (int) $onlineUsersCount }};
            if (!isDashboard || onlineCount < 10) return;

            const heading = document.querySelector('main h1, main h2');
            if (!heading || document.getElementById('online-members-pill')) return;

            const headerRow = heading.parentElement;
            if (headerRow) {
                headerRow.style.display = 'flex';
                headerRow.style.flexWrap = 'wrap';
                headerRow.style.alignItems = 'center';
                headerRow.style.justifyContent = 'space-between';
                headerRow.style.gap = '8px';

                const pill = document.createElement('div');
                pill.id = 'online-members-pill';
                pill.innerHTML = `<span class="online-dot"></span><span>${onlineCount} Member Aktif</span>`;
                headerRow.appendChild(pill);
            }
        }

        // 3. Sinkronkan tanda/notif kuning-merah jadwal ke tab sumber di dalam halaman mapel
        function syncScheduleMarkersAndSourceTab() {
            const links = document.querySelectorAll('table.timetable-grid a, .subject-box a, a.subject-box');
            links.forEach(el => {
                const href = el.getAttribute('href');
                if (!href || href === '#') return;

                const htmlLower = (el.innerHTML || '').toLowerCase();
                let sourceTab = '';
                let badgeColor = '';

                if (htmlLower.includes('pr')) {
                    sourceTab = 'pr';
                } else if (htmlLower.includes('tugas')) {
                    sourceTab = 'tugas';
                } else if (htmlLower.includes('event')) {
                    sourceTab = 'event';
                } else if (htmlLower.includes('catatan')) {
                    sourceTab = 'catatan';
                }

                if (htmlLower.includes('bg-red-') || htmlLower.includes('deadline')) {
                    badgeColor = 'red';
                    if (!sourceTab) sourceTab = 'tugas';
                } else if (htmlLower.includes('bg-yellow-') || htmlLower.includes('bg-amber-') || htmlLower.includes('tenggat') || el.querySelector('span')) {
                    badgeColor = 'yellow';
                    if (!sourceTab) sourceTab = 'tugas';
                }

                if (sourceTab && !href.includes('tab=')) {
                    const sep = href.includes('?') ? '&' : '?';
                    el.setAttribute('href', `${href}${sep}tab=${sourceTab}${badgeColor ? '&notif=' + badgeColor : ''}`);
                }
            });

            // Jika sedang berada di halaman detail mapel (/mapel/{id}?tab=tugas&notif=yellow)
            const params = new URLSearchParams(window.location.search);
            const activeTab = params.get('tab');
            const notifColor = params.get('notif') || 'yellow';

            if (activeTab) {
                const tabCandidates = Array.from(document.querySelectorAll('main button, main a'));
                const tabBtn = tabCandidates.find(btn => {
                    const txt = btn.textContent.trim().toLowerCase();
                    return txt === activeTab.toLowerCase() || btn.getAttribute('data-tab') === activeTab;
                });

                if (tabBtn) {
                    if (!tabBtn.querySelector('.tab-source-badge')) {
                        const dot = document.createElement('span');
                        dot.className = `tab-source-badge badge-${notifColor}`;
                        dot.title = 'Sumber notifikasi dari jadwal';
                        tabBtn.prepend(dot);
                    }
                    if (typeof tabBtn.click === 'function') {
                        setTimeout(() => tabBtn.click(), 50);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            enhanceScheduleMobileLayout();
            renderOnlineMemberPill();
            syncScheduleMarkersAndSourceTab();
        });

        function playSfx(type = 'click') {
            if (localStorage.getItem('app_sfx') === 'muted') return;
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(type === 'enter' ? 680 : 540, ctx.currentTime);
                gain.gain.setValueAtTime(0.04, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.12);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start();
                osc.stop(ctx.currentTime + 0.13);
            } catch (e) {}
        }
    </script>
</body>
</html>