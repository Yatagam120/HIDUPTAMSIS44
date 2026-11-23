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
                                'sub'   => $subjName . ' â€¢ ' . strtoupper($tType),
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
                            $subLabel = $subjName . ' â€¢ ' . strtoupper($tType);
                            $titlePrefix = strtoupper($tType) . ' Baru: ';

                            if ($dueVal) {
                                try {
                                    $diff = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($dueVal)->startOfDay(), false);
                                    $subLabel .= ' â€¢ ' . \Carbon\Carbon::parse($dueVal)->format('d M Y');
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
                                'sub'   => $subLabel . ' â€¢ Oleh ' . $creatorName,
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
                        ðŸ””
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
                        ðŸ””
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
                <span class="text-xs font-extrabold">ðŸ”” Notifikasi ({{ $navNotifs->count() }})</span>
                <button type="button" onclick="toggleNavNotifBox()" class="px-2 py-0.5 rounded text-xs font-bold border theme-border">âœ•</button>
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
            âœ• Tutup
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
                ['Samsung Tech Institute', 'STI'],
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
                    $tagMap = ['pr' => 'ðŸ  PR', 'tugas' => 'ðŸ“Œ TGS', 'event' => 'ðŸŽ‰ EVT', 'catatan' => 'ðŸ“ CTT'];
                    $prioMap = ['PR' => 4, 'TGS' => 3, 'EVT' => 2, 'CTT' => 1];
                    $candTag = $tagMap[$mType] ?? '';
                    if ($candTag) {
                        $curTag = $mobileSubjectNotifMap[$sid]['tag'] ?? '';
                        if (($prioMap[$candTag] ?? 0) >= ($prioMap[$curTag] ?? 0)) {
                            $dotHex = match ($mType) {
                                'catatan' => '#38bdf8',
                                'pr'      => '#fb923c',
                                'event'   => '#c084fc',
                                default   => '#facc15',
                            };
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
                splash_sub: 'XI RPL 1ã®æ™‚é–“å‰²ã¨ã‚¯ãƒ©ã‚¹ãƒ«ãƒ¼ãƒ ã‚’èª­ã¿è¾¼ã‚“ã§ã„ã¾ã™...',
                nav_ap: 'ç®¡ç†',
                nav_jadwal: 'æ™‚é–“å‰²',
                nav_kalender: 'ã‚«ãƒ¬ãƒ³ãƒ€ãƒ¼',
                nav_siswa: 'ç”Ÿå¾’',
                nav_nmr_guru: 'å…ˆç”Ÿé€£çµ¡å…ˆ',
                nav_materi: 'æ•™æ',
                nav_komok: 'ã‚³ãƒ¢ãƒƒã‚¯',
                nav_latihan: 'ç·´ç¿’',
                nav_profile: 'ãƒ—ãƒ­ãƒ•ã‚£ãƒ¼ãƒ«',
                nav_pengaturan: 'è¨­å®š',
            },
            ru: {
                splash_sub: 'Ð—Ð°Ð³Ñ€ÑƒÐ·ÐºÐ° Ñ€Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ñ Ð¸ ÐºÐ»Ð°ÑÑÐ° XI RPL 1...',
                nav_ap: 'ÐÐŸ',
                nav_jadwal: 'Ð Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ',
                nav_kalender: 'ÐšÐ°Ð»ÐµÐ½Ð´Ð°Ñ€ÑŒ',
                nav_siswa: 'Ð£Ñ‡ÐµÐ½Ð¸ÐºÐ¸',
                nav_nmr_guru: 'ÐÐ¾Ð¼ÐµÑ€Ð° ÑƒÑ‡Ð¸Ñ‚ÐµÐ»ÐµÐ¹',
                nav_materi: 'ÐœÐ°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ñ‹',
                nav_komok: 'ÐšÐ¾Ð¼Ð¾Ðº',
                nav_latihan: 'ÐŸÑ€Ð°ÐºÑ‚Ð¸ÐºÐ°',
                nav_profile: 'ÐŸÑ€Ð¾Ñ„Ð¸Ð»ÑŒ',
                nav_pengaturan: 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸',
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
                'Jadwal Pelajaran XI RPL 1': 'XI RPL 1 æŽˆæ¥­æ™‚é–“å‰²',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'ç§‘ç›®ãƒœãƒƒã‚¯ã‚¹ã‚’ã‚¯ãƒªãƒƒã‚¯ã—ã¦ãƒ¡ãƒ¢ãƒ»èª²é¡Œãƒ»å®¿é¡Œãƒ»äºˆå®šã‚’ç¢ºèªã—ã¾ã™ã€‚',
                'Hari / Jam': 'æ›œæ—¥ / æ™‚é™',
                'Senin': 'æœˆæ›œæ—¥',
                'Selasa': 'ç«æ›œæ—¥',
                'Rabu': 'æ°´æ›œæ—¥',
                'Kamis': 'æœ¨æ›œæ—¥',
                'Jumat': 'é‡‘æ›œæ—¥',
                'Tenggat': 'æœŸé™é–“è¿‘',
                'Deadline': 'ç· åˆ‡',
                'Selesai': 'å®Œäº†',
                'Reset': 'ãƒªã‚»ãƒƒãƒˆ',
                'Pengaturan Tampilan': 'è¡¨ç¤ºè¨­å®š',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.': 'ã‚«ãƒ©ãƒ¼ãƒ†ãƒ¼ãƒžã€ã‚°ãƒ©ãƒ•ã‚£ãƒƒã‚¯ã‚¹ã‚¿ã‚¤ãƒ«ã€ã‚¢ãƒ‹ãƒ¡ãƒ¼ã‚·ãƒ§ãƒ³ã€åŠ¹æžœéŸ³ã€è¨€èªžã‚’ã‚«ã‚¹ã‚¿ãƒžã‚¤ã‚ºã—ã¾ã™ã€‚',
                'TEMA GELAP (GRADIEN)': 'ãƒ€ãƒ¼ã‚¯ãƒ†ãƒ¼ãƒž (ã‚°ãƒ©ãƒ‡ãƒ¼ã‚·ãƒ§ãƒ³)',
                'TEMA TERANG (GRADIEN)': 'ãƒ©ã‚¤ãƒˆãƒ†ãƒ¼ãƒž (ã‚°ãƒ©ãƒ‡ãƒ¼ã‚·ãƒ§ãƒ³)',
                'GRAFIK': 'ã‚°ãƒ©ãƒ•ã‚£ãƒƒã‚¯',
                'GAYA HURUF': 'ãƒ•ã‚©ãƒ³ãƒˆã‚¹ã‚¿ã‚¤ãƒ«',
                'BAHASA': 'è¨€èªž',
                'EFEK SUARA (SFX)': 'åŠ¹æžœéŸ³ (SFX)',
                'Kasih Saran & Laporan Bug': 'ã”æ„è¦‹ãƒ»ãƒã‚°å ±å‘Š',
                'Kembali ke Jadwal Utama': 'ãƒ¡ã‚¤ãƒ³æ™‚é–“å‰²ã«æˆ»ã‚‹',
            },
            ru: {
                'Jadwal Pelajaran XI RPL 1': 'Ð Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ ÑƒÑ€Ð¾ÐºÐ¾Ð² XI RPL 1',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'ÐÐ°Ð¶Ð¼Ð¸Ñ‚Ðµ Ð½Ð° Ð¿Ñ€ÐµÐ´Ð¼ÐµÑ‚, Ñ‡Ñ‚Ð¾Ð±Ñ‹ Ð¿Ð¾ÑÐ¼Ð¾Ñ‚Ñ€ÐµÑ‚ÑŒ Ð·Ð°Ð¼ÐµÑ‚ÐºÐ¸, Ð·Ð°Ð´Ð°Ð½Ð¸Ñ, Ð”Ð— Ð¸Ð»Ð¸ ÑÐ¾Ð±Ñ‹Ñ‚Ð¸Ñ.',
                'Hari / Jam': 'Ð”ÐµÐ½ÑŒ / Ð£Ñ€Ð¾Ðº',
                'Senin': 'ÐŸÐ¾Ð½ÐµÐ´ÐµÐ»ÑŒÐ½Ð¸Ðº',
                'Selasa': 'Ð’Ñ‚Ð¾Ñ€Ð½Ð¸Ðº',
                'Rabu': 'Ð¡Ñ€ÐµÐ´Ð°',
                'Kamis': 'Ð§ÐµÑ‚Ð²ÐµÑ€Ð³',
                'Jumat': 'ÐŸÑÑ‚Ð½Ð¸Ñ†Ð°',
                'Tenggat': 'Ð¡Ñ€Ð¾Ðº',
                'Deadline': 'Ð”ÐµÐ´Ð»Ð°Ð¹Ð½',
                'Selesai': 'Ð“Ð¾Ñ‚Ð¾Ð²Ð¾',
                'Reset': 'Ð¡Ð±Ñ€Ð¾Ñ',
                'Pengaturan Tampilan': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸ Ð¾Ñ‚Ð¾Ð±Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, dan bahasa aplikasi.': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹Ñ‚Ðµ Ñ†Ð²ÐµÑ‚Ð¾Ð²Ñ‹Ðµ Ñ‚ÐµÐ¼Ñ‹, ÑÑ‚Ð¸Ð»ÑŒ Ð³Ñ€Ð°Ñ„Ð¸ÐºÐ¸, Ð°Ð½Ð¸Ð¼Ð°Ñ†Ð¸ÑŽ, Ð·Ð²ÑƒÐºÐ¾Ð²Ñ‹Ðµ ÑÑ„Ñ„ÐµÐºÑ‚Ñ‹ Ð¸ ÑÐ·Ñ‹Ðº Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ.',
                'TEMA GELAP (GRADIEN)': 'Ð¢ÐÐœÐÐ«Ð• Ð¢Ð•ÐœÐ« (Ð“Ð ÐÐ”Ð˜Ð•ÐÐ¢)',
                'TEMA TERANG (GRADIEN)': 'Ð¡Ð’Ð•Ð¢Ð›Ð«Ð• Ð¢Ð•ÐœÐ« (Ð“Ð ÐÐ”Ð˜Ð•ÐÐ¢)',
                'GRAFIK': 'Ð“Ð ÐÐ¤Ð˜ÐšÐ',
                'GAYA HURUF': 'Ð¡Ð¢Ð˜Ð›Ð¬ Ð¨Ð Ð˜Ð¤Ð¢Ð',
                'BAHASA': 'Ð¯Ð—Ð«Ðš',
                'EFEK SUARA (SFX)': 'Ð—Ð’Ð£ÐšÐžÐ’Ð«Ð• Ð­Ð¤Ð¤Ð•ÐšÐ¢Ð« (SFX)',
                'Kasih Saran & Laporan Bug': 'ÐžÑ‚Ð·Ñ‹Ð²Ñ‹ Ð¸ ÑÐ¾Ð¾Ð±Ñ‰ÐµÐ½Ð¸Ñ Ð¾Ð± Ð¾ÑˆÐ¸Ð±ÐºÐ°Ñ…',
                'Kembali ke Jadwal Utama': 'ÐÐ°Ð·Ð°Ð´ Ðº Ñ€Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸ÑŽ',
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
                'â† Kembali ke Jadwal Utama': 'â† Back to Main Schedule',
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
                'Jadwal': 'æ™‚é–“å‰²', 'Tugas': 'èª²é¡Œ', 'Kalender': 'ã‚«ãƒ¬ãƒ³ãƒ€ãƒ¼', 'Siswa': 'ç”Ÿå¾’ä¸€è¦§',
                'Nmr Guru': 'å…ˆç”Ÿé€£çµ¡å…ˆ', 'Materi': 'æ•™æ', 'Latihan': 'ç·´ç¿’å•é¡Œ', 'Profil': 'ãƒ—ãƒ­ãƒ•ã‚£ãƒ¼ãƒ«',
                'Pengaturan': 'è¨­å®š', 'Komok': 'ã‚³ãƒ¢ãƒƒã‚¯',
                'Jadwal Pelajaran XI RPL 1': 'XI RPL 1 æŽˆæ¥­æ™‚é–“å‰²',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'æ•™ç§‘ãƒœãƒƒã‚¯ã‚¹ã‚’ã‚¯ãƒªãƒƒã‚¯ã—ã¦ãƒŽãƒ¼ãƒˆãƒ»èª²é¡Œãƒ»å®¿é¡Œãƒ»ã‚¤ãƒ™ãƒ³ãƒˆã‚’ç¢ºèªã—ã¾ã™ã€‚',
                'Catatan': 'ãƒŽãƒ¼ãƒˆ', 'PR': 'å®¿é¡Œ', 'Event': 'ã‚¤ãƒ™ãƒ³ãƒˆ', 'Tenggat': 'ç· åˆ‡é–“è¿‘',
                'Deadline': 'æœŸé™åˆ‡ã‚Œ', 'Selesai': 'å®Œäº†', 'Reset': 'ãƒªã‚»ãƒƒãƒˆ',
                'Pengaturan Tampilan': 'è¡¨ç¤ºè¨­å®š',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'ã‚°ãƒ©ãƒ‡ãƒ¼ã‚·ãƒ§ãƒ³ãƒ†ãƒ¼ãƒžã€ã‚°ãƒ©ãƒ•ã‚£ãƒƒã‚¯ã‚¹ã‚¿ã‚¤ãƒ«ã€ã‚¢ãƒ‹ãƒ¡ãƒ¼ã‚·ãƒ§ãƒ³ã€åŠ¹æžœéŸ³ã€éŸ³æ¥½ã€è¨€èªžã‚’è¨­å®šã—ã¾ã™ã€‚',
                'â† Kembali ke Jadwal Utama': 'â† æ™‚é–“å‰²ã«æˆ»ã‚‹',
                'TEMA GELAP (GRADIEN)': 'ãƒ€ãƒ¼ã‚¯ãƒ†ãƒ¼ãƒžï¼ˆã‚°ãƒ©ãƒ‡ãƒ¼ã‚·ãƒ§ãƒ³ï¼‰',
                'TEMA TERANG (GRADIEN)': 'ãƒ©ã‚¤ãƒˆãƒ†ãƒ¼ãƒžï¼ˆã‚°ãƒ©ãƒ‡ãƒ¼ã‚·ãƒ§ãƒ³ï¼‰',
                'GRAFIK & ANIMASI': 'ã‚°ãƒ©ãƒ•ã‚£ãƒƒã‚¯ã¨ã‚¢ãƒ‹ãƒ¡ãƒ¼ã‚·ãƒ§ãƒ³',
                'Animasi Transisi UI': 'UIãƒˆãƒ©ãƒ³ã‚¸ã‚·ãƒ§ãƒ³ã‚¢ãƒ‹ãƒ¡ãƒ¼ã‚·ãƒ§ãƒ³',
                'GAYA HURUF': 'ãƒ•ã‚©ãƒ³ãƒˆã‚¹ã‚¿ã‚¤ãƒ«',
                'EFEK SUARA (SFX)': 'åŠ¹æžœéŸ³ (SFX)',
                'BAHASA': 'è¨€èªžè¨­å®š',
                'Pemutar Musik Kelas': 'ã‚¯ãƒ©ã‚¹éŸ³æ¥½ãƒ—ãƒ¬ã‚¤ãƒ¤ãƒ¼',
                'Kasih Saran & Laporan Bug': 'ã”æ„è¦‹ãƒ»ãƒã‚°å ±å‘Š',
                'Daftar Semua Tugas, PR & Event': 'ã™ã¹ã¦ã®èª²é¡Œãƒ»å®¿é¡Œãƒ»ã‚¤ãƒ™ãƒ³ãƒˆä¸€è¦§',
                'Tandai Selesai': 'å®Œäº†ã«ã™ã‚‹', 'Buka & Komentar': 'é–‹ããƒ»ã‚³ãƒ¡ãƒ³ãƒˆ',
                'Nomor WhatsApp Guru XI RPL 1': 'XI RPL 1 å…ˆç”Ÿã®é€£çµ¡å…ˆ',
                'Bank Materi Ujian (AAS, ATS, Ulangan)': 'è©¦é¨“å¯¾ç­–æ•™æãƒãƒ³ã‚¯',
                'Pusat Latihan Soal XI RPL 1': 'XI RPL 1 ç·´ç¿’å•é¡Œã‚»ãƒ³ã‚¿ãƒ¼',
                'Hari / Jam': 'æ›œæ—¥ / æ™‚é™', 'Senin': 'æœˆæ›œ', 'Selasa': 'ç«æ›œ', 'Rabu': 'æ°´æ›œ', 'Kamis': 'æœ¨æ›œ', 'Jumat': 'é‡‘æ›œ'
            },
            ru: {
                'Jadwal': 'Ð Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ', 'Tugas': 'Ð—Ð°Ð´Ð°Ð½Ð¸Ñ', 'Kalender': 'ÐšÐ°Ð»ÐµÐ½Ð´Ð°Ñ€ÑŒ', 'Siswa': 'Ð£Ñ‡ÐµÐ½Ð¸ÐºÐ¸',
                'Nmr Guru': 'Ð£Ñ‡Ð¸Ñ‚ÐµÐ»Ñ', 'Materi': 'ÐœÐ°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ñ‹', 'Latihan': 'Ð¢ÐµÑÑ‚Ñ‹', 'Profil': 'ÐŸÑ€Ð¾Ñ„Ð¸Ð»ÑŒ',
                'Pengaturan': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸', 'Komok': 'ÐšÐ¾Ð¼Ð¾Ðº',
                'Jadwal Pelajaran XI RPL 1': 'Ð Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ ÑƒÑ€Ð¾ÐºÐ¾Ð² XI RPL 1',
                'Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.': 'ÐÐ°Ð¶Ð¼Ð¸Ñ‚Ðµ Ð½Ð° Ð¿Ñ€ÐµÐ´Ð¼ÐµÑ‚, Ñ‡Ñ‚Ð¾Ð±Ñ‹ Ð¾Ñ‚ÐºÑ€Ñ‹Ñ‚ÑŒ Ð·Ð°Ð¼ÐµÑ‚ÐºÐ¸, Ð·Ð°Ð´Ð°Ð½Ð¸Ñ, Ð”Ð— Ð¸Ð»Ð¸ ÑÐ¾Ð±Ñ‹Ñ‚Ð¸Ñ.',
                'Catatan': 'Ð—Ð°Ð¼ÐµÑ‚ÐºÐ¸', 'PR': 'Ð”Ð—', 'Event': 'Ð¡Ð¾Ð±Ñ‹Ñ‚Ð¸Ñ', 'Tenggat': 'Ð¡ÐºÐ¾Ñ€Ð¾ ÑÑ€Ð¾Ðº',
                'Deadline': 'ÐŸÑ€Ð¾ÑÑ€Ð¾Ñ‡ÐµÐ½Ð¾', 'Selesai': 'Ð“Ð¾Ñ‚Ð¾Ð²Ð¾', 'Reset': 'Ð¡Ð±Ñ€Ð¾Ñ',
                'Pengaturan Tampilan': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸ ÑÐºÑ€Ð°Ð½Ð°',
                'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹Ñ‚Ðµ Ð³Ñ€Ð°Ð´Ð¸ÐµÐ½Ñ‚Ð½Ñ‹Ðµ Ñ‚ÐµÐ¼Ñ‹, Ð³Ñ€Ð°Ñ„Ð¸ÐºÑƒ, Ð°Ð½Ð¸Ð¼Ð°Ñ†Ð¸ÑŽ, Ð·Ð²ÑƒÐºÐ¸, Ð¼ÑƒÐ·Ñ‹ÐºÑƒ ÐºÐ»Ð°ÑÑÐ° Ð¸ ÑÐ·Ñ‹Ðº.',
                'â† Kembali ke Jadwal Utama': 'â† ÐÐ°Ð·Ð°Ð´ Ðº Ñ€Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸ÑŽ',
                'TEMA GELAP (GRADIEN)': 'Ð¢ÐÐœÐÐ«Ð• Ð¢Ð•ÐœÐ« (Ð“Ð ÐÐ”Ð˜Ð•ÐÐ¢)',
                'TEMA TERANG (GRADIEN)': 'Ð¡Ð’Ð•Ð¢Ð›Ð«Ð• Ð¢Ð•ÐœÐ« (Ð“Ð ÐÐ”Ð˜Ð•ÐÐ¢)',
                'GRAFIK & ANIMASI': 'Ð“Ð ÐÐ¤Ð˜ÐšÐ Ð˜ ÐÐÐ˜ÐœÐÐ¦Ð˜Ð¯',
                'Animasi Transisi UI': 'ÐÐ½Ð¸Ð¼Ð°Ñ†Ð¸Ñ Ð¿ÐµÑ€ÐµÑ…Ð¾Ð´Ð¾Ð² UI',
                'GAYA HURUF': 'Ð¡Ð¢Ð˜Ð›Ð¬ Ð¨Ð Ð˜Ð¤Ð¢Ð',
                'EFEK SUARA (SFX)': 'Ð—Ð’Ð£ÐšÐžÐ’Ð«Ð• Ð­Ð¤Ð¤Ð•ÐšÐ¢Ð« (SFX)',
                'BAHASA': 'Ð¯Ð—Ð«Ðš',
                'Pemutar Musik Kelas': 'ÐœÑƒÐ·Ñ‹ÐºÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ð¿Ð»ÐµÐµÑ€ ÐºÐ»Ð°ÑÑÐ°',
                'Kasih Saran & Laporan Bug': 'ÐžÑ‚Ð·Ñ‹Ð² Ð¸ Ð¾Ñ‚Ñ‡Ñ‘Ñ‚ Ð¾Ð± Ð¾ÑˆÐ¸Ð±ÐºÐµ',
                'Daftar Semua Tugas, PR & Event': 'Ð’ÑÐµ Ð·Ð°Ð´Ð°Ð½Ð¸Ñ, Ð”Ð— Ð¸ ÑÐ¾Ð±Ñ‹Ñ‚Ð¸Ñ',
                'Tandai Selesai': 'Ð’Ñ‹Ð¿Ð¾Ð»Ð½ÐµÐ½Ð¾', 'Buka & Komentar': 'ÐžÑ‚ÐºÑ€Ñ‹Ñ‚ÑŒ',
                'Nomor WhatsApp Guru XI RPL 1': 'ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ñ‹ WhatsApp ÑƒÑ‡Ð¸Ñ‚ÐµÐ»ÐµÐ¹ XI RPL 1',
                'Bank Materi Ujian (AAS, ATS, Ulangan)': 'Ð£Ñ‡ÐµÐ±Ð½Ñ‹Ðµ Ð¼Ð°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ñ‹ Ðº ÑÐºÐ·Ð°Ð¼ÐµÐ½Ð°Ð¼',
                'Pusat Latihan Soal XI RPL 1': 'Ð¢Ñ€ÐµÐ½Ð¸Ñ€Ð¾Ð²Ð¾Ñ‡Ð½Ñ‹Ðµ Ñ‚ÐµÑÑ‚Ñ‹ XI RPL 1',
                'Hari / Jam': 'Ð”ÐµÐ½ÑŒ / Ð£Ñ€Ð¾Ðº', 'Senin': 'ÐŸÐ½', 'Selasa': 'Ð’Ñ‚', 'Rabu': 'Ð¡Ñ€', 'Kamis': 'Ð§Ñ‚', 'Jumat': 'ÐŸÑ‚'
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
            @php
            $uncompletedPrCount = 0;
            $uncompletedTugasCount = 0;
            $subjectEventMap = [];
            if (isset($allItems) && $authUser) {
                $uidInt = (int) $authUser->id;
                foreach ($allItems as $ci) {
                    if (($ci->status ?? 'approved') !== 'approved') continue;
                    $cType = strtolower(trim((string) ($ci->category ?? $ci->kategori ?? $ci->type ?? $ci->jenis ?? '')));
                    $cDoneArr = is_array($ci->completed_by ?? null)
                        ? $ci->completed_by
                        : (json_decode((string) ($ci->completed_by ?? '[]'), true) ?: []);
                    $cIsDone = in_array($uidInt, array_map('intval', $cDoneArr), true);

                    if ($cType === 'pr' && !$cIsDone) $uncompletedPrCount++;
                    if ($cType === 'tugas' && !$cIsDone) $uncompletedTugasCount++;
                    if ($cType === 'event' && !$cIsDone) {
                        $sidEv = (string) $ci->subject_id;
                        $subjectEventMap[$sidEv] = ($subjectEventMap[$sidEv] ?? 0) + 1;
                    }
                }
            }
        @endphp
        const UNCOMPLETED_PR_COUNT = {{ $uncompletedPrCount }};
        const UNCOMPLETED_TUGAS_COUNT = {{ $uncompletedTugasCount }};
        const SUBJECT_EVENT_MAP = @json($subjectEventMap);

        function applyPrTugasCountsAndEventBadges() {
            // 1. Tampilkan angka PR & Tugas yang belum selesai di tombol filter jadwal
            document.querySelectorAll('.filter-bar-mobile-grid button, .filter-bar-mobile-grid a, button, a').forEach(el => {
                if (el.closest('nav')) return;
                const txt = (el.textContent || '').trim();
                if (/^ðŸ“Œ?\s*Tugas$/i.test(txt) && UNCOMPLETED_TUGAS_COUNT > 0 && !el.querySelector('.cnt-pill')) {
                    const pill = document.createElement('span');
                    pill.className = 'cnt-pill ml-1.5 px-1.5 py-0.2 rounded-full bg-amber-400 text-zinc-950 text-[10px] font-black';
                    pill.textContent = UNCOMPLETED_TUGAS_COUNT;
                    el.appendChild(pill);
                }
                if (/^ðŸ ?\s*PR$/i.test(txt) && UNCOMPLETED_PR_COUNT > 0 && !el.querySelector('.cnt-pill')) {
                    const pill = document.createElement('span');
                    pill.className = 'cnt-pill ml-1.5 px-1.5 py-0.2 rounded-full bg-orange-400 text-zinc-950 text-[10px] font-black';
                    pill.textContent = UNCOMPLETED_PR_COUNT;
                    el.appendChild(pill);
                }
            });

            // 2. Penanda Event warna merah keabuan (#b97a7a) di pojok kanan atas kotak mapel
            document.querySelectorAll('.timetable-grid a, .timetable-grid .subject-box').forEach(box => {
                const href = box.getAttribute('href') || '';
                const m = href.match(/\/(?:mapel|subject)\/(\d+)/i);
                if (!m) return;
                const evCount = SUBJECT_EVENT_MAP[m[1]] || 0;
                if (evCount > 0 && !box.querySelector('.event-grayred-badge')) {
                    box.style.position = 'relative';
                    const evBadge = document.createElement('span');
                    evBadge.className = 'event-grayred-badge';
                    evBadge.title = evCount + ' Event Aktif';
                    evBadge.textContent = evCount;
                    evBadge.style.cssText = 'position:absolute;top:3px;right:3px;min-width:14px;height:14px;padding:0 3px;border-radius:9999px;background:#b97a7a;color:#ffffff;font-size:8.5px;font-weight:900;display:flex;align-items:center;justify-content:center;box-shadow:0 0 6px rgba(185,122,122,0.75);z-index:12;';
                    box.appendChild(evBadge);
                }
            });

            // 3. Tutup otomatis modal preview gambar kosong jika tidak ada src valid
            document.querySelectorAll('img[alt="Preview Foto"]').forEach(img => {
                if (!img.getAttribute('src') || img.getAttribute('src') === '') {
                    const wrap = img.closest('.fixed');
                    if (wrap) wrap.classList.add('hidden');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', applyPrTugasCountsAndEventBadges);
            document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('nav a').forEach(a => {
                if (/^\(\d+\)\s*Tugas$/i.test(a.textContent.trim())) {
                    a.textContent = 'List Tugas';
                }
            });
        });
            function formatDesktopSubjectLabels() {
            const subjectDict = [
                { keys: ['ketamansiswaan', 'kts'], code: 'KTS', full: 'Ketamansiswaan' },
                { keys: ['samsung tech institute', 'sti'], code: 'STI', full: 'Samsung Tech Institute' },
                { keys: ['bimbingan dan konseling', 'bimbingan konseling', 'bk'], code: 'BK', full: 'Bimbingan & Konseling' },
                { keys: ['kreativitas & desain interaktif', 'kreativitas dan desain interaktif', 'kdi'], code: 'KDI', full: 'Kreativitas & Desain Interaktif' },
                { keys: ['muatan bahasa jepang', 'bahasa jepang', 'mbj'], code: 'MBJ(J)', full: 'Muatan Bahasa Jepang' },
                { keys: ['pendidikan pancasila', 'ppkn', 'pp'], code: 'PP', full: 'Pendidikan Pancasila' },
                { keys: ['bahasa inggris', 'b.ing'], code: 'B.Ing', full: 'Bahasa Inggris' },
                { keys: ['bahasa indonesia', 'bi'], code: 'BI', full: 'Bahasa Indonesia' },
                { keys: ['matematika', 'mtk'], code: 'MTK', full: 'Matematika' },
                { keys: ['pendidikan jasmani', 'pjok', 'penjas'], code: 'Penjas', full: 'Pendidikan Jasmani' },
                { keys: ['pemrograman lanjut', 'pl(rpl1)', 'pl'], code: 'PL(RPL1)', full: 'Pemrograman Lanjut' },
                { keys: ['sejarah indonesia', 'sejarah', 'si'], code: 'SI', full: 'Sejarah Indonesia' },
                { keys: ['kewirausahaan', 'pkk', 'kwh'], code: 'KWH', full: 'Kewirausahaan' },
                { keys: ['pendidikan agama islam', 'pai'], code: 'PAI', full: 'Pendidikan Agama Islam' }
            ];

            document.querySelectorAll('.timetable-grid tr').forEach(tr => {
                const rowText = (tr.firstElementChild?.textContent || '').trim().toLowerCase();
                const isSelasa = rowText.startsWith('sel');
                const boxes = Array.from(tr.querySelectorAll('a, .subject-box'));

                boxes.forEach((box, idx) => {
                    const href = box.getAttribute('href') || '';
                    const mId = href.match(/\/(?:mapel|subject)\/(\d+)/i);
                    const serverNotif = (mId && typeof SERVER_SUBJECT_NOTIFS !== 'undefined') ? SERVER_SUBJECT_NOTIFS[mId[1]] : null;

                    if (window.innerWidth > 640 && box.dataset.desktopFormatted !== '1') {
                        const rawText = (box.textContent || '').trim();
                        const lower = rawText.toLowerCase();
                        let matched = null;

                        // Khusus hari Selasa kotak terakhir (setelah KTS), wajib STI (Samsung Tech Institute)
                        if (isSelasa && idx === boxes.length - 1 && (lower === 'si' || lower.includes('sejarah') || lower.includes('sti'))) {
                            matched = { code: 'STI', full: 'Samsung Tech Institute' };
                        } else if (lower) {
                            matched = subjectDict.find(item =>
                                item.keys.some(k => {
                                    if (lower === k) return true;
                                    if (k.length <= 3) {
                                        const esc = k.replace(/[.*+?^${}()|[\]\\]/g, '\\function formatDesktopSubjectLabels() {
            if (window.innerWidth <= 640) return;

            const subjectDict = [
                { keys: ['ketamansiswaan', 'kts'], code: 'KTS', full: 'Ketamansiswaan' },
                { keys: ['samsung tech institute', 'sti'], code: 'STI', full: 'Samsung Tech Institute' },
                { keys: ['bimbingan dan konseling', 'bimbingan konseling', 'bk'], code: 'BK', full: 'Bimbingan & Konseling' },
                { keys: ['kreativitas & desain interaktif', 'kreativitas dan desain interaktif', 'kdi'], code: 'KDI', full: 'Kreativitas & Desain Interaktif' },
                { keys: ['muatan bahasa jepang', 'bahasa jepang', 'mbj'], code: 'MBJ(J)', full: 'Muatan Bahasa Jepang' },
                { keys: ['pendidikan pancasila', 'ppkn', 'pp'], code: 'PP', full: 'Pendidikan Pancasila' },
                { keys: ['bahasa inggris', 'b.ing'], code: 'B.Ing', full: 'Bahasa Inggris' },
                { keys: ['bahasa indonesia', 'bi'], code: 'BI', full: 'Bahasa Indonesia' },
                { keys: ['matematika', 'mtk'], code: 'MTK', full: 'Matematika' },
                { keys: ['pendidikan jasmani', 'pjok', 'penjas'], code: 'Penjas', full: 'Pendidikan Jasmani' },
                { keys: ['pemrograman lanjut', 'pl(rpl1)', 'pl'], code: 'PL(RPL1)', full: 'Pemrograman Lanjut' },
                { keys: ['sejarah indonesia', 'sejarah', 'si'], code: 'SI', full: 'Sejarah Indonesia' },
                { keys: ['kewirausahaan', 'pkk', 'kwh'], code: 'KWH', full: 'Kewirausahaan' },
                { keys: ['pendidikan agama islam', 'pai'], code: 'PAI', full: 'Pendidikan Agama Islam' }
            ];

            document.querySelectorAll('.timetable-grid a, .timetable-grid .subject-box').forEach(box => {
                if (box.dataset.desktopFormatted === '1') return;

                const rawText = (box.textContent || '').trim();
                const lower = rawText.toLowerCase();
                if (!lower) return;

                const matched = subjectDict.find(item =>
                    item.keys.some(k => {
                        if (lower === k) return true;
                        if (k.length <= 3) {
                            const escaped = k.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                            return new RegExp('(?:^|[^a-z0-9])' + escaped + '(?:$|[^a-z0-9])', 'i').test(lower);
                        }
                        return lower.includes(k);
                    })
                );

                if (matched) {
                    box.dataset.desktopFormatted = '1';
                    box.title = `${matched.code} - ${matched.full}`;

                    // Pertahankan elemen indikator / dot / badge jika ada
                    const preserved = Array.from(box.querySelectorAll('.rounded-full, .event-grayred-badge, .mobile-notif-dot'));
                    box.innerHTML = '';

                    const codeEl = document.createElement('div');
                    codeEl.className = 'font-extrabold text-xs sm:text-sm leading-tight tracking-tight';
                    codeEl.textContent = matched.code;

                    const subEl = document.createElement('div');
                    subEl.className = 'text-[9.5px] opacity-75 leading-tight line-clamp-1 max-w-full px-1';
                    subEl.textContent = matched.full;

                    box.appendChild(codeEl);
                    box.appendChild(subEl);
                    preserved.forEach(el => box.appendChild(el));
                }
            });
        }');
                                        return new RegExp('(?:^|[^a-z0-9])' + esc + '(?:$|[^a-z0-9])', 'i').test(lower);
                                    }
                                    return lower.includes(k);
                                })
                            );
                        }

                        if (matched) {
                            box.dataset.desktopFormatted = '1';
                            box.style.position = 'relative';
                            box.title = `${matched.code} - ${matched.full}`;
                            box.innerHTML = `
                                <div class="font-extrabold text-xs sm:text-sm leading-tight tracking-tight">${matched.code}</div>
                                <div class="text-[9.5px] opacity-75 leading-tight line-clamp-1 max-w-full px-1">${matched.full}</div>
                            `;
                        }
                    }

                    // Pastikan titik indikator notifikasi selalu tampil di pojok kanan atas jika mapel punya item aktif
                    if (serverNotif && !box.querySelector('.notif-corner-dot')) {
                        box.style.position = 'relative';
                        const dot = document.createElement('span');
                        dot.className = 'notif-corner-dot rounded-full';
                        dot.style.cssText = 'position:absolute;top:5px;right:5px;width:8px;height:8px;border-radius:9999px;background:' + serverNotif.dot + ';box-shadow:0 0 6px ' + serverNotif.dot + ';z-index:10;';
                        box.appendChild(dot);
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', formatDesktopSubjectLabels);
        window.addEventListener('resize', formatDesktopSubjectLabels);
            

<!-- GLOBAL-UI-ENGINE-START -->
<style id="brutal-global-ui-css">
    :root {
        --bg-main: #090d16;
        --card-bg: #111827;
        --soft-bg: #1e293b;
        --input-bg: #0f172a;
        --border-sub: rgba(148, 163, 184, 0.22);
        --text-main: #f8fafc;
        --text-sub: #cbd5e1;
    }

    body {
        font-size: 14px;
        line-height: 1.5;
        color: var(--text-main);
    }

    html[data-theme="mode-gelap"] body { background: linear-gradient(135deg, #090d16 0%, #111827 60%, #090d16 100%) !important; color: #f8fafc !important; }
    html[data-theme="academic-trust"] body { background: linear-gradient(135deg, #0b132b 0%, #1c2541 60%, #0f172a 100%) !important; color: #f8fafc !important; }
    html[data-theme="deep-ocean"] body { background: linear-gradient(135deg, #041c2c 0%, #0a3656 60%, #06283d 100%) !important; color: #f0f9ff !important; }
    html[data-theme="midnight-scholar"] body { background: linear-gradient(135deg, #0f0c29 0%, #302b63 60%, #1a163a 100%) !important; color: #f5f3ff !important; }
    html[data-theme="forest-academy"] body { background: linear-gradient(135deg, #062118 0%, #0d3b2e 60%, #082920 100%) !important; color: #ecfdf5 !important; }

    html[data-theme="tech-growth"] body { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 60%, #e0f2fe 100%) !important; color: #064e3b !important; }
    html[data-theme="creative-spark"] body { background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 60%, #fef3c7 100%) !important; color: #7c2d12 !important; }
    html[data-theme="lavender-dream"] body { background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 55%, #fae8ff 100%) !important; color: #4c1d95 !important; }
    html[data-theme="soft-berry"] body { background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 55%, #fce7f3 100%) !important; color: #881337 !important; }
    html[data-theme="morning-assembly"] body { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 55%, #f1f5f9 100%) !important; color: #0f172a !important; }

    html[data-theme="tech-growth"] .theme-card,
    html[data-theme="creative-spark"] .theme-card,
    html[data-theme="lavender-dream"] .theme-card,
    html[data-theme="soft-berry"] .theme-card,
    html[data-theme="morning-assembly"] .theme-card {
        background: rgba(255, 255, 255, 0.9) !important;
        color: #0f172a !important;
        border-color: rgba(15, 23, 42, 0.16) !important;
    }

    html[data-graphic="legacy"] .theme-card { border-radius: 4px !important; border-width: 2px !important; box-shadow: 4px 4px 0 rgba(0,0,0,0.5) !important; }
    html[data-graphic="minimalist"] .theme-card { border-radius: 10px !important; box-shadow: none !important; backdrop-filter: none !important; }
    html[data-graphic="simple"] .theme-card { border-radius: 14px !important; }

    html[data-anim="off"] *, html[data-anim="off"] *::before, html[data-anim="off"] *::after {
        animation: none !important;
        transition: none !important;
    }

    html[data-font="modern"] body, html[data-font="modern"] * { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif; }
    html[data-font="serif"] body, html[data-font="serif"] * { font-family: Georgia, 'Times New Roman', serif !important; }
    html[data-font="mono"] body, html[data-font="mono"] * { font-family: 'JetBrains Mono', 'Fira Code', Consolas, monospace !important; }

    nav a, nav button { font-size: 13.5px; line-height: 1.35; white-space: nowrap; }

    /* HP Schedule: pastikan isi mapel tidak blank & muat 1 layar */
    @media (max-width: 640px) {
        main table { width: 100% !important; table-layout: fixed !important; border-collapse: separate !important; border-spacing: 1.5px !important; }
        main table th:first-child, main table td:first-child {
            width: 40px !important; min-width: 40px !important; max-width: 40px !important;
            font-size: 8px !important; padding: 2px 1px !important; white-space: nowrap !important; overflow: visible !important;
        }
        main table a[href*="/mapel/"], main table a[href*="/subject/"] {
            display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important;
            min-height: 38px !important; height: 38px !important; padding: 2px 1px !important;
            font-size: 7.5px !important; line-height: 1.1 !important; overflow: visible !important;
        }
        main table a[href*="/mapel/"] *, main table a[href*="/subject/"] * {
            display: block !important; visibility: visible !important; opacity: 1 !important;
        }
    }
</style>

<script id="brutal-global-ui-js">
(function () {
    const applySavedPrefs = () => {
        document.documentElement.setAttribute('data-theme', localStorage.getItem('app_theme') || 'mode-gelap');
        document.documentElement.setAttribute('data-graphic', localStorage.getItem('app_graphic') || 'simple');
        document.documentElement.setAttribute('data-font', localStorage.getItem('app_font') || 'modern');
        document.documentElement.setAttribute('data-anim', localStorage.getItem('app_anim') || 'on');
    };
    applySavedPrefs();

    window.setAppTheme = function (slug) {
        localStorage.setItem('app_theme', slug);
        document.documentElement.setAttribute('data-theme', slug);
    };
    window.setAppGraphic = function (slug) {
        localStorage.setItem('app_graphic', slug);
        document.documentElement.setAttribute('data-graphic', slug);
    };
    window.setAppFont = function (slug) {
        localStorage.setItem('app_font', slug);
        document.documentElement.setAttribute('data-font', slug);
    };
    window.toggleAppAnim = function () {
        const nxt = (document.documentElement.getAttribute('data-anim') || 'on') === 'on' ? 'off' : 'on';
        localStorage.setItem('app_anim', nxt);
        document.documentElement.setAttribute('data-anim', nxt);
        return nxt;
    };

    const DICT = {
        en: {
            'Jadwal': 'Schedule', 'List Tugas': 'Task List', 'Kalender': 'Calendar', 'Siswa': 'Students',
            'Nmr Guru': 'Teachers', 'Materi': 'Materials', 'Latihan': 'Practice', 'Profil': 'Profile',
            'Pengaturan': 'Settings', 'Komok': 'Komok',
            'JADWAL XI RPL 1': 'XI RPL 1 SCHEDULE',
            'Catatan': 'Notes', 'Tugas': 'Tasks', 'PR': 'Homework', 'Event': 'Event',
            'Tenggat': 'Due Soon', 'Deadline': 'Overdue', 'Selesai': 'Completed', 'Reset': 'Reset',
            'Pengaturan Tampilan': 'Display Settings',
            'Sesuaikan tema gradien warna, gaya grafik, animasi, suara efek, musik kelas, dan bahasa aplikasi.': 'Customize gradient themes, graphic styles, animations, sound effects, class music, and app language.',
            'â† Kembali ke Jadwal Utama': 'â† Back to Main Schedule',
            'TEMA GELAP (GRADIEN)': 'DARK THEMES (GRADIENT)', 'TEMA TERANG (GRADIEN)': 'LIGHT THEMES (GRADIENT)',
            'GRAFIK & ANIMASI': 'GRAPHICS & ANIMATION', 'Animasi Transisi UI': 'UI Transition Animation',
            'GAYA HURUF': 'FONT STYLE', 'EFEK SUARA (SFX)': 'SOUND EFFECTS (SFX)', 'BAHASA': 'LANGUAGE',
            'Pemutar Musik Kelas': 'Class Music Player', 'List Tugas & Catatan Kelas': 'Class Task & Note List',
            'Semua': 'All', 'Buka & Komentar': 'Open & Comment', 'Tandai Selesai': 'Mark Completed',
            'Hari / Jam': 'Day / Time', 'Senin': 'Monday', 'Selasa': 'Tuesday', 'Rabu': 'Wednesday', 'Kamis': 'Thursday', 'Jumat': 'Friday'
        },
        ja: {
            'Jadwal': 'æ™‚é–“å‰²', 'List Tugas': 'èª²é¡Œä¸€è¦§', 'Kalender': 'ã‚«ãƒ¬ãƒ³ãƒ€ãƒ¼', 'Siswa': 'ç”Ÿå¾’ä¸€è¦§',
            'Nmr Guru': 'å…ˆç”Ÿé€£çµ¡å…ˆ', 'Materi': 'æ•™æ', 'Latihan': 'ç·´ç¿’å•é¡Œ', 'Profil': 'ãƒ—ãƒ­ãƒ•ã‚£ãƒ¼ãƒ«',
            'Pengaturan': 'è¨­å®š', 'Komok': 'ã‚³ãƒ¢ãƒƒã‚¯',
            'JADWAL XI RPL 1': 'XI RPL 1 æ™‚é–“å‰²',
            'Catatan': 'ãƒŽãƒ¼ãƒˆ', 'Tugas': 'èª²é¡Œ', 'PR': 'å®¿é¡Œ', 'Event': 'ã‚¤ãƒ™ãƒ³ãƒˆ',
            'Tenggat': 'ç· åˆ‡é–“è¿‘', 'Deadline': 'æœŸé™åˆ‡ã‚Œ', 'Selesai': 'å®Œäº†', 'Reset': 'ãƒªã‚»ãƒƒãƒˆ',
            'Pengaturan Tampilan': 'è¡¨ç¤ºè¨­å®š', 'â† Kembali ke Jadwal Utama': 'â† æ™‚é–“å‰²ã«æˆ»ã‚‹',
            'TEMA GELAP (GRADIEN)': 'ãƒ€ãƒ¼ã‚¯ãƒ†ãƒ¼ãƒž', 'TEMA TERANG (GRADIEN)': 'ãƒ©ã‚¤ãƒˆãƒ†ãƒ¼ãƒž',
            'GRAFIK & ANIMASI': 'ã‚°ãƒ©ãƒ•ã‚£ãƒƒã‚¯ã¨ã‚¢ãƒ‹ãƒ¡ãƒ¼ã‚·ãƒ§ãƒ³', 'GAYA HURUF': 'ãƒ•ã‚©ãƒ³ãƒˆã‚¹ã‚¿ã‚¤ãƒ«',
            'BAHASA': 'è¨€èªžè¨­å®š', 'Pemutar Musik Kelas': 'ã‚¯ãƒ©ã‚¹éŸ³æ¥½ãƒ—ãƒ¬ã‚¤ãƒ¤ãƒ¼',
            'Hari / Jam': 'æ›œæ—¥ / æ™‚é™', 'Senin': 'æœˆæ›œ', 'Selasa': 'ç«æ›œ', 'Rabu': 'æ°´æ›œ', 'Kamis': 'æœ¨æ›œ', 'Jumat': 'é‡‘æ›œ'
        },
        ru: {
            'Jadwal': 'Ð Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ', 'List Tugas': 'Ð—Ð°Ð´Ð°Ð½Ð¸Ñ', 'Kalender': 'ÐšÐ°Ð»ÐµÐ½Ð´Ð°Ñ€ÑŒ', 'Siswa': 'Ð£Ñ‡ÐµÐ½Ð¸ÐºÐ¸',
            'Nmr Guru': 'Ð£Ñ‡Ð¸Ñ‚ÐµÐ»Ñ', 'Materi': 'ÐœÐ°Ñ‚ÐµÑ€Ð¸Ð°Ð»Ñ‹', 'Latihan': 'Ð¢ÐµÑÑ‚Ñ‹', 'Profil': 'ÐŸÑ€Ð¾Ñ„Ð¸Ð»ÑŒ',
            'Pengaturan': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸', 'Komok': 'ÐšÐ¾Ð¼Ð¾Ðº',
            'JADWAL XI RPL 1': 'Ð ÐÐ¡ÐŸÐ˜Ð¡ÐÐÐ˜Ð• XI RPL 1',
            'Catatan': 'Ð—Ð°Ð¼ÐµÑ‚ÐºÐ¸', 'Tugas': 'Ð—Ð°Ð´Ð°Ð½Ð¸Ñ', 'PR': 'Ð”Ð—', 'Event': 'Ð¡Ð¾Ð±Ñ‹Ñ‚Ð¸Ñ',
            'Tenggat': 'Ð¡ÐºÐ¾Ñ€Ð¾ ÑÑ€Ð¾Ðº', 'Deadline': 'ÐŸÑ€Ð¾ÑÑ€Ð¾Ñ‡ÐµÐ½Ð¾', 'Selesai': 'Ð“Ð¾Ñ‚Ð¾Ð²Ð¾', 'Reset': 'Ð¡Ð±Ñ€Ð¾Ñ',
            'Pengaturan Tampilan': 'ÐÐ°ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸ ÑÐºÑ€Ð°Ð½Ð°', 'â† Kembali ke Jadwal Utama': 'â† ÐÐ°Ð·Ð°Ð´ Ðº Ñ€Ð°ÑÐ¿Ð¸ÑÐ°Ð½Ð¸ÑŽ',
            'TEMA GELAP (GRADIEN)': 'Ð¢ÐÐœÐÐ«Ð• Ð¢Ð•ÐœÐ«', 'TEMA TERANG (GRADIEN)': 'Ð¡Ð’Ð•Ð¢Ð›Ð«Ð• Ð¢Ð•ÐœÐ«',
            'GRAFIK & ANIMASI': 'Ð“Ð ÐÐ¤Ð˜ÐšÐ Ð˜ ÐÐÐ˜ÐœÐÐ¦Ð˜Ð¯', 'GAYA HURUF': 'Ð¡Ð¢Ð˜Ð›Ð¬ Ð¨Ð Ð˜Ð¤Ð¢Ð',
            'BAHASA': 'Ð¯Ð—Ð«Ðš', 'Pemutar Musik Kelas': 'ÐœÑƒÐ·Ñ‹ÐºÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ð¿Ð»ÐµÐµÑ€ ÐºÐ»Ð°ÑÑÐ°',
            'Hari / Jam': 'Ð”ÐµÐ½ÑŒ / Ð£Ñ€Ð¾Ðº', 'Senin': 'ÐŸÐ½', 'Selasa': 'Ð’Ñ‚', 'Rabu': 'Ð¡Ñ€', 'Kamis': 'Ð§Ñ‚', 'Jumat': 'ÐŸÑ‚'
        }
    };

    window.applyLanguage = function (lang) {
        const dict = DICT[lang] || null;
        const keys = dict ? Object.keys(dict).sort((a, b) => b.length - a.length) : [];
        const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null);
        let n;
        while ((n = walker.nextNode())) {
            const p = n.parentElement;
            if (!p || ['SCRIPT', 'STYLE', 'TEXTAREA', 'INPUT'].includes(p.tagName)) continue;
            if (n._baseText === undefined) n._baseText = n.nodeValue;
            if (!dict) {
                n.nodeValue = n._baseText;
                continue;
            }
            let out = n._baseText;
            for (const k of keys) {
                if (out.includes(k)) out = out.split(k).join(dict[k]);
            }
            n.nodeValue = out;
        }
    };

    function normalizeScheduleBoxes() {
        const isMobile = window.innerWidth <= 640;
        const mapelList = [
            { keys: ['ketamansiswaan', 'etamansiswaan', 'kts'], code: 'KTS', full: 'Ketamansiswaan' },
            { keys: ['samsung tech institute', 'Samsung Tech Institute', 'sti'], code: 'STI', full: 'Samsung Tech Institute' },
            { keys: ['bimbingan dan konseling', 'bimbingan konseling', 'bk'], code: 'BK', full: 'Bimbingan & Konseling' },
            { keys: ['kreativitas & desain interaktif', 'kreativitas dan desain interaktif', 'kdi'], code: 'KDI', full: 'Kreativitas & Desain Interaktif' },
            { keys: ['muatan bahasa jepang', 'bahasa jepang', 'mbj'], code: 'MBJ(J)', full: 'Muatan Bahasa Jepang' },
            { keys: ['pendidikan pancasila', 'ppkn', 'pp'], code: 'PP', full: 'Pendidikan Pancasila' },
            { keys: ['bahasa inggris', 'b.ing'], code: 'B.Ing', full: 'Bahasa Inggris' },
            { keys: ['bahasa indonesia', 'bi'], code: 'BI', full: 'Bahasa Indonesia' },
            { keys: ['matematika', 'mtk'], code: 'MTK', full: 'Matematika' },
            { keys: ['pendidikan jasmani', 'pjok', 'penjas'], code: 'Penjas', full: 'Pendidikan Jasmani' },
            { keys: ['pemrograman lanjut', 'pl(rpl1)', 'pl'], code: 'PL(RPL1)', full: 'Pemrograman Lanjut' },
            { keys: ['sejarah indonesia', 'sejarah'], code: 'SI', full: 'Sejarah Indonesia' },
            { keys: ['kewirausahaan', 'pkk', 'kwh'], code: 'KWH', full: 'Kewirausahaan' },
            { keys: ['pendidikan agama islam', 'pai'], code: 'PAI', full: 'Pendidikan Agama Islam' }
        ];

        document.querySelectorAll('table tr').forEach(tr => {
            const dayTxt = (tr.firstElementChild?.textContent || '').trim().toLowerCase();
            const isSelasa = dayTxt.startsWith('sel');
            const boxes = Array.from(tr.querySelectorAll('a[href*="/mapel/"], a[href*="/subject/"]'));

            boxes.forEach((box, idx) => {
                const origTxt = box.dataset.origLabel || (box.textContent || '').replace(/\s+/g, ' ').trim();
                box.dataset.origLabel = origTxt;
                const lower = origTxt.toLowerCase();

                let hit = null;
                if (isSelasa && idx === boxes.length - 1) {
                    hit = { code: 'STI', full: 'Samsung Tech Institute' };
                } else {
                    hit = mapelList.find(m => m.keys.some(k => lower.includes(k)));
                }

                if (hit) {
                    const dots = Array.from(box.querySelectorAll('.rounded-full, .event-grayred-badge, .notif-corner-dot'));
                    box.style.position = 'relative';
                    if (isMobile) {
                        box.innerHTML = '<span class="font-extrabold leading-none">' + hit.code + '</span>';
                    } else {
                        box.innerHTML = '<div class="font-extrabold text-sm leading-tight">' + hit.code + '</div><div class="text-[10px] opacity-75 leading-tight truncate max-w-full px-1">' + hit.full + '</div>';
                    }
                    dots.forEach(d => box.appendChild(d));
                } else if (isMobile && origTxt) {
                    const dots = Array.from(box.querySelectorAll('.rounded-full, .event-grayred-badge, .notif-corner-dot'));
                    box.innerHTML = '<span class="font-extrabold leading-none">' + origTxt + '</span>';
                    dots.forEach(d => box.appendChild(d));
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('nav a').forEach(a => {
            const t = (a.textContent || '').replace(/\s+/g, ' ').trim();
            if (/^\(\d+\)\s*Tugas$/i.test(t) || /list-tugas/i.test(a.getAttribute('href') || '')) {
                a.textContent = 'List Tugas';
            }
        });

        normalizeScheduleBoxes();

        const curLang = localStorage.getItem('app_lang') || 'id';
        if (curLang !== 'id') window.applyLanguage(curLang);
    });

    window.addEventListener('resize', normalizeScheduleBoxes);
})();
</script>
<!-- GLOBAL-UI-ENGINE-END -->
{{-- [PATCH START] Fix Bell Notification & Appearance Sync --}}
<style>
  [data-notif-bell], .notif-bell, .notification-bell, #notifBell, a[href*="notifikasi"], button[data-target*="notif"] {
    position: relative !important;
    z-index: 9999 !important;
    pointer-events: auto !important;
    cursor: pointer !important;
  }
  body.theme-deep-ocean { --bg-main: #07131f; --bg-card: #0e2236; --accent-main: #0ea5e9; }
  body.theme-midnight-scholar { --bg-main: #0b0f19; --bg-card: #151c2c; --accent-main: #6366f1; }
  body.theme-forest-academy { --bg-main: #071712; --bg-card: #0f2920; --accent-main: #10b981; }
  body.theme-mode-gelap { --bg-main: #09090b; --bg-card: #18181b; --accent-main: #3b82f6; }
  body.theme-teal-growth { --bg-main: #f0fdfa; --bg-card: #ffffff; --accent-main: #0d9488; }
  body.font-coding-mono, body.font-coding-mono * { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important; }
  body.font-klasik-serif, body.font-klasik-serif * { font-family: Georgia, Cambria, "Times New Roman", Times, serif !important; }
  body.font-modern-sans, body.font-modern-sans * { font-family: Inter, system-ui, -apple-system, sans-serif !important; }
</style>
<script>
(function () {
  const slugify = (str) => (str || "").toLowerCase().trim().replace(/[^a-z0-9]+/g, "-").replace(/^-|-$/g, "");

  // 1. Terapkan state tersimpan dari localStorage saat halaman dimuat
  const savedTheme = localStorage.getItem("ui_theme_slug");
  const savedFont  = localStorage.getItem("ui_font_slug");
  const savedLang  = localStorage.getItem("ui_lang_code");

  if (savedTheme) document.body.classList.add("theme-" + savedTheme);
  if (savedFont)  document.body.classList.add("font-" + savedFont);
  if (savedLang)  document.documentElement.setAttribute("lang", savedLang);

  // 2. Tangkap klik tombol tema / font / bahasa di halaman pengaturan
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("button, [role='button'], .option-btn, .theme-btn, .font-btn, .lang-btn");
    if (!btn) return;

    const text = (btn.innerText || "").trim();
    const lower = text.toLowerCase();

    // Deteksi bahasa
    const langMap = {
      "indonesia": "id",
      "english": "en",
      "日本語": "ja",
      "jepang": "ja",
      "русский": "ru"
    };
    for (const [k, code] of Object.entries(langMap)) {
      if (lower.includes(k.toLowerCase())) {
        localStorage.setItem("ui_lang_code", code);
        document.documentElement.setAttribute("lang", code);
        const url = new URL(window.location.href);
        if (url.searchParams.get("lang") !== code) {
          url.searchParams.set("lang", code);
          window.location.href = url.toString();
        }
        return;
      }
    }

    // Deteksi font
    if (["modern sans", "klasik serif", "coding mono"].some(f => lower.includes(f))) {
      const fSlug = slugify(text.split("\n")[0]);
      localStorage.setItem("ui_font_slug", fSlug);
      [...document.body.classList].filter(c => c.startsWith("font-")).forEach(c => document.body.classList.remove(c));
      document.body.classList.add("font-" + fSlug);
      return;
    }

    // Deteksi tema
    if (["deep ocean", "midnight scholar", "forest academy", "mode gelap", "teal growth", "creative spark", "lavender dream", "soft berry", "morning assembly"].some(t => lower.includes(t))) {
      const tSlug = slugify(text.split("\n")[0]);
      localStorage.setItem("ui_theme_slug", tSlug);
      [...document.body.classList].filter(c => c.startsWith("theme-")).forEach(c => document.body.classList.remove(c));
      document.body.classList.add("theme-" + tSlug);
    }
  }, true);

  // 3. Perbaiki tombol lonceng notifikasi yang tidak merespons klik
  document.addEventListener("click", function (e) {
    const bell = e.target.closest("[data-notif-bell], .notif-bell, .notification-bell, #notifBell, a[href*='notifikasi'], a[href*='notif']");
    if (!bell) return;

    // Cari dropdown/panel notifikasi terdekat bila ada
    const panel = document.querySelector("#notifDropdown, .notif-dropdown, .notification-dropdown, [data-notif-panel]");
    if (panel) {
      e.preventDefault();
      e.stopPropagation();
      panel.classList.toggle("hidden");
      panel.classList.toggle("d-none");
      panel.classList.toggle("show");
      panel.style.display = (getComputedStyle(panel).display === "none") ? "block" : "none";
      return;
    }

    // Fallback ke route /notifikasi jika elemen berupa button tanpa href
    if (bell.tagName === "BUTTON" && !bell.getAttribute("href")) {
      window.location.href = "/notifikasi";
    }
  }, true);
})();
</script>
{{-- [PATCH END] --}}

<!-- SCHEDULE-NAV-CLEAN-START -->
<script id="schedule-nav-clean-js">
(function () {
    const subjectMap = [
        { keys: ['ketamansiswaan', 'etamansiswaan', 'kts'], code: 'KTS', full: 'Ketamansiswaan' },
        { keys: ['samsung tech institute', 'sti'], code: 'STI', full: 'Samsung Tech Institute' },
        { keys: ['bimbingan dan konseling', 'bimbingan konseling', 'bk'], code: 'BK', full: 'Bimbingan & Konseling' },
        { keys: ['kreativitas & desain interaktif', 'kreativitas dan desain interaktif', 'kdi'], code: 'KDI', full: 'Kreativitas & Desain Interaktif' },
        { keys: ['muatan bahasa jepang', 'bahasa jepang', 'mbj'], code: 'MBJ(J)', full: 'Muatan Bahasa Jepang' },
        { keys: ['pendidikan pancasila', 'ppkn', 'pp'], code: 'PP', full: 'Pendidikan Pancasila' },
        { keys: ['bahasa inggris', 'b.ing'], code: 'B.Ing', full: 'Bahasa Inggris' },
        { keys: ['bahasa indonesia', 'bi'], code: 'BI', full: 'Bahasa Indonesia' },
        { keys: ['matematika', 'mtk'], code: 'MTK', full: 'Matematika' },
        { keys: ['pendidikan jasmani', 'pjok', 'penjas'], code: 'Penjas', full: 'Pendidikan Jasmani' },
        { keys: ['pemrograman lanjut', 'pl(rpl1)', 'pl'], code: 'PL(RPL1)', full: 'Pemrograman Lanjut' },
        { keys: ['sejarah indonesia', 'sejarah'], code: 'SI', full: 'Sejarah Indonesia' },
        { keys: ['kewirausahaan', 'pkk', 'kwh'], code: 'KWH', full: 'Kewirausahaan' },
        { keys: ['pendidikan agama islam', 'pai'], code: 'PAI', full: 'Pendidikan Agama Islam' }
    ];

    function normalizeScheduleAndNav() {
        document.querySelectorAll('nav a').forEach(a => {
            const txt = (a.textContent || '').replace(/\s+/g, ' ').trim();
            if (/^\(\d+\)\s*Tugas$/i.test(txt) || /list-tugas/i.test(a.getAttribute('href') || '')) {
                a.textContent = 'List Tugas';
            }
        });

        const isMobile = window.innerWidth <= 640;

        document.querySelectorAll('main table tr').forEach(tr => {
            const dayTxt = (tr.firstElementChild?.textContent || '').trim().toLowerCase();
            const isSelasa = dayTxt.startsWith('sel');
            const boxes = Array.from(tr.querySelectorAll('a[href*="/mapel/"], a[href*="/subject/"]'));

            boxes.forEach((box, idx) => {
                const orig = box.dataset.cleanOrig || (box.textContent || '').replace(/\s+/g, ' ').trim();
                box.dataset.cleanOrig = orig;
                const lower = orig.toLowerCase();

                let match = null;
                if (isSelasa && idx === boxes.length - 1) {
                    match = { code: 'STI', full: 'Samsung Tech Institute' };
                } else {
                    match = subjectMap.find(item => item.keys.some(k => lower.includes(k)));
                }

                const badges = Array.from(box.querySelectorAll('.rounded-full, .event-grayred-badge, .notif-corner-dot'));
                box.style.position = 'relative';

                if (match) {
                    if (isMobile) {
                        box.innerHTML = '<span class="font-extrabold leading-none">' + match.code + '</span>';
                    } else {
                        box.innerHTML = '<div class="font-extrabold text-sm leading-tight">' + match.code + '</div><div class="text-[10px] opacity-75 leading-tight truncate max-w-full px-1">' + match.full + '</div>';
                    }
                    badges.forEach(b => box.appendChild(b));
                } else if (isMobile && orig) {
                    box.innerHTML = '<span class="font-extrabold leading-none">' + orig + '</span>';
                    badges.forEach(b => box.appendChild(b));
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', normalizeScheduleAndNav);
    window.addEventListener('resize', normalizeScheduleAndNav);
})();
</script>
<!-- SCHEDULE-NAV-CLEAN-END -->

<!-- FINAL-CLEAN-SCHEDULE-BELL-START -->
<script id="final-clean-schedule-bell-js">
(function () {
    const mapelList = [
        { keys: ['ketamansiswaan', 'etamansiswaan', 'ketamansiswaa', 'kts'], code: 'KTS', full: 'Ketamansiswaan' },
        { keys: ['samsung tech institute', 'sti'], code: 'STI', full: 'Samsung Tech Institute' },
        { keys: ['bimbingan dan konseling', 'bimbingan konseling', 'bk'], code: 'BK', full: 'Bimbingan & Konseling' },
        { keys: ['kreativitas & desain interaktif', 'kreativitas dan desain interaktif', 'kdi'], code: 'KDI', full: 'Kreativitas & Desain Interaktif' },
        { keys: ['muatan bahasa jepang', 'bahasa jepang', 'mbj'], code: 'MBJ(J)', full: 'Muatan Bahasa Jepang' },
        { keys: ['pendidikan pancasila', 'ppkn', 'pp'], code: 'PP', full: 'Pendidikan Pancasila' },
        { keys: ['bahasa inggris', 'b.ing'], code: 'B.Ing', full: 'Bahasa Inggris' },
        { keys: ['bahasa indonesia', 'bi'], code: 'BI', full: 'Bahasa Indonesia' },
        { keys: ['matematika', 'mtk'], code: 'MTK', full: 'Matematika' },
        { keys: ['pendidikan jasmani', 'pjok', 'penjas'], code: 'Penjas', full: 'Pendidikan Jasmani' },
        { keys: ['pemrograman lanjut', 'pl(rpl1)', 'pl'], code: 'PL(RPL1)', full: 'Pemrograman Lanjut' },
        { keys: ['sejarah indonesia', 'sejarah'], code: 'SI', full: 'Sejarah Indonesia' },
        { keys: ['kewirausahaan', 'pkk', 'kwh'], code: 'KWH', full: 'Kewirausahaan' },
        { keys: ['pendidikan agama islam', 'pai'], code: 'PAI', full: 'Pendidikan Agama Islam' }
    ];

    function initScheduleAndBell() {
        document.querySelectorAll('nav a').forEach(a => {
            const t = (a.textContent || '').replace(/\s+/g, ' ').trim();
            if (/^\(\d+\)\s*Tugas$/i.test(t) || /list-tugas/i.test(a.getAttribute('href') || '')) {
                a.textContent = 'List Tugas';
            }
        });

        const isMobile = window.innerWidth <= 640;

        document.querySelectorAll('main table tr').forEach(tr => {
            const dayTxt = (tr.firstElementChild?.textContent || '').trim().toLowerCase();
            const isSelasa = dayTxt.startsWith('sel');
            const boxes = Array.from(tr.querySelectorAll('a[href*="/mapel/"], a[href*="/subject/"]'));

            boxes.forEach((box, idx) => {
                // Simpan badge/dot/ikon asli kotak jadwal agar tidak hilang
                if (!box.dataset.origBadgesHtml) {
                    const badgeNodes = Array.from(box.querySelectorAll('span.rounded-full, div.rounded-full, .event-grayred-badge, .notif-corner-dot, [data-badge]'));
                    box.dataset.origBadgesHtml = badgeNodes.map(el => el.outerHTML).join('');
                }
                const rawFull = box.dataset.rawScheduleText || (box.innerText || box.textContent || '').replace(/\s+/g, ' ').trim();
                box.dataset.rawScheduleText = rawFull;
                const lower = rawFull.toLowerCase();

                let match = null;
                if (isSelasa && idx === boxes.length - 1) {
                    match = { code: 'STI', full: 'Samsung Tech Institute' };
                } else {
                    match = mapelList.find(m => m.keys.some(k => lower.includes(k)));
                }

                if (match) {
                    box.style.position = 'relative';
                    if (isMobile) {
                        box.innerHTML = '<span class="font-extrabold leading-none" style="font-size:8px;">' + match.code + '</span>' + (box.dataset.origBadgesHtml || '');
                    } else {
                        box.innerHTML = '<div class="font-extrabold text-sm leading-tight">' + match.code + '</div><div class="text-[10px] opacity-75 leading-tight truncate max-w-full px-1">' + match.full + '</div>' + (box.dataset.origBadgesHtml || '');
                    }
                }
            });
        });

        // Tombol lonceng notifikasi: pastikan bisa dibuka/ditutup & badge angka hilang saat diklik
        const bellBtn = document.getElementById('notif-bell-btn') || Array.from(document.querySelectorAll('nav button')).find(b => b.querySelector('svg') && b.querySelector('span'));
        if (bellBtn) {
            const parentWrap = bellBtn.parentElement;
            const dropdown = document.getElementById('notif-dropdown') || document.getElementById('notif-menu') || (parentWrap ? parentWrap.querySelector('div[class*="absolute"], ul[class*="absolute"]') : null);
            const badge = bellBtn.querySelector('span');

            const getSig = () => dropdown ? Array.from(dropdown.querySelectorAll('a, li')).map(x => (x.textContent || '').trim()).join('|') : '';
            const seenSig = localStorage.getItem('notif_seen_sig') || '';
            if (badge && getSig() && getSig() === seenSig) {
                badge.classList.add('hidden');
            }

            bellBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (dropdown) {
                    const willShow = dropdown.classList.contains('hidden') || getComputedStyle(dropdown).display === 'none';
                    dropdown.classList.toggle('hidden', !willShow);
                    dropdown.style.display = willShow ? 'block' : 'none';
                    dropdown.style.zIndex = '999';
                }
                const latest = getSig();
                if (latest) localStorage.setItem('notif_seen_sig', latest);
                if (badge) badge.classList.add('hidden');
            });

            document.addEventListener('click', function (e) {
                if (dropdown && !dropdown.contains(e.target) && !bellBtn.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    dropdown.style.display = 'none';
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', initScheduleAndBell);
    window.addEventListener('resize', initScheduleAndBell);
})();
</script>
<!-- FINAL-CLEAN-SCHEDULE-BELL-END -->
</body>
</html>

