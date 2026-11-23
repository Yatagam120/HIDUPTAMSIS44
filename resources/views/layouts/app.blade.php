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
            --bg-card: rgba(24, 24, 27, 0.92);
            --text-main: #fafafa;
            --primary: #6366f1;
            --primary-soft: rgba(99, 102, 241, 0.18);
            --border-color: rgba(161, 161, 170, 0.25);
        }

        /* Tema Terang (Gradien) */
        body[data-theme="teal-growth"] {
            --bg-gradient: linear-gradient(135deg, #ecfdf5 0%, #ccfbf1 55%, #e0f2fe 100%);
            --bg-card: rgba(255, 255, 255, 0.94);
            --text-main: #0f172a;
            --primary: #0d9488;
            --primary-soft: rgba(13, 148, 136, 0.14);
            --border-color: rgba(13, 148, 136, 0.28);
        }
        body[data-theme="creative-spark"] {
            --bg-gradient: linear-gradient(135deg, #fdf4ff 0%, #fae8ff 55%, #fce7f3 100%);
            --bg-card: rgba(255, 255, 255, 0.94);
            --text-main: #1e1b4b;
            --primary: #c026d3;
            --primary-soft: rgba(192, 38, 211, 0.12);
            --border-color: rgba(192, 38, 211, 0.26);
        }
        body[data-theme="lavender-dream"] {
            --bg-gradient: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 55%, #f3e8ff 100%);
            --bg-card: rgba(255, 255, 255, 0.94);
            --text-main: #1e1b4b;
            --primary: #4f46e5;
            --primary-soft: rgba(79, 70, 229, 0.12);
            --border-color: rgba(79, 70, 229, 0.25);
        }
        body[data-theme="soft-berry"] {
            --bg-gradient: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 55%, #fce7f3 100%);
            --bg-card: rgba(255, 255, 255, 0.94);
            --text-main: #1f2937;
            --primary: #e11d48;
            --primary-soft: rgba(225, 29, 72, 0.12);
            --border-color: rgba(225, 29, 72, 0.25);
        }
        body[data-theme="morning-assembly"] {
            --bg-gradient: linear-gradient(135deg, #fefce8 0%, #fef3c7 55%, #ffedd5 100%);
            --bg-card: rgba(255, 255, 255, 0.95);
            --text-main: #1c1917;
            --primary: #d97706;
            --primary-soft: rgba(217, 119, 6, 0.14);
            --border-color: rgba(217, 119, 6, 0.28);
        }

        /* Fix #16: Pastikan seluruh teks di Tema Terang (termasuk Kalender & badge) terbaca jelas */
        body[data-theme="teal-growth"],
        body[data-theme="creative-spark"],
        body[data-theme="lavender-dream"],
        body[data-theme="soft-berry"],
        body[data-theme="morning-assembly"] {
            color: var(--text-main) !important;
        }
        body[data-theme="teal-growth"] .theme-card,
        body[data-theme="creative-spark"] .theme-card,
        body[data-theme="lavender-dream"] .theme-card,
        body[data-theme="soft-berry"] .theme-card,
        body[data-theme="morning-assembly"] .theme-card,
        body[data-theme="teal-growth"] .fc,
        body[data-theme="creative-spark"] .fc,
        body[data-theme="lavender-dream"] .fc,
        body[data-theme="soft-berry"] .fc,
        body[data-theme="morning-assembly"] .fc,
        body[data-theme="teal-growth"] .fc-toolbar-title,
        body[data-theme="creative-spark"] .fc-toolbar-title,
        body[data-theme="lavender-dream"] .fc-toolbar-title,
        body[data-theme="soft-berry"] .fc-toolbar-title,
        body[data-theme="morning-assembly"] .fc-toolbar-title,
        body[data-theme="teal-growth"] .fc-daygrid-day-number,
        body[data-theme="creative-spark"] .fc-daygrid-day-number,
        body[data-theme="lavender-dream"] .fc-daygrid-day-number,
        body[data-theme="soft-berry"] .fc-daygrid-day-number,
        body[data-theme="morning-assembly"] .fc-daygrid-day-number,
        body[data-theme="teal-growth"] .fc-col-header-cell-cushion,
        body[data-theme="creative-spark"] .fc-col-header-cell-cushion,
        body[data-theme="lavender-dream"] .fc-col-header-cell-cushion,
        body[data-theme="soft-berry"] .fc-col-header-cell-cushion,
        body[data-theme="morning-assembly"] .fc-col-header-cell-cushion {
            color: #0f172a !important;
        }
        body[data-theme="teal-growth"] .text-white,
        body[data-theme="creative-spark"] .text-white,
        body[data-theme="lavender-dream"] .text-white,
        body[data-theme="soft-berry"] .text-white,
        body[data-theme="morning-assembly"] .text-white {
            color: #0f172a;
        }
        body[data-theme="teal-growth"] .theme-primary,
        body[data-theme="creative-spark"] .theme-primary,
        body[data-theme="lavender-dream"] .theme-primary,
        body[data-theme="soft-berry"] .theme-primary,
        body[data-theme="morning-assembly"] .theme-primary,
        body[data-theme="teal-growth"] .theme-primary *,
        body[data-theme="creative-spark"] .theme-primary *,
        body[data-theme="lavender-dream"] .theme-primary *,
        body[data-theme="soft-berry"] .theme-primary *,
        body[data-theme="morning-assembly"] .theme-primary * {
            color: #ffffff !important;
        }

        /* Gaya Huruf */
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

        /* =========================================================
           3 STYLE GRAFIK UI: LEGACY, MINIMALIST (TEGAS & RELAKS), SIMPLE
           ========================================================= */
        body[data-graphic="legacy"] nav.main-tamsis-nav {
            border-radius: 0;
        }

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
        body[data-graphic="minimalist"] nav.main-tamsis-nav {
            background: var(--bg-card) !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            box-shadow: none !important;
            border-bottom: 1px solid var(--border-color) !important;
        }
        body[data-graphic="minimalist"] .theme-card {
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid var(--border-color) !important;
        }
        body[data-graphic="minimalist"] button,
        body[data-graphic="minimalist"] .nav-btn-anim,
        body[data-graphic="minimalist"] .j-filter-btn,
        body[data-graphic="minimalist"] .setting-pill {
            border-radius: 7px !important;
            box-shadow: none !important;
            font-weight: 600 !important;
            letter-spacing: 0.01em;
        }
        body[data-graphic="minimalist"] input,
        body[data-graphic="minimalist"] select,
        body[data-graphic="minimalist"] textarea {
            border-radius: 7px !important;
            box-shadow: none !important;
        }

        /* Style Simple: Ringan & otomatis matikan animasi UI */
        body[data-graphic="simple"] {
            --bg-gradient: #121215;
            --bg-card: #1c1c21;
        }
        body[data-graphic="simple"][data-theme="teal-growth"],
        body[data-graphic="simple"][data-theme="creative-spark"],
        body[data-graphic="simple"][data-theme="lavender-dream"],
        body[data-graphic="simple"][data-theme="soft-berry"],
        body[data-graphic="simple"][data-theme="morning-assembly"] {
            --bg-gradient: #f8fafc;
            --bg-card: #ffffff;
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

        /* Toggle Animasi (Aktif / Mati) */
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
            gap: 5px;
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
            background-color: rgba(255, 255, 255, 0.94);
            color: #0f172a;
        }

        nav.main-tamsis-nav {
            position: sticky;
            top: 0;
            z-index: 9990 !important;
            background: rgba(18, 18, 22, 0.97) !important;
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
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
            background: rgba(255, 255, 255, 0.97) !important;
            color: #0f172a !important;
        }

        main.page-animate-in {
            width: 100%;
            box-sizing: border-box;
        }

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

        /* Status Active Member khusus Dashboard (#11) */
        #online-members-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 11px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            border-width: 1px;
        }
        #online-members-pill.status-green {
            background: rgba(16, 185, 129, 0.18);
            border-color: rgba(16, 185, 129, 0.55);
            color: #10b981;
        }
        #online-members-pill.status-yellow {
            background: #facc15;
            border-color: #ca8a04;
            color: #0f172a !important;
        }
        #online-members-pill.status-black {
            background: #09090b;
            border-color: #3f3f46;
            color: #ffffff !important;
        }
        #online-members-pill .online-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
        }

        /* Preview Foto Global (#4) */
        img:not(.no-preview) {
            cursor: zoom-in;
        }

        /* Koreksi khusus Desktop: agar "Ketamansiswaan" tidak terpotong huruf n di ujung */
        @media (min-width: 1025px) {
            .timetable-grid a,
            .timetable-grid .subject-box {
                padding-left: 4px !important;
                padding-right: 4px !important;
                overflow: visible !important;
            }
            .mobile-type-tag {
                display: none !important;
            }
        }

                /* =========================================================
           KHUSUS MOBILE (<= 640px): BERSIH, LEGA, ANTI-PUSING
           ========================================================= */
        @media (max-width: 640px) {
            nav.main-tamsis-nav > div {
                padding: 0.45rem 0.65rem !important;
                gap: 0.45rem !important;
            }

            /* Navbar 1 baris rapi dengan horizontal scroll halus (tidak patah 2 baris) */
            .nav-links-wrap {
                width: 100%;
                display: flex !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: flex-start !important;
                gap: 6px !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 2px;
            }
            .nav-links-wrap::-webkit-scrollbar {
                display: none;
            }
            .nav-btn-anim {
                padding: 6px 11px !important;
                font-size: 11px !important;
                border-radius: 9999px !important;
                letter-spacing: 0 !important;
                white-space: nowrap !important;
                flex-shrink: 0 !important;
            }

            /* Ruang konten & tipografi proporsional di HP */
            main.page-animate-in {
                padding: 0.65rem 0.6rem 1.5rem 0.6rem !important;
            }
            main.page-animate-in > div {
                gap: 0.75rem !important;
            }
            main.page-animate-in .theme-card {
                padding: 0.85rem !important;
                border-radius: 14px !important;
            }
            main.page-animate-in h1 {
                font-size: 1.05rem !important;
                line-height: 1.3 !important;
            }
            main.page-animate-in h2 {
                font-size: 0.95rem !important;
                line-height: 1.3 !important;
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
                padding: 7px 8px !important;
                font-size: 11px !important;
                border-radius: 10px !important;
                margin: 0 !important;
            }

            /* Tabel Jadwal HP: Horizontal swipe lega + kolom Hari sticky di kiri */
            .timetable-wrap-scroll {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                width: 100% !important;
                border-radius: 10px;
            }
            .timetable-grid {
                width: max-content !important;
                min-width: 620px !important;
                table-layout: fixed !important;
                border-collapse: separate !important;
                border-spacing: 3px !important;
            }
            .timetable-grid th,
            .timetable-grid td {
                font-size: 9.5px !important;
                padding: 2px !important;
                line-height: 1.2 !important;
                vertical-align: middle !important;
            }
            .timetable-grid th:first-child,
            .timetable-grid td:first-child {
                position: sticky !important;
                left: 0 !important;
                z-index: 10 !important;
                width: 52px !important;
                min-width: 52px !important;
                background: #141419 !important;
                font-size: 9.5px !important;
                font-weight: 800 !important;
                text-align: center !important;
                border-radius: 6px;
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
                min-height: 46px !important;
                height: 46px !important;
                padding: 6px 4px !important;
                gap: 3px !important;
                border-radius: 8px !important;
                font-size: 10px !important;
                font-weight: 800 !important;
                line-height: 1.15 !important;
                white-space: nowrap !important;
            }
            .timetable-grid a > *:not(span.mobile-notif-dot):not(span.mobile-label-only):not(span.mobile-type-tag),
            .timetable-grid .subject-box > *:not(span.mobile-notif-dot):not(span.mobile-label-only):not(span.mobile-type-tag) {
                display: none !important;
            }
            .timetable-grid a span.mobile-label-only,
            .timetable-grid .subject-box span.mobile-label-only {
                display: block !important;
                width: 100% !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                white-space: nowrap !important;
                text-align: center !important;
                font-size: 10px !important;
            }
            .mobile-type-tag {
                display: inline-block !important;
                font-size: 7.5px !important;
                font-weight: 800 !important;
                line-height: 1 !important;
                padding: 1.5px 5px !important;
                border-radius: 4px !important;
                background: rgba(250, 204, 21, 0.22);
                color: #fde047;
                border: 0.5px solid rgba(250, 204, 21, 0.55);
            }
            .timetable-grid a span.rounded-full,
            .timetable-grid .subject-box span.rounded-full {
                position: absolute !important;
                top: 4px !important;
                right: 4px !important;
                margin: 0 !important;
                width: 6px !important;
                height: 6px !important;
                min-width: 6px !important;
                min-height: 6px !important;
                padding: 0 !important;
                z-index: 5 !important;
            }
        }
            /* Navbar Desktop & Laptop: Anti-meluber untuk teks panjang (Bahasa Rusia) */
        @media (min-width: 641px) {
            nav.main-tamsis-nav .nav-links-wrap {
                display: flex !important;
                flex-wrap: wrap !important;
                align-items: center !important;
                gap: 4px !important;
            }
            nav.main-tamsis-nav .nav-btn-anim {
                padding: 5px 9px !important;
                font-size: 11.5px !important;
                white-space: nowrap !important;
                letter-spacing: 0 !important;
            }
        }
        @media (max-width: 640px) {
            .timetable-grid {
                min-width: 680px !important;
                border-spacing: 4px !important;
            }
            .timetable-grid a,
            .timetable-grid .subject-box {
                min-height: 52px !important;
                height: 52px !important;
                padding: 6px 5px !important;
                font-size: 10.5px !important;
            }
        }
            /* Legacy & Minimalist: Animasi hanya berlaku di Navbar saja */
        html[data-graphic="legacy"][data-anim="on"] main.page-animate-in,
        html[data-graphic="minimalist"][data-anim="on"] main.page-animate-in,
        html[data-graphic="legacy"][data-anim="on"] main .theme-card,
        html[data-graphic="minimalist"][data-anim="on"] main .theme-card {
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }
        html[data-graphic="legacy"][data-anim="on"] nav.main-tamsis-nav .nav-btn-anim,
        html[data-graphic="minimalist"][data-anim="on"] nav.main-tamsis-nav .nav-btn-anim {
            transition: transform 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease !important;
        }
        html[data-graphic="legacy"][data-anim="on"] nav.main-tamsis-nav .nav-btn-anim:hover,
        html[data-graphic="minimalist"][data-anim="on"] nav.main-tamsis-nav .nav-btn-anim:hover {
            transform: translateY(-2px) scale(1.03) !important;
        }
                    /* Jadwal HP: FIT 1 layar utuh tanpa geser, rapi & nama hari (Senin-Jumat) utuh */
        @media (max-width: 640px) {
            .timetable-wrap-scroll,
            div:has(> table.timetable-grid) {
                overflow-x: hidden !important;
                width: 100% !important;
            }
            table.timetable-grid {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
                table-layout: fixed !important;
                border-collapse: separate !important;
                border-spacing: 2px !important;
            }
            table.timetable-grid th,
            table.timetable-grid td {
                min-width: 0 !important;
                padding: 1px !important;
                font-size: 6.5px !important;
                line-height: 1.1 !important;
                vertical-align: middle !important;
                overflow: hidden !important;
            }
            table.timetable-grid th:first-child,
            table.timetable-grid td:first-child {
                position: static !important;
                width: 34px !important;
                min-width: 34px !important;
                max-width: 34px !important;
                padding: 2px 1px !important;
                font-size: 7.5px !important;
                font-weight: 800 !important;
                text-align: center !important;
                white-space: nowrap !important;
                letter-spacing: -0.02em !important;
            }
            table.timetable-grid a,
            table.timetable-grid .subject-box {
                min-width: 0 !important;
                width: 100% !important;
                min-height: 36px !important;
                height: 36px !important;
                padding: 2px 1px !important;
                gap: 1.5px !important;
                border-radius: 5px !important;
                font-size: 7.2px !important;
                font-weight: 800 !important;
                line-height: 1.05 !important;
            }
            table.timetable-grid a span.mobile-label-only,
            table.timetable-grid .subject-box span.mobile-label-only {
                display: block !important;
                width: 100% !important;
                font-size: 7.2px !important;
                text-align: center !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                white-space: nowrap !important;
            }
            .mobile-type-tag {
                font-size: 5.5px !important;
                padding: 0.5px 2.5px !important;
                border-radius: 3px !important;
            }
            table.timetable-grid a span.rounded-full,
            table.timetable-grid .subject-box span.rounded-full {
                top: 2px !important;
                right: 2px !important;
                width: 4.5px !important;
                height: 4.5px !important;
                min-width: 4.5px !important;
                min-height: 4.5px !important;
            }
        }
    </style>
</head>
<body class="antialiased" data-theme="mode-gelap" data-font="sans" data-graphic="simple" data-anim="off">
    @php
        $authUser = \Illuminate\Support\Facades\Auth::user();
        $rawRole = strtolower(trim((string) ($authUser->role ?? $authUser->jabatan ?? 'siswa')));
        $isHighAuth = in_array($rawRole, ['admin', 'guru', 'ppts', 'ketua_kelas', 'ketua kelas', 'wakil_ketua_kelas', 'wakil ketua kelas'], true);
        // #15: Komok hanya untuk Ketua Kelas, Wakil Ketua Kelas, PPTS, dan Admin (Guru, Murid, Ex-PPTS dilarang)
        $canAccessKomok = in_array($rawRole, ['admin', 'ppts', 'ketua_kelas', 'ketua kelas', 'wakil_ketua_kelas', 'wakil ketua kelas'], true);

        $pendingTaskCount = 0;
        $navNotifs = collect();

        if ($authUser) {
            try {
                $targetTbl = \Illuminate\Support\Facades\Schema::hasTable('subject_posts')
                    ? 'subject_posts'
                    : (\Illuminate\Support\Facades\Schema::hasTable('subject_items') ? 'subject_items' : null);

                if ($targetTbl) {
                    $userId = (int) $authUser->id;
                    $subjectsMap = \App\Models\Subject::all()->keyBy('id');
                    $allItems = \Illuminate\Support\Facades\DB::table($targetTbl)->orderByDesc('id')->get();

                    foreach ($allItems as $ti) {
                        $tType = strtolower(trim((string) ($ti->category ?? $ti->kategori ?? $ti->type ?? $ti->jenis ?? 'catatan')));
                        $tStatus = $ti->status ?? 'approved';
                        $doneByList = is_array($ti->completed_by ?? null)
                            ? $ti->completed_by
                            : (json_decode((string) ($ti->completed_by ?? '[]'), true) ?: []);
                        $isDone = !empty($ti->is_completed) || in_array($userId, array_map('intval', $doneByList), true);
                        $subjObj = $subjectsMap->get($ti->subject_id);
                        $subjName = $subjObj->kode_mapel ?? $subjObj->nama_mapel ?? 'Mapel';

                        if ($isHighAuth && $tStatus === 'pending') {
                            $navNotifs->push([
                                'title' => 'Menunggu Verifikasi: ' . ($ti->title ?? $ti->judul ?? 'Postingan'),
                                'sub'   => $subjName . ' • ' . strtoupper($tType),
                                'url'   => route('subjects.show', ['subject' => $ti->subject_id, 'tab' => $tType]),
                                'dot'   => '#38bdf8',
                            ]);
                        }

                        $isRecentPost = false;
                        if (!empty($ti->created_at)) {
                            try {
                                $isRecentPost = \Carbon\Carbon::parse($ti->created_at)->greaterThanOrEqualTo(now()->subDays(7));
                            } catch (\Throwable $e) {}
                        }

                        if ($tStatus === 'approved' && in_array($tType, ['catatan', 'tugas', 'pr', 'event'], true) && (!$isDone || ($tType === 'catatan' && $isRecentPost))) {
                            if (in_array($tType, ['tugas', 'pr'], true) && !$isDone) {
                                $pendingTaskCount++;
                            }
                            $dueVal = $ti->due_date ?? $ti->deadline ?? $ti->tanggal_deadline ?? null;
                            $dotColor = $tType === 'catatan' ? '#38bdf8' : '#10b981';
                            $subLabel = $subjName . ' • ' . strtoupper($tType);
                            $titlePrefix = strtoupper($tType) . ' Baru: ';

                            if ($dueVal) {
                                try {
                                    $diff = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($dueVal)->startOfDay(), false);
                                    $subLabel .= ' • ' . \Carbon\Carbon::parse($dueVal)->format('d M Y');
                                    if ($diff < 0) {
                                        $dotColor = '#ef4444';
                                        $titlePrefix = 'LEWAT TENGGAT: ';
                                    } elseif ($diff <= 2) {
                                        $dotColor = '#facc15';
                                        $titlePrefix = 'Tenggat Dekat: ';
                                    }
                                } catch (\Throwable $e) {}
                            }

                            $creatorUser = isset($ti->user_id) ? \App\Models\User::find($ti->user_id) : null;
                            $creatorName = $creatorUser ? $creatorUser->name : 'Siswa';
                            $navNotifs->push([
                                'title' => $titlePrefix . ($ti->title ?? $ti->judul ?? 'Tugas'),
                                'sub'   => $subLabel . ' • Oleh ' . $creatorName,
                                'url'   => route('subjects.show', ['subject' => $ti->subject_id, 'tab' => $tType]),
                                'dot'   => $dotColor,
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                $pendingTaskCount = 0;
            }
        }

        // #11: Hitung Active Member untuk Dashboard
        $onlineUsersCount = 0;
        try {
            if ($authUser && \Illuminate\Support\Facades\Schema::hasColumn('users', 'last_seen_at')) {
                \App\Models\User::where('id', $authUser->id)->update(['last_seen_at' => now()]);
                $onlineUsersCount = \App\Models\User::where('last_seen_at', '>=', now()->subMinutes(5))->count();
            } elseif (\Illuminate\Support\Facades\Schema::hasTable('sessions')) {
                $onlineUsersCount = \Illuminate\Support\Facades\DB::table('sessions')
                    ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
                    ->count();
            }
        } catch (\Throwable $e) {
            $onlineUsersCount = 0;
        }
    @endphp

    <!-- Splash Screen Kilat -->
    <div id="tamsis-splash">
        <img src="{{ asset('images/logo-tamsis.png') }}"
             onerror="this.style.display='none'"
             alt="Logo Tamsis"
             class="no-preview"
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
        if (sessionStorage.getItem('tamsis_booted') || localStorage.getItem('app_anim') === 'off' || (localStorage.getItem('app_graphic') || 'simple') === 'simple') {
            const sp = document.getElementById('tamsis-splash');
            if (sp) sp.style.display = 'none';
        }
    </script>

    <!-- Navbar Utama -->
    <nav class="main-tamsis-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[52px] py-1.5 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center justify-between w-full lg:w-auto gap-2">
                <a href="{{ route('dashboard') }}" onclick="playSfx('click')" class="flex items-center gap-2 shrink-0" style="gap:8px;">
                    <img src="{{ asset('images/tamsis.jpeg') }}" onerror="this.src='{{ asset('images/logo-tamsis.png') }}'" alt="Logo Perguruan Tamansiswa" class="no-preview w-7 h-7 sm:w-9 sm:h-9 rounded-full object-cover shrink-0 border border-white/30 shadow">
                    <div class="leading-tight">
                        <div class="text-[11px] sm:text-sm font-extrabold tracking-wide" style="color: var(--primary);">
                            PELAJAR TAMAN SISWA HEBAT!
                        </div>
                        <div class="text-[9px] opacity-70 hidden md:block">
                            Pelajar Tamsis Harus: N (Niat), J (Jujur), U (Unggul), N (Nasionalis)
                        </div>
                    </div>
                </a>

                <!-- Tombol Simbol Notif Berfungsi di HP & Laptop (#9) -->
                <div class="relative lg:hidden">
                    <button type="button"
                            onclick="toggleNavNotifBox(); playSfx('click');"
                            aria-label="Notifikasi"
                            class="relative px-2.5 py-1.5 rounded-lg border theme-border text-xs font-extrabold"
                            style="background-color: var(--primary-soft);">
                        🔔
                        @if($navNotifs->count() > 0)
                            <span class="absolute -top-1 -right-1 px-1 min-w-[15px] h-[15px] rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center">
                                {{ $navNotifs->count() }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>

            <div class="nav-links-wrap">
                @if($isHighAuth && \Illuminate\Support\Facades\Route::has('admin.users'))
                    <a href="{{ route('admin.users') }}" onclick="playSfx('enter')"
                       class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-extrabold whitespace-nowrap {{ request()->routeIs('admin.*') ? 'theme-primary shadow-sm' : 'border theme-border' }}"
                       style="{{ request()->routeIs('admin.*') ? '' : 'background-color: var(--primary-soft); color: var(--primary);' }}"
                       data-i18n="nav_ap">AP</a>
                @endif

                <a href="{{ route('dashboard') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('dashboard') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_jadwal">Jadwal</a>

                <a href="{{ route('tasks.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('tasks.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}">
                    {{ $pendingTaskCount > 0 ? "({$pendingTaskCount}) Tugas" : 'List Tugas' }}
                </a>

                <a href="{{ route('calendar.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('calendar.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_kalender">Kalender</a>

                <a href="{{ route('siswa.index') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('siswa.*') || request()->routeIs('students.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_siswa">Siswa</a>

                @if(\Illuminate\Support\Facades\Route::has('teachers.phone'))
                    <a href="{{ route('teachers.phone') }}" onclick="playSfx('click')"
                       class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('teachers.phone') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                       data-i18n="nav_nmr_guru">Nmr Guru</a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('materials.index'))
                    <a href="{{ route('materials.index') }}" onclick="playSfx('click')"
                       class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('materials.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                       data-i18n="nav_materi">Materi</a>
                @endif

                @if($canAccessKomok && \Illuminate\Support\Facades\Route::has('komok.index'))
                    <a href="{{ route('komok.index') }}" onclick="playSfx('click')"
                       class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('komok.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                       data-i18n="nav_komok">Komok</a>
                @endif

                @if(\Illuminate\Support\Facades\Route::has('practice.index'))
                    <a href="{{ route('practice.index') }}" onclick="playSfx('click')"
                       class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('practice.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                       data-i18n="nav_latihan">Latihan</a>
                @endif

                <a href="{{ route('profile.edit') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('profile.*') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_profile">Profil</a>

                <a href="{{ route('settings') }}" onclick="playSfx('click')"
                   class="nav-btn-anim px-2.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap {{ request()->routeIs('settings') ? 'theme-primary shadow-sm' : 'hover:opacity-85' }}"
                   data-i18n="nav_pengaturan">Pengaturan</a>

                <!-- Tombol Simbol Notif Desktop (#9) -->
                <div class="relative hidden lg:block">
                    <button type="button"
                            onclick="toggleNavNotifBox(); playSfx('click');"
                            aria-label="Notifikasi"
                            class="relative nav-btn-anim px-2.5 py-1.5 rounded-lg border theme-border text-xs font-extrabold"
                            style="background-color: var(--primary-soft);">
                        🔔
                        @if($navNotifs->count() > 0)
                            <span class="absolute -top-1 -right-1 px-1 min-w-[16px] h-[16px] rounded-full bg-red-500 text-white text-[9px] font-extrabold flex items-center justify-center">
                                {{ $navNotifs->count() }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Dropdown Notifikasi (HP & Laptop) -->
        <div id="nav-notif-dropdown"
             class="hidden fixed right-2 sm:right-6 left-2 sm:left-auto top-14 sm:w-80 theme-card border theme-border rounded-2xl shadow-2xl p-3 z-[9995] space-y-2 max-h-[75vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b theme-border pb-2">
                <span class="text-xs font-extrabold">🔔 Notifikasi ({{ $navNotifs->count() }})</span>
                <button type="button" onclick="toggleNavNotifBox()" class="px-2 py-0.5 rounded text-xs font-bold border theme-border">✕</button>
            </div>
            @forelse($navNotifs as $notifItem)
                <a href="{{ $notifItem['url'] }}" class="block p-2.5 rounded-xl theme-soft border theme-border hover:opacity-90">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $notifItem['dot'] }};"></span>
                        <span class="text-xs font-extrabold line-clamp-1">{{ $notifItem['title'] }}</span>
                    </div>
                    <div class="text-[10px] opacity-75 pl-4 mt-0.5">{{ $notifItem['sub'] }}</div>
                </a>
            @empty
                <div class="py-4 text-center text-xs opacity-70">Tidak ada notifikasi tenggat atau pengajuan baru.</div>
            @endforelse
        </div>
    </nav>

    <!-- Konten Utama Halaman -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 page-animate-in">
        {{ $slot }}
    </main>

    <!-- Global Image Lightbox Preview (#4: Preview foto untuk apa pun) -->
    <div id="global-photo-preview-modal"
         onclick="closePhotoPreview()"
         class="fixed inset-0 z-[99998] hidden items-center justify-center bg-black/85 p-4">
        <button type="button"
                onclick="closePhotoPreview()"
                class="fixed top-4 right-4 px-3 py-1.5 rounded-xl bg-white/15 text-white text-xs font-extrabold border border-white/30">
            ✕ Tutup
        </button>
        <img id="global-photo-preview-img"
             src=""
             alt="Preview Foto"
             onclick="event.stopPropagation()"
             class="no-preview max-w-full max-h-[88vh] rounded-2xl shadow-2xl border border-white/25 object-contain">
    </div>

    <script>
        function toggleNavNotifBox() {
            const box = document.getElementById('nav-notif-dropdown');
            if (box) box.classList.toggle('hidden');
        }

        function openPhotoPreview(src) {
            if (!src) return;
            const modal = document.getElementById('global-photo-preview-modal');
            const img = document.getElementById('global-photo-preview-img');
            img.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePhotoPreview() {
            const modal = document.getElementById('global-photo-preview-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('click', function (e) {
            const imgEl = e.target.closest('img');
            if (imgEl && !imgEl.classList.contains('no-preview') && !imgEl.closest('#global-photo-preview-modal')) {
                openPhotoPreview(imgEl.currentSrc || imgEl.src);
            }
        });

        function applySavedAppearance() {
            const savedTheme   = localStorage.getItem('app_theme') || 'mode-gelap';
            const savedFont    = localStorage.getItem('app_font') || 'sans';
            const savedGraphic = localStorage.getItem('app_graphic') || 'simple';
            const savedAnim    = savedGraphic === 'simple' ? 'off' : (localStorage.getItem('app_anim') || 'off');

            document.body.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.body.setAttribute('data-font', savedFont);
            document.body.setAttribute('data-graphic', savedGraphic);
            document.body.setAttribute('data-anim', savedAnim);
        }
        applySavedAppearance();

        // Singkatan mapel khusus MOBILE (<= 640px) agar persis seperti jadwal asli; DESKTOP tidak disentuh
        function abbreviateMobileSubject(rawText) {
            const cleaned = rawText.replace(/\s+/g, ' ').trim();
            if (!cleaned) return cleaned;

            const lower = cleaned.toLowerCase();
            const mapelDict = [
                ['muatan bahasa jepang', 'MBJ(J)'],
                ['bahasa jepang', 'MBJ(J)'],
                ['mbj', 'MBJ(J)'],
                ['jepa', 'MBJ(J)'],
                ['pendidikan pancasila', 'PP'],
                ['ppkn', 'PP'],
                ['bahasa inggris', 'B.Ing'],
                ['b.ing', 'B.Ing'],
                ['bimbingan konseling', 'BK'],
                ['bahasa indonesia', 'BI'],
                ['b.ind', 'BI'],
                ['matematika', 'MTK'],
                ['kreativitas & desain interaktif', 'KDI'],
                ['kreativitas dan desain interaktif', 'KDI'],
                ['pendidikan jasmani', 'Penjas'],
                ['pjok', 'Penjas'],
                ['ketamansiswaan', 'KTS'],
                ['kts', 'KTS'],
                ['samsung institute tech', 'STI'],
                ['sistem teknologi informasi', 'STI'],
                ['pemrograman lanjut', 'PL(RPL1)'],
                ['pml', 'PL(RPL1)'],
                ['sejarah indonesia', 'SI'],
                ['sej', 'SI'],
                ['kewirausahaan', 'KWH'],
                ['kwu', 'KWH'],
                ['pendidikan agama islam', 'PAI'],
            ];

            for (const [key, abbr] of mapelDict) {
                if (lower.includes(key)) {
                    return abbr;
                }
            }

            return cleaned.length > 6 ? cleaned.slice(0, 5).toUpperCase() : cleaned;
        }

        @php
            $mobileSubjectNotifMap = [];
            if (isset($allItems) && $authUser) {
                foreach ($allItems as $mi) {
                    if (($mi->status ?? 'approved') !== 'approved') continue;
                    $mType = strtolower(trim((string) ($mi->category ?? $mi->kategori ?? $mi->type ?? $mi->jenis ?? 'catatan')));
                    $mDoneArr = is_array($mi->completed_by ?? null)
                        ? $mi->completed_by
                        : (json_decode((string) ($mi->completed_by ?? '[]'), true) ?: []);
                    $mIsDone = in_array((int) $authUser->id, array_map('intval', $mDoneArr), true);
                    if ($mIsDone && in_array($mType, ['tugas', 'pr'], true)) continue;

                    $sid = (string) $mi->subject_id;
                    $tagMap = ['pr' => 'PR', 'tugas' => 'TGS', 'event' => 'EVT', 'catatan' => 'CTT'];
                    $prioMap = ['PR' => 4, 'TGS' => 3, 'EVT' => 2, 'CTT' => 1];
                    $candTag = $tagMap[$mType] ?? '';
                    if ($candTag) {
                        $curTag = $mobileSubjectNotifMap[$sid]['tag'] ?? '';
                        if (($prioMap[$candTag] ?? 0) >= ($prioMap[$curTag] ?? 0)) {
                            $dotHex = $candTag === 'CTT' ? '#38bdf8' : '#facc15';
                            $dueM = $mi->due_date ?? $mi->deadline ?? null;
                            if ($dueM) {
                                try {
                                    if (now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($dueM)->startOfDay(), false) < 0) {
                                        $dotHex = '#ef4444';
                                    }
                                } catch (\Throwable $e) {}
                            }
                            $mobileSubjectNotifMap[$sid] = ['tag' => $candTag, 'dot' => $dotHex, 'tab' => $mType];
                        }
                    }
                }
            }
        @endphp
        const SERVER_SUBJECT_NOTIFS = @json($mobileSubjectNotifMap);

        function detectMobileTypeTag(rawHtml, href) {
            const matchId = (href || '').match(/\/(?:mapel|subject)\/(\d+)/i);
            if (matchId && typeof SERVER_SUBJECT_NOTIFS !== 'undefined' && SERVER_SUBJECT_NOTIFS[matchId[1]]) {
                return SERVER_SUBJECT_NOTIFS[matchId[1]].tag;
            }
            return '';
        }

        function shortenSubjectsForMobile() {
            if (window.innerWidth > 640) return;

            document.querySelectorAll('table.timetable-grid a, table.timetable-grid .subject-box').forEach(box => {
                const dotSpans = Array.from(box.querySelectorAll('span.rounded-full'));
                dotSpans.forEach(d => d.classList.add('mobile-notif-dot'));

                if (!box.dataset.fullLabel) {
                    const clone = box.cloneNode(true);
                    clone.querySelectorAll('span.rounded-full').forEach(d => d.remove());
                    box.dataset.fullLabel = (clone.textContent || '').replace(/\s+/g, ' ').trim();
                }

                if (!box.dataset.fullLabel) return;

                const shortCode = abbreviateMobileSubject(box.dataset.fullLabel);
                let labelSpan = box.querySelector('span.mobile-label-only');
                if (!labelSpan) {
                    labelSpan = document.createElement('span');
                    labelSpan.className = 'mobile-label-only';
                    box.appendChild(labelSpan);
                }
                labelSpan.textContent = shortCode;

                const hrefVal = box.getAttribute('href') || '';
                const matchSid = hrefVal.match(/\/(?:mapel|subject)\/(\d+)/i);
                const serverInfo = matchSid ? SERVER_SUBJECT_NOTIFS[matchSid[1]] : null;
                const typeTag = serverInfo ? serverInfo.tag : detectMobileTypeTag(box.dataset.rawHtml || box.innerHTML, hrefVal);

                let tagSpan = box.querySelector('span.mobile-type-tag');
                if (typeTag) {
                    if (!tagSpan) {
                        tagSpan = document.createElement('span');
                        tagSpan.className = 'mobile-type-tag';
                        box.appendChild(tagSpan);
                    }
                    tagSpan.textContent = typeTag;

                    if (!box.querySelector('span.rounded-full')) {
                        const autoDot = document.createElement('span');
                        autoDot.className = 'rounded-full mobile-notif-dot';
                        autoDot.style.backgroundColor = serverInfo ? serverInfo.dot : '#facc15';
                        box.appendChild(autoDot);
                    }
                } else if (tagSpan) {
                    tagSpan.remove();
                }
            });
        }

        function enhanceScheduleMobileLayout() {
            document.querySelectorAll('table.timetable-grid, main table').forEach(tbl => {
                if (tbl.closest('.overflow-x-auto')) {
                    tbl.closest('.overflow-x-auto').classList.add('timetable-wrap-scroll');
                }
                if (tbl.querySelector('thead') && tbl.querySelectorAll('tbody tr').length >= 3) {
                    tbl.classList.add('timetable-grid');
                }
            });

            const resetBtn = Array.from(document.querySelectorAll('button, a')).find(el => el.textContent.trim() === 'Reset');
            if (resetBtn && resetBtn.parentElement) {
                const container = resetBtn.parentElement.parentElement && resetBtn.parentElement.parentElement.querySelectorAll('button, a').length >= 3
                    ? resetBtn.parentElement.parentElement
                    : resetBtn.parentElement;
                container.classList.add('filter-bar-mobile-grid');
            }

            shortenSubjectsForMobile();
        }

        // #11: Status Active Member HANYA di Dashboard (0 = hitam, <2 = kuning, >=2 = hijau)
        function renderOnlineMemberPill() {
            const isDashboard = {{ request()->routeIs('dashboard') ? 'true' : 'false' }};
            const onlineCount = {{ (int) $onlineUsersCount }};
            if (!isDashboard) return;

            const heading = document.querySelector('main h1, main h2');
            if (!heading || document.getElementById('online-members-pill')) return;

            let statusClass = 'status-green';
            let dotColor = '#10b981';
            if (onlineCount === 0) {
                statusClass = 'status-black';
                dotColor = '#71717a';
            } else if (onlineCount < 2) {
                statusClass = 'status-yellow';
                dotColor = '#ca8a04';
            }

            const headerRow = heading.parentElement;
            if (headerRow) {
                headerRow.style.display = 'flex';
                headerRow.style.flexWrap = 'wrap';
                headerRow.style.alignItems = 'center';
                headerRow.style.justifyContent = 'space-between';
                headerRow.style.gap = '8px';

                const pill = document.createElement('div');
                pill.id = 'online-members-pill';
                pill.className = statusClass;
                pill.innerHTML = `<span class="online-dot" style="background:${dotColor};"></span><span>${onlineCount} Member Aktif</span>`;
                headerRow.appendChild(pill);
            }
        }

        function syncScheduleMarkersAndSourceTab() {
            const hasServerMap = typeof SERVER_SUBJECT_NOTIFS !== 'undefined';
            document.querySelectorAll('.timetable-grid a, .timetable-grid .subject-box').forEach(box => {
                const href = box.getAttribute('href') || '';
                const m = href.match(/\/(?:mapel|subject)\/(\d+)/i);
                const info = (m && hasServerMap) ? SERVER_SUBJECT_NOTIFS[m[1]] : null;

                // Hapus dot bawaan yang salah tempel jika mapel tidak punya notif aktif
                box.querySelectorAll('span.rounded-full').forEach(dot => {
                    if (!info) dot.remove();
                    else dot.style.backgroundColor = info.dot;
                });

                if (info && !box.querySelector('span.rounded-full')) {
                    const dot = document.createElement('span');
                    dot.className = 'rounded-full mobile-notif-dot';
                    dot.style.cssText = 'position:absolute;top:5px;right:5px;width:7px;height:7px;border-radius:9999px;background:' + info.dot;
                    box.style.position = 'relative';
                    box.appendChild(dot);
                }
            });
        }

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
                nav_kalender: 'Kalender',
                nav_siswa: 'Siswa',
                nav_nmr_guru: 'Nmr Guru',
                nav_materi: 'Materi',
                nav_komok: 'Komok',
                nav_latihan: 'Latihan',
                nav_profile: 'Profil',
                nav_pengaturan: 'Pengaturan',
            },
            en: {
                splash_sub: 'Loading XI RPL 1 Timetable & Classroom...',
                nav_ap: 'AP',
                nav_jadwal: 'Schedule',
                nav_kalender: 'Calendar',
                nav_siswa: 'Students',
                nav_nmr_guru: 'Teacher Contacts',
                nav_materi: 'Materials',
                nav_komok: 'Komok',
                nav_latihan: 'Practice',
                nav_profile: 'Profile',
                nav_pengaturan: 'Settings',
            },
            ja: {
                splash_sub: 'XI RPL 1の時間割とクラスルームを読み込んでいます...',
                nav_ap: '管理',
                nav_jadwal: '時間割',
                nav_kalender: 'カレンダー',
                nav_siswa: '生徒',
                nav_nmr_guru: '先生連絡先',
                nav_materi: '教材',
                nav_komok: 'コモック',
                nav_latihan: '練習',
                nav_profile: 'プロフィール',
                nav_pengaturan: '設定',
            },
            ru: {
                splash_sub: 'Загрузка расписания и класса XI RPL 1...',
                nav_ap: 'АП',
                nav_jadwal: 'Расписание',
                nav_kalender: 'Календарь',
                nav_siswa: 'Ученики',
                nav_nmr_guru: 'Номера учителей',
                nav_materi: 'Материалы',
                nav_komok: 'Комок',
                nav_latihan: 'Практика',
                nav_profile: 'Профиль',
                nav_pengaturan: 'Настройки',
            }
        };

        const phraseDictionaries = {
            en: {
                'Jadwal Pelajaran XI RPL 1': 'XI RPL 1 Class Schedule',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'Click a subject box to view Notes, Assignments, Homework, or Events.',
                'Hari / Jam': 'Day / Period',
                'Senin': 'Monday',
                'Selasa': 'Tuesday',
                'Rabu': 'Wednesday',
                'Kamis': 'Thursday',
                'Jumat': 'Friday',
                'Tenggat': 'Due Soon',
                'Deadline': 'Deadline',
                'Selesai': 'Completed',
                'Pengaturan Tampilan': 'Display Settings',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.': 'Customize gradient color themes, graphic styles, animations, sound effects, and app language.',
                'TEMA GELAP (GRADIEN)': 'DARK THEMES (GRADIENT)',
                'TEMA TERANG (GRADIEN)': 'LIGHT THEMES (GRADIENT)',
                'GRAFIK': 'GRAPHICS',
                'GAYA HURUF': 'FONT STYLE',
                'BAHASA': 'LANGUAGE',
                'EFEK SUARA (SFX)': 'SOUND EFFECTS (SFX)',
                'Kasih Saran & Laporan Bug': 'Feedback & Bug Report',
                'Kembali ke Jadwal Utama': 'Back to Main Schedule',
            },
            ja: {
                'Jadwal Pelajaran XI RPL 1': 'XI RPL 1 授業時間割',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': '科目ボックスをクリックしてメモ・課題・宿題・予定を確認します。',
                'Hari / Jam': '曜日 / 時限',
                'Senin': '月曜日',
                'Selasa': '火曜日',
                'Rabu': '水曜日',
                'Kamis': '木曜日',
                'Jumat': '金曜日',
                'Tenggat': '期限間近',
                'Deadline': '締切',
                'Selesai': '完了',
                'Reset': 'リセット',
                'Pengaturan Tampilan': '表示設定',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.': 'カラーテーマ、グラフィックスタイル、アニメーション、効果音、言語をカスタマイズします。',
                'TEMA GELAP (GRADIEN)': 'ダークテーマ (グラデーション)',
                'TEMA TERANG (GRADIEN)': 'ライトテーマ (グラデーション)',
                'GRAFIK': 'グラフィック',
                'GAYA HURUF': 'フォントスタイル',
                'BAHASA': '言語',
                'EFEK SUARA (SFX)': '効果音 (SFX)',
                'Kasih Saran & Laporan Bug': 'ご意見・バグ報告',
                'Kembali ke Jadwal Utama': 'メイン時間割に戻る',
            },
            ru: {
                'Jadwal Pelajaran XI RPL 1': 'Расписание уроков XI RPL 1',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'Нажмите на предмет, чтобы посмотреть заметки, задания, ДЗ или события.',
                'Hari / Jam': 'День / Урок',
                'Senin': 'Понедельник',
                'Selasa': 'Вторник',
                'Rabu': 'Среда',
                'Kamis': 'Четверг',
                'Jumat': 'Пятница',
                'Tenggat': 'Срок',
                'Deadline': 'Дедлайн',
                'Selesai': 'Готово',
                'Reset': 'Сброс',
                'Pengaturan Tampilan': 'Настройки отображения',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.': 'Настройте цветовые темы, стиль графики, анимацию, звуковые эффекты и язык приложения.',
                'TEMA GELAP (GRADIEN)': 'ТЁМНЫЕ ТЕМЫ (ГРАДИЕНТ)',
                'TEMA TERANG (GRADIEN)': 'СВЕТЛЫЕ ТЕМЫ (ГРАДИЕНТ)',
                'GRAFIK': 'ГРАФИКА',
                'GAYA HURUF': 'СТИЛЬ ШРИФТА',
                'BAHASA': 'ЯЗЫК',
                'EFEK SUARA (SFX)': 'ЗВУКОВЫЕ ЭФФЕКТЫ (SFX)',
                'Kasih Saran & Laporan Bug': 'Отзывы и сообщения об ошибках',
                'Kembali ke Jadwal Utama': 'Назад к расписанию',
            }
        };

        function applyPhraseTranslation(lang) {
            const dict = phraseDictionaries[lang];
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
            let node;
            while ((node = walker.nextNode())) {
                if (!node.parentElement || ['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT'].includes(node.parentElement.tagName)) continue;
                const raw = node.nodeValue;
                const trimmed = raw.trim();
                if (!trimmed) continue;

                if (!node._origText) {
                    node._origText = raw;
                }

                if (lang === 'id') {
                    node.nodeValue = node._origText;
                } else if (dict && dict[trimmed]) {
                    node.nodeValue = raw.replace(trimmed, dict[trimmed]);
                } else if (node._origText) {
                    const origTrimmed = node._origText.trim();
                    if (dict && dict[origTrimmed]) {
                        node.nodeValue = node._origText.replace(origTrimmed, dict[origTrimmed]);
                    } else {
                        node.nodeValue = node._origText;
                    }
                }
            }
        }

                const I18N_DICT = {
            en: {
                'Jadwal': 'Schedule', 'Tugas': 'Tasks', 'Kalender': 'Calendar', 'Siswa': 'Students',
                'Nmr Guru': 'Teachers', 'Materi': 'Materials', 'Latihan': 'Practice', 'Profil': 'Profile',
                'Pengaturan': 'Settings', 'Komok': 'Komok',
                'Jadwal Pelajaran XI RPL 1': 'Class Schedule XI RPL 1',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'Click any subject box to view Notes, Tasks, Homework, or Events.',
                'Catatan': 'Notes', 'PR': 'Homework', 'Event': 'Event', 'Tenggat': 'Due Soon',
                'Deadline': 'Overdue', 'Selesai': 'Completed', 'Reset': 'Reset',
                'Pengaturan Tampilan': 'Display Settings',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'Customize gradient themes, graphic style, animations, sound effects, class music, and app language.',
                '← Kembali ke Jadwal Utama': '← Back to Main Schedule',
                'TEMA GELAP (GRADIEN)': 'DARK THEMES (GRADIENT)',
                'TEMA TERANG (GRADIEN)': 'LIGHT THEMES (GRADIENT)',
                'GRAFIK & ANIMASI': 'GRAPHICS & ANIMATION',
                'Animasi Transisi UI': 'UI Transition Animation',
                'GAYA HURUF': 'FONT STYLE',
                'EFEK SUARA (SFX)': 'SOUND EFFECTS (SFX)',
                'BAHASA': 'LANGUAGE',
                'Pemutar Musik Kelas': 'Class Music Player',
                'Kasih Saran & Laporan Bug': 'Send Feedback & Bug Report',
                'Daftar Semua Tugas, PR & Event': 'All Tasks, Homework & Events',
                'Tandai Selesai': 'Mark Done', 'Buka & Komentar': 'Open & Comment',
                'Nomor WhatsApp Guru XI RPL 1': 'Teacher WhatsApp Contacts XI RPL 1',
                'Bank Materi Ujian (AAS, ATS, Ulangan)': 'Exam Study Materials (AAS, ATS, Quizzes)',
                'Pusat Latihan Soal XI RPL 1': 'Practice Quiz Center XI RPL 1',
                'Hari / Jam': 'Day / Time', 'Senin': 'Monday', 'Selasa': 'Tuesday', 'Rabu': 'Wednesday', 'Kamis': 'Thursday', 'Jumat': 'Friday'
            },
            ja: {
                'Jadwal': '時間割', 'Tugas': '課題', 'Kalender': 'カレンダー', 'Siswa': '生徒一覧',
                'Nmr Guru': '先生連絡先', 'Materi': '教材', 'Latihan': '練習問題', 'Profil': 'プロフィール',
                'Pengaturan': '設定', 'Komok': 'コモック',
                'Jadwal Pelajaran XI RPL 1': 'XI RPL 1 授業時間割',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': '教科ボックスをクリックしてノート・課題・宿題・イベントを確認します。',
                'Catatan': 'ノート', 'PR': '宿題', 'Event': 'イベント', 'Tenggat': '締切間近',
                'Deadline': '期限切れ', 'Selesai': '完了', 'Reset': 'リセット',
                'Pengaturan Tampilan': '表示設定',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'グラデーションテーマ、グラフィックスタイル、アニメーション、効果音、音楽、言語を設定します。',
                '← Kembali ke Jadwal Utama': '← 時間割に戻る',
                'TEMA GELAP (GRADIEN)': 'ダークテーマ（グラデーション）',
                'TEMA TERANG (GRADIEN)': 'ライトテーマ（グラデーション）',
                'GRAFIK & ANIMASI': 'グラフィックとアニメーション',
                'Animasi Transisi UI': 'UIトランジションアニメーション',
                'GAYA HURUF': 'フォントスタイル',
                'EFEK SUARA (SFX)': '効果音 (SFX)',
                'BAHASA': '言語設定',
                'Pemutar Musik Kelas': 'クラス音楽プレイヤー',
                'Kasih Saran & Laporan Bug': 'ご意見・バグ報告',
                'Daftar Semua Tugas, PR & Event': 'すべての課題・宿題・イベント一覧',
                'Tandai Selesai': '完了にする', 'Buka & Komentar': '開く・コメント',
                'Nomor WhatsApp Guru XI RPL 1': 'XI RPL 1 先生の連絡先',
                'Bank Materi Ujian (AAS, ATS, Ulangan)': '試験対策教材バンク',
                'Pusat Latihan Soal XI RPL 1': 'XI RPL 1 練習問題センター',
                'Hari / Jam': '曜日 / 時限', 'Senin': '月曜', 'Selasa': '火曜', 'Rabu': '水曜', 'Kamis': '木曜', 'Jumat': '金曜'
            },
            ru: {
                'Jadwal': 'Расписание', 'Tugas': 'Задания', 'Kalender': 'Календарь', 'Siswa': 'Ученики',
                'Nmr Guru': 'Учителя', 'Materi': 'Материалы', 'Latihan': 'Тесты', 'Profil': 'Профиль',
                'Pengaturan': 'Настройки', 'Komok': 'Комок',
                'Jadwal Pelajaran XI RPL 1': 'Расписание уроков XI RPL 1',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'Нажмите на предмет, чтобы открыть заметки, задания, ДЗ или события.',
                'Catatan': 'Заметки', 'PR': 'ДЗ', 'Event': 'События', 'Tenggat': 'Скоро срок',
                'Deadline': 'Просрочено', 'Selesai': 'Готово', 'Reset': 'Сброс',
                'Pengaturan Tampilan': 'Настройки экрана',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'Настройте градиентные темы, графику, анимацию, звуки, музыку класса и язык.',
                '← Kembali ke Jadwal Utama': '← Назад к расписанию',
                'TEMA GELAP (GRADIEN)': 'ТЁМНЫЕ ТЕМЫ (ГРАДИЕНТ)',
                'TEMA TERANG (GRADIEN)': 'СВЕТЛЫЕ ТЕМЫ (ГРАДИЕНТ)',
                'GRAFIK & ANIMASI': 'ГРАФИКА И АНИМАЦИЯ',
                'Animasi Transisi UI': 'Анимация переходов UI',
                'GAYA HURUF': 'СТИЛЬ ШРИФТА',
                'EFEK SUARA (SFX)': 'ЗВУКОВЫЕ ЭФФЕКТЫ (SFX)',
                'BAHASA': 'ЯЗЫК',
                'Pemutar Musik Kelas': 'Музыкальный плеер класса',
                'Kasih Saran & Laporan Bug': 'Отзыв и отчёт об ошибке',
                'Daftar Semua Tugas, PR & Event': 'Все задания, ДЗ и события',
                'Tandai Selesai': 'Выполнено', 'Buka & Komentar': 'Открыть',
                'Nomor WhatsApp Guru XI RPL 1': 'Контакты WhatsApp учителей XI RPL 1',
                'Bank Materi Ujian (AAS, ATS, Ulangan)': 'Учебные материалы к экзаменам',
                'Pusat Latihan Soal XI RPL 1': 'Тренировочные тесты XI RPL 1',
                'Hari / Jam': 'День / Урок', 'Senin': 'Пн', 'Selasa': 'Вт', 'Rabu': 'Ср', 'Kamis': 'Чт', 'Jumat': 'Пт'
            }
        };

        function applyLanguage(lang) {
            const dict = I18N_DICT[lang] || null;
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
            let node;
            while ((node = walker.nextNode())) {
                const parent = node.parentElement;
                if (!parent || ['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT'].includes(parent.tagName)) continue;
                if (!node._origText) node._origText = node.nodeValue;

                if (!dict) {
                    node.nodeValue = node._origText;
                    continue;
                }

                let text = node._origText;
                Object.keys(dict).sort((a, b) => b.length - a.length).forEach(key => {
                    if (text.includes(key)) {
                        text = text.split(key).join(dict[key]);
                    }
                });
                node.nodeValue = text;
            }
        }

                document.addEventListener('DOMContentLoaded', () => {
            applyLanguage(localStorage.getItem('app_lang') || 'id');
            enhanceScheduleMobileLayout();
            renderOnlineMemberPill();
            syncScheduleMarkersAndSourceTab();
            const activeNav = document.querySelector('.nav-links-wrap .theme-primary');
            if (activeNav && window.innerWidth <= 640) {
                activeNav.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        });

        window.addEventListener('resize', () => {
            shortenSubjectsForMobile();
        });
    </script>
</body>
</html>