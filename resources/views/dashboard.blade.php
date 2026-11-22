<x-app-layout>
<style>
    /* Paksa titik kuning (tenggat), merah (deadline), hijau (selesai) SELALU TAMPIL & TIDAK HILANG */
    @keyframes dotPulseSafe {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.22); opacity: 0.92; }
    }
    .dot-tenggat-kuning,
    [class*="yellow"],
    [class*="amber"] {
        opacity: 1 !important;
        visibility: visible !important;
    }
    .dot-tenggat-kuning {
        width: 11px !important;
        height: 11px !important;
        border-radius: 9999px !important;
        background-color: #facc15 !important;
        box-shadow: 0 0 8px #facc15, 0 0 14px rgba(250, 204, 21, 0.85) !important;
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
        box-shadow: 0 0 8px #ef4444, 0 0 14px rgba(239, 68, 68, 0.85) !important;
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
        box-shadow: 0 0 8px #22c55e, 0 0 14px rgba(34, 197, 94, 0.85) !important;
        display: inline-block !important;
        opacity: 1 !important;
        visibility: visible !important;
        z-index: 30 !important;
    }

    /* Tombol Filter Bar di atas Jadwal */
    .jadwal-filter-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }
    .j-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        border: 1.5px solid var(--border-color);
        background: rgba(15, 23, 42, 0.32);
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
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
    .j-filter-btn {
        transition: transform 0.24s cubic-bezier(0.22, 1, 0.36, 1),
                    background-color 0.24s ease,
                    color 0.24s ease,
                    border-color 0.24s ease,
                    box-shadow 0.24s ease,
                    opacity 0.24s ease !important;
        will-change: transform;
    }
    .j-filter-btn.is-unselecting {
        animation: filterUnselectPop 0.26s cubic-bezier(0.22, 1, 0.36, 1) !important;
    }
.j-filter-btn.active {
        background: var(--primary) !important;
        color: #ffffff !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 14px rgba(59, 130, 246, 0.55);
        transform: scale(1.05);
    }

    /* Efek Sorot & Redup Kotak Mapel Saat Filter Aktif */
    .mapel-dimmed {
        opacity: 0.22 !important;
        filter: grayscale(65%);
        transform: scale(0.98) !important;
    }
    .mapel-highlighted {
        opacity: 1 !important;
        transform: translateY(-2px) scale(1.03) !important;
        box-shadow: 0 0 0 2.5px #38bdf8, 0 8px 22px rgba(56, 189, 248, 0.45) !important;
        z-index: 25 !important;
    }
</style>
    <style>
        .timetable-grid {
            width: 100%;
            min-width: 960px;
            border-collapse: collapse;
            table-layout: fixed !important;
            border: 1.5px solid rgba(148, 163, 184, 0.55);
        }
        .timetable-grid th,
        .timetable-grid td {
            border: 1px solid rgba(148, 163, 184, 0.45);
            overflow: hidden;
        }
        @keyframes pulseDot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.28); opacity: 0.8; }
        }
        .alert-dot-yellow {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #facc15;
            box-shadow: 0 0 0 2px rgba(250, 204, 21, 0.35);
            animation: pulseDot 1.6s infinite;
        }
        .alert-dot-red {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.4);
            animation: pulseDot 1.2s infinite;
        }
        .subject-top-right-icons {
            position: absolute;
            top: 4px;
            right: 5px;
            display: flex;
            align-items: center;
            gap: 2px;
            z-index: 5;
        }
        .mini-kat-icon {
            font-size: 10px;
            line-height: 1;
            padding: 2px 3px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }
    </style>

    <div class="theme-card rounded-xl shadow-md p-3 sm:p-5">
        <div class="mb-3 text-center">
            <h1 class="text-xl sm:text-2xl font-bold" data-i18n="jadwal_title">Jadwal Pelajaran XI RPL 1</h1>
            <p class="text-xs sm:text-sm opacity-75" data-i18n="jadwal_sub">Klik kotak mata pelajaran untuk melihat Catatan, Tugas, PR, atau Acara.</p>

            <!-- Legenda Ikon Pojok Kanan Atas Mapel -->
            <div class="flex flex-wrap justify-center items-center gap-3 mt-2 text-[10.5px] opacity-80">
                <span>📝 Catatan</span>
                <span>📌 Tugas</span>
                <span>🏠 PR</span>
                <span>🎉 Event</span>
            </div>
        </div>

        @php
            $jamList = [
                1 => '06:45 - 07:40',
                2 => '07:40 - 08:20',
                3 => '08:20 - 09:00',
                4 => '09:00 - 09:40',
                5 => '10:00 - 10:40',
                6 => '10:40 - 11:20',
                7 => '11:20 - 12:00',
                8 => '12:30 - 13:10',
                9 => '13:10 - 13:40',
                10 => '13:40 - 14:15',
                11 => '14:15 - 14:50',
                12 => '14:50 - 15:25',
            ];
            $dayKeys = [
                'Senin' => 'day_senin',
                'Selasa' => 'day_selasa',
                'Rabu' => 'day_rabu',
                'Kamis' => 'day_kamis',
                'Jumat' => 'day_jumat',
            ];
            $katIcons = [
                'catatan' => ['icon' => '📝', 'label' => 'Catatan'],
                'tugas'   => ['icon' => '📌', 'label' => 'Tugas'],
                'pr'      => ['icon' => '🏠', 'label' => 'PR'],
                'event'   => ['icon' => '🎉', 'label' => 'Event'],
            ];
        @endphp

        

<style>
    @keyframes dotStayVisible {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.92; }
    }
    tbody td [class*="yellow"],
    tbody td [class*="amber"],
    tbody td [style*="yellow"],
    tbody td [style*="#facc15"],
    tbody td [style*="#eab308"] {
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
        background-color: #facc15 !important;
        box-shadow: 0 0 8px #facc15, 0 0 14px rgba(250, 204, 21, 0.9) !important;
        animation: dotStayVisible 1.6s ease-in-out infinite !important;
    }
    .jadwal-filter-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 12px auto 14px auto;
    }
    .j-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        border: 1.5px solid var(--border-color);
        background: rgba(15, 23, 42, 0.45);
        color: var(--text-main);
        cursor: pointer;
        user-select: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }
    body[data-theme="teal-growth"] .j-filter-btn,
    body[data-theme="creative-spark"] .j-filter-btn,
    body[data-theme="lavender-dream"] .j-filter-btn,
    body[data-theme="soft-berry"] .j-filter-btn,
    body[data-theme="morning-assembly"] .j-filter-btn {
        background: rgba(255, 255, 255, 0.92);
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
    .j-filter-btn {
        transition: transform 0.24s cubic-bezier(0.22, 1, 0.36, 1),
                    background-color 0.24s ease,
                    color 0.24s ease,
                    border-color 0.24s ease,
                    box-shadow 0.24s ease,
                    opacity 0.24s ease !important;
        will-change: transform;
    }
    .j-filter-btn.is-unselecting {
        animation: filterUnselectPop 0.26s cubic-bezier(0.22, 1, 0.36, 1) !important;
    }
.j-filter-btn.active {
        background: var(--primary) !important;
        color: #ffffff !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 14px rgba(59, 130, 246, 0.65);
        transform: scale(1.06);
    }
    .cell-dimmed {
        opacity: 0.2 !important;
        filter: grayscale(75%);
        transition: all 0.2s ease;
    }
    .cell-highlighted {
        opacity: 1 !important;
        box-shadow: inset 0 0 0 2.5px #38bdf8, 0 0 16px rgba(56, 189, 248, 0.45) !important;
        transition: all 0.2s ease;
    }
</style>

<div class="jadwal-filter-bar" id="jadwal-filter-bar">
    <button type="button" class="j-filter-btn" data-filter="catatan" onclick="toggleMultiFilter('catatan', this)">📝 Catatan</button>
    <button type="button" class="j-filter-btn" data-filter="tugas" onclick="toggleMultiFilter('tugas', this)">📌 Tugas</button>
    <button type="button" class="j-filter-btn" data-filter="pr" onclick="toggleMultiFilter('pr', this)">🏠 PR</button>
    <button type="button" class="j-filter-btn" data-filter="event" onclick="toggleMultiFilter('event', this)">🎉 Event</button>
    <button type="button" class="j-filter-btn" data-filter="tenggat" onclick="toggleMultiFilter('tenggat', this)">
        <span style="width:10px;height:10px;border-radius:9999px;background:#facc15;box-shadow:0 0 6px #facc15;display:inline-block;"></span>
        Tenggat
    </button>
    <button type="button" class="j-filter-btn" data-filter="deadline" onclick="toggleMultiFilter('deadline', this)">
        <span style="width:10px;height:10px;border-radius:9999px;background:#ef4444;box-shadow:0 0 6px #ef4444;display:inline-block;"></span>
        Deadline
    </button>
    <button type="button" class="j-filter-btn" data-filter="selesai" onclick="toggleMultiFilter('selesai', this)">
        <span style="width:10px;height:10px;border-radius:9999px;background:#22c55e;box-shadow:0 0 6px #22c55e;display:inline-block;"></span>
        Selesai
    </button>
    <button type="button" class="j-filter-btn" onclick="resetJadwalCells()" style="border-color: rgba(248, 113, 113, 0.6);">
        🔄 Reset
    </button>
</div>

<script>
    const activeFilters = new Set();

    function getMapelCells() {
        const cells = [];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const tds = Array.from(tr.querySelectorAll('td'));
            tds.slice(1).forEach(td => {
                if ((td.textContent || '').trim().length > 0) {
                    cells.push(td);
                }
            });
        });
        return cells;
    }

    function hasStatusDot(td, colorKeywords) {
        const candidates = td.querySelectorAll('span, div, i');
        for (const el of candidates) {
            if (el.offsetWidth > 0 && el.offsetWidth <= 24 && el.offsetHeight > 0 && el.offsetHeight <= 24) {
                const cls = (el.className || '').toString().toLowerCase();
                const style = (el.getAttribute('style') || '').toLowerCase();
                const bg = window.getComputedStyle(el).backgroundColor;

                for (const kw of colorKeywords) {
                    if (cls.includes(kw) || style.includes(kw) || bg.includes(kw)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function checkSingleFilter(td, type) {
        const visibleText = td.innerText || '';

        if (type === 'catatan') return visibleText.includes('📝');
        if (type === 'tugas')   return visibleText.includes('📌');
        if (type === 'pr')      return visibleText.includes('🏠');
        if (type === 'event')   return visibleText.includes('🎉');

        if (type === 'tenggat') {
            return hasStatusDot(td, ['yellow', 'amber', '#facc15', '#eab308', '250, 204, 21', '234, 179, 8']);
        }
        if (type === 'deadline') {
            return hasStatusDot(td, ['red', '#ef4444', '#dc2626', '239, 68, 68', '220, 38, 38']);
        }
        if (type === 'selesai') {
            return hasStatusDot(td, ['green', 'emerald', '#22c55e', '#10b981', '34, 197, 94', '16, 185, 129']);
        }
        return true;
    }

    function applyMultiFilters() {
        const cells = getMapelCells();
        if (activeFilters.size === 0) {
            cells.forEach(td => td.classList.remove('cell-dimmed', 'cell-highlighted'));
            return;
        }

        cells.forEach(td => {
            let matched = false;
            for (const f of activeFilters) {
                if (checkSingleFilter(td, f)) {
                    matched = true;
                    break;
                }
            }
            if (matched) {
                td.classList.remove('cell-dimmed');
                td.classList.add('cell-highlighted');
            } else {
                td.classList.remove('cell-highlighted');
                td.classList.add('cell-dimmed');
            }
        });
    }

    function toggleMultiFilter(type, btn) {
        if (typeof playSfx === 'function') playSfx('click');

        if (activeFilters.has(type)) {
            activeFilters.delete(type);
            if (btn) {
                btn.classList.remove('active');
                btn.classList.remove('is-unselecting');
                void btn.offsetWidth;
                btn.classList.add('is-unselecting');
                setTimeout(() => btn.classList.remove('is-unselecting'), 280);
            }
        } else {
            activeFilters.add(type);
            if (btn) btn.classList.add('active');
        }

        applyMultiFilters();
    }

    function resetJadwalCells() {
        if (typeof playSfx === 'function') playSfx('click');
        activeFilters.clear();
        document.querySelectorAll('.j-filter-btn.active').forEach(b => {
            b.classList.remove('active');
            b.classList.remove('is-unselecting');
            void b.offsetWidth;
            b.classList.add('is-unselecting');
            setTimeout(() => b.classList.remove('is-unselecting'), 280);
        });
        applyMultiFilters();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Pastikan hanya ada 1 bar filter (hapus duplikat jika ada)
        const bars = document.querySelectorAll('#jadwal-filter-bar, .jadwal-filter-bar');
        bars.forEach((b, idx) => {
            if (idx > 0) b.remove();
        });

        // Hapus legenda teks statis lama (Catatan | Tugas | PR | Event)
        document.querySelectorAll('div, p, span').forEach(el => {
            if (!el.closest('#jadwal-filter-bar') && el.id !== 'jadwal-filter-bar') {
                const txt = (el.textContent || '').trim();
                if (txt.includes('Catatan') && txt.includes('Tugas') && txt.includes('PR') && txt.includes('Event') && txt.length < 90) {
                    el.style.display = 'none';
                }
            }
        });
    });
</script>
<div class="overflow-x-auto pb-2">
            

<style>
    @keyframes dotStayVisible {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.92; }
    }
    tbody td [class*="yellow"],
    tbody td [class*="amber"],
    tbody td [style*="yellow"],
    tbody td [style*="#facc15"],
    tbody td [style*="#eab308"] {
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
        background-color: #facc15 !important;
        box-shadow: 0 0 8px #facc15, 0 0 14px rgba(250, 204, 21, 0.9) !important;
        animation: dotStayVisible 1.6s ease-in-out infinite !important;
    }
    .jadwal-filter-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 12px auto 14px auto;
    }
    .j-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        border: 1.5px solid var(--border-color);
        background: rgba(15, 23, 42, 0.45);
        color: var(--text-main);
        cursor: pointer;
        user-select: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
    }
    body[data-theme="teal-growth"] .j-filter-btn,
    body[data-theme="creative-spark"] .j-filter-btn,
    body[data-theme="lavender-dream"] .j-filter-btn,
    body[data-theme="soft-berry"] .j-filter-btn,
    body[data-theme="morning-assembly"] .j-filter-btn {
        background: rgba(255, 255, 255, 0.92);
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
    .j-filter-btn {
        transition: transform 0.24s cubic-bezier(0.22, 1, 0.36, 1),
                    background-color 0.24s ease,
                    color 0.24s ease,
                    border-color 0.24s ease,
                    box-shadow 0.24s ease,
                    opacity 0.24s ease !important;
        will-change: transform;
    }
    .j-filter-btn.is-unselecting {
        animation: filterUnselectPop 0.26s cubic-bezier(0.22, 1, 0.36, 1) !important;
    }
.j-filter-btn.active {
        background: var(--primary) !important;
        color: #ffffff !important;
        border-color: #ffffff !important;
        box-shadow: 0 0 14px rgba(59, 130, 246, 0.65);
        transform: scale(1.06);
    }
    .cell-dimmed {
        opacity: 0.2 !important;
        filter: grayscale(75%);
        transition: all 0.2s ease;
    }
    .cell-highlighted {
        opacity: 1 !important;
        box-shadow: inset 0 0 0 2.5px #38bdf8, 0 0 16px rgba(56, 189, 248, 0.45) !important;
        transition: all 0.2s ease;
    }
</style>



<script>
    const activeFilters = new Set();

    function getMapelCells() {
        const cells = [];
        document.querySelectorAll('tbody tr').forEach(tr => {
            const tds = Array.from(tr.querySelectorAll('td'));
            tds.slice(1).forEach(td => {
                if ((td.textContent || '').trim().length > 0) {
                    cells.push(td);
                }
            });
        });
        return cells;
    }

    function hasStatusDot(td, colorKeywords) {
        const candidates = td.querySelectorAll('span, div, i');
        for (const el of candidates) {
            if (el.offsetWidth > 0 && el.offsetWidth <= 24 && el.offsetHeight > 0 && el.offsetHeight <= 24) {
                const cls = (el.className || '').toString().toLowerCase();
                const style = (el.getAttribute('style') || '').toLowerCase();
                const bg = window.getComputedStyle(el).backgroundColor;

                for (const kw of colorKeywords) {
                    if (cls.includes(kw) || style.includes(kw) || bg.includes(kw)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function checkSingleFilter(td, type) {
        const visibleText = td.innerText || '';

        if (type === 'catatan') return visibleText.includes('📝');
        if (type === 'tugas')   return visibleText.includes('📌');
        if (type === 'pr')      return visibleText.includes('🏠');
        if (type === 'event')   return visibleText.includes('🎉');

        if (type === 'tenggat') {
            return hasStatusDot(td, ['yellow', 'amber', '#facc15', '#eab308', '250, 204, 21', '234, 179, 8']);
        }
        if (type === 'deadline') {
            return hasStatusDot(td, ['red', '#ef4444', '#dc2626', '239, 68, 68', '220, 38, 38']);
        }
        if (type === 'selesai') {
            return hasStatusDot(td, ['green', 'emerald', '#22c55e', '#10b981', '34, 197, 94', '16, 185, 129']);
        }
        return true;
    }

    function applyMultiFilters() {
        const cells = getMapelCells();
        if (activeFilters.size === 0) {
            cells.forEach(td => td.classList.remove('cell-dimmed', 'cell-highlighted'));
            return;
        }

        cells.forEach(td => {
            let matched = false;
            for (const f of activeFilters) {
                if (checkSingleFilter(td, f)) {
                    matched = true;
                    break;
                }
            }
            if (matched) {
                td.classList.remove('cell-dimmed');
                td.classList.add('cell-highlighted');
            } else {
                td.classList.remove('cell-highlighted');
                td.classList.add('cell-dimmed');
            }
        });
    }

    function toggleMultiFilter(type, btn) {
        if (typeof playSfx === 'function') playSfx('click');

        if (activeFilters.has(type)) {
            activeFilters.delete(type);
            if (btn) {
                btn.classList.remove('active');
                btn.classList.remove('is-unselecting');
                void btn.offsetWidth;
                btn.classList.add('is-unselecting');
                setTimeout(() => btn.classList.remove('is-unselecting'), 280);
            }
        } else {
            activeFilters.add(type);
            if (btn) btn.classList.add('active');
        }

        applyMultiFilters();
    }

    function resetJadwalCells() {
        if (typeof playSfx === 'function') playSfx('click');
        activeFilters.clear();
        document.querySelectorAll('.j-filter-btn.active').forEach(b => {
            b.classList.remove('active');
            b.classList.remove('is-unselecting');
            void b.offsetWidth;
            b.classList.add('is-unselecting');
            setTimeout(() => b.classList.remove('is-unselecting'), 280);
        });
        applyMultiFilters();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Pastikan hanya ada 1 bar filter (hapus duplikat jika ada)
        const bars = document.querySelectorAll('#jadwal-filter-bar, .jadwal-filter-bar');
        bars.forEach((b, idx) => {
            if (idx > 0) b.remove();
        });

        // Hapus legenda teks statis lama (Catatan | Tugas | PR | Event)
        document.querySelectorAll('div, p, span').forEach(el => {
            if (!el.closest('#jadwal-filter-bar') && el.id !== 'jadwal-filter-bar') {
                const txt = (el.textContent || '').trim();
                if (txt.includes('Catatan') && txt.includes('Tugas') && txt.includes('PR') && txt.includes('Event') && txt.length < 90) {
                    el.style.display = 'none';
                }
            }
        });
    });
</script>
<table class="timetable-grid text-center">
                <colgroup>
                    <col style="width: 7%;">
                    @for($i = 1; $i <= 12; $i++)
                        <col style="width: 7.75%;">
                    @endfor
                </colgroup>

                <thead>
                    <tr class="theme-primary">
                        <th class="py-2.5 px-1 text-xs font-bold sticky left-0 z-10 theme-primary" data-i18n="hari_jam">
                            Hari / Jam
                        </th>
                        @foreach($jamList as $no => $waktu)
                            <th class="py-2 px-0.5">
                                <div class="font-bold text-xs sm:text-sm leading-none">{{ $no }}</div>
                                <div class="text-[8px] xl:text-[9px] leading-tight opacity-90 mt-1 tracking-tighter">{{ $waktu }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                        @php
                            $daySchedules = isset($schedules[$day]) ? $schedules[$day]->keyBy('jam_mulai') : collect();
                            $currentHour = 1;
                        @endphp
                        <tr style="height: 84px;">
                            <td class="p-1.5 font-bold text-xs sm:text-sm sticky left-0 z-10 theme-card" data-i18n="{{ $dayKeys[$day] ?? '' }}">
                                {{ $day }}
                            </td>

                            @while($currentHour <= 12)
                                @if($daySchedules->has($currentHour))
                                    @php
                                        $item = $daySchedules->get($currentHour);
                                        $colspan = ($item->jam_selesai - $item->jam_mulai) + 1;
                                        $alert = $subjectAlerts[$item->subject_id] ?? null;
                                        $alertType = $alert['type'] ?? '';
                                        $postIdsJson = json_encode($alert['post_ids'] ?? []);
                                        $badges = $subjectBadges[$item->subject_id] ?? [];
                                    @endphp
                                    <td colspan="{{ $colspan }}" class="p-1 align-middle">
                                        <a href="{{ route('subject.show', $item->subject_id) }}"
                                           onclick="markSubjectSeen({{ $item->subject_id }}, {{ $postIdsJson }})"
                                           style="position: relative;"
                                           class="flex flex-col justify-center items-center h-full w-full px-1 pt-3 pb-1 rounded-lg theme-soft border theme-border shadow-sm">
                                            
                                            <!-- Pojok Kiri Atas: Titik Kuning / Merah Deadline -->
                                            @if($alertType === 'red')
                                                <span class="alert-dot-red" title="Ada Tugas/Event Deadline & Belum Dicentang!"></span>
                                            @elseif($alertType === 'yellow')
                                                <span class="alert-dot-yellow"
                                                      data-yellow-subject="{{ $item->subject_id }}"
                                                      data-post-ids="{{ $postIdsJson }}"
                                                      title="Waktu Mepet! Klik untuk melihat"></span>
                                            @endif

                                            <!-- Pojok Kanan Atas: Ikon Indikator Catatan / Tugas / PR / Event -->
                                            @if(!empty($badges))
                                                <div class="subject-top-right-icons">
                                                    @foreach($katIcons as $katKey => $katInfo)
                                                        @if(!empty($badges[$katKey]))
                                                            <span class="mini-kat-icon"
                                                                  title="{{ $badges[$katKey] }} {{ $katInfo['label'] }}">
                                                                {{ $katInfo['icon'] }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="font-bold text-xs sm:text-sm leading-tight" style="color: var(--primary);">
                                                {{ $item->subject->kode_mapel }}
                                            </div>
                                            <div class="text-[9px] sm:text-[10px] opacity-80 leading-tight mt-0.5 line-clamp-2 break-words w-full">
                                                {{ $item->subject->nama_mapel }}
                                            </div>
                                        </a>
                                    </td>
                                    @php $currentHour += $colspan; @endphp
                                @else
                                    <td class="p-0"></td>
                                    @php $currentHour++; @endphp
                                @endif
                            @endwhile
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function markSubjectSeen(subjectId, postIds) {
            if (!postIds || postIds.length === 0) return;
            const seenKey = 'seen_yellow_posts_{{ Auth::id() }}';
            const seenList = JSON.parse(localStorage.getItem(seenKey) || '[]');
            postIds.forEach(id => {
                if (!seenList.includes(id)) seenList.push(id);
            });
            localStorage.setItem(seenKey, JSON.stringify(seenList));
        }

        document.addEventListener('DOMContentLoaded', () => {
            const seenKey = 'seen_yellow_posts_{{ Auth::id() }}';
            const seenList = JSON.parse(localStorage.getItem(seenKey) || '[]');

            document.querySelectorAll('[data-yellow-subject]').forEach(dot => {
                const postIds = JSON.parse(dot.getAttribute('data-post-ids') || '[]');
                const allSeen = postIds.length > 0 && postIds.every(id => seenList.includes(id));
                if (allSeen) {
                    dot.style.display = 'none';
                }
            });
        });
    </script>
<script>
    let activeJadwalFilter = null;

    // Pastikan semua titik kuning/merah/hijau di dalam kotak mapel tidak pernah hilang oleh script/animasi lain
    function enforceDeadlineDots() {
        document.querySelectorAll('a[href*="/mapel/"]').forEach(box => {
            box.querySelectorAll('span, div').forEach(el => {
                const cls = (el.className || '').toString();
                const style = (el.getAttribute('style') || '').toLowerCase();
                if (cls.includes('yellow') || cls.includes('amber') || style.includes('#facc15') || style.includes('#eab308') || style.includes('yellow') || style.includes('amber')) {
                    el.classList.add('dot-tenggat-kuning');
                    el.style.opacity = '1';
                    el.style.visibility = 'visible';
                    el.style.display = 'inline-block';
                }
                if (cls.includes('red') || style.includes('#ef4444') || style.includes('red')) {
                    el.classList.add('dot-deadline-merah');
                    el.style.opacity = '1';
                    el.style.visibility = 'visible';
                    el.style.display = 'inline-block';
                }
                if (cls.includes('green') || cls.includes('emerald') || style.includes('#22c55e') || style.includes('#10b981') || style.includes('green')) {
                    el.classList.add('dot-selesai-hijau');
                    el.style.opacity = '1';
                    el.style.visibility = 'visible';
                    el.style.display = 'inline-block';
                }
            });
        });
    }

    function boxMatchesFilter(box, type) {
        const html = box.innerHTML;
        const dataAttr = (box.getAttribute('data-status') || '') + ' ' + (box.getAttribute('data-types') || '');
        const combined = (html + ' ' + dataAttr).toLowerCase();

        switch (type) {
            case 'catatan':
                return html.includes('📝') || combined.includes('catatan');
            case 'tugas':
                return html.includes('📌') || combined.includes('tugas');
            case 'pr':
                return html.includes('🏠') || combined.includes('"pr"') || combined.includes('pr</span>');
            case 'event':
                return html.includes('🎉') || combined.includes('event');
            case 'tenggat':
                return box.querySelector('.dot-tenggat-kuning, [class*="yellow"], [class*="amber"]') !== null || combined.includes('tenggat') || combined.includes('#facc15');
            case 'deadline':
                return box.querySelector('.dot-deadline-merah, [class*="red"]') !== null || combined.includes('deadline') || combined.includes('#ef4444');
            case 'selesai':
                return box.querySelector('.dot-selesai-hijau, [class*="green"], [class*="emerald"]') !== null || combined.includes('selesai') || combined.includes('#22c55e');
            default:
                return true;
        }
    }

    function toggleJadwalFilter(type, btnEl) {
        if (typeof playSfx === 'function') playSfx('click');

        if (activeJadwalFilter === type) {
            resetJadwalFilter();
            return;
        }

        activeJadwalFilter = type;
        document.querySelectorAll('.j-filter-btn.active').forEach(b => {
            b.classList.remove('active');
            b.classList.remove('is-unselecting');
            void b.offsetWidth;
            b.classList.add('is-unselecting');
            setTimeout(() => b.classList.remove('is-unselecting'), 280);
        });
        if (btnEl) btnEl.classList.add('active');

        document.querySelectorAll('a[href*="/mapel/"]').forEach(box => {
            if (boxMatchesFilter(box, type)) {
                box.classList.remove('mapel-dimmed');
                box.classList.add('mapel-highlighted');
            } else {
                box.classList.remove('mapel-highlighted');
                box.classList.add('mapel-dimmed');
            }
        });
    }

    function resetJadwalFilter() {
        if (typeof playSfx === 'function') playSfx('click');
        activeJadwalFilter = null;
        document.querySelectorAll('.j-filter-btn.active').forEach(b => {
            b.classList.remove('active');
            b.classList.remove('is-unselecting');
            void b.offsetWidth;
            b.classList.add('is-unselecting');
            setTimeout(() => b.classList.remove('is-unselecting'), 280);
        });
        document.querySelectorAll('a[href*="/mapel/"]').forEach(box => {
            box.classList.remove('mapel-dimmed', 'mapel-highlighted');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        enforceDeadlineDots();
        setInterval(enforceDeadlineDots, 800);
    });
</script>
</x-app-layout>