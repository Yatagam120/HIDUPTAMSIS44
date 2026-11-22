<x-app-layout>
    <style>
        .cal-wrapper {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.35);
        }
        .cal-header-grid,
        .cal-body-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
        .cal-day-head {
            padding: 10px 4px;
            text-align: center;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
            border-right: 1px solid rgba(148, 163, 184, 0.2);
        }
        .cal-day-head:last-child { border-right: none; }

        .cal-box {
            min-height: 98px;
            padding: 8px;
            border-right: 1px solid rgba(148, 163, 184, 0.22);
            border-bottom: 1px solid rgba(148, 163, 184, 0.22);
            cursor: pointer;
            transition: background-color 0.18s ease, box-shadow 0.18s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .cal-box:nth-child(7n) { border-right: none; }
        .cal-box:hover {
            background-color: var(--primary-soft);
            box-shadow: inset 0 0 0 1.5px var(--primary);
        }
        .cal-box-empty {
            min-height: 98px;
            border-right: 1px solid rgba(148, 163, 184, 0.15);
            border-bottom: 1px solid rgba(148, 163, 184, 0.15);
            background: rgba(0, 0, 0, 0.14);
        }
        .cal-box-empty:nth-child(7n) { border-right: none; }

        .cal-pill {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2.5px 7px;
            border-radius: 6px;
            margin-top: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (min-width: 768px) {
            .cal-box, .cal-box-empty { min-height: 118px; padding: 10px; }
            .cal-pill { font-size: 11px; }
        }
    </style>

    @php
        $prevDate = $currentDate->copy()->subMonth();
        $nextDate = $currentDate->copy()->addMonth();
        $startDayOfWeek = $currentDate->copy()->startOfMonth()->dayOfWeekIso;
        $daysInMonth = $currentDate->daysInMonth;
        $todayStr = now()->toDateString();
        $isAuthority = in_array(Auth::user()->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $kategoriMeta = [
            'tugas'      => ['name' => 'Tugas / Deadline', 'dot' => '#ef4444', 'bg' => 'rgba(239, 68, 68, 0.22)',  'text' => '#fca5a5'],
            'ulangan'    => ['name' => 'Ulangan / ATS',    'dot' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.22)', 'text' => '#fcd34d'],
            'acara'      => ['name' => 'Acara / Kegiatan', 'dot' => '#3b82f6', 'bg' => 'rgba(59, 130, 246, 0.22)', 'text' => '#93c5fd'],
            'peringatan' => ['name' => 'Memperingati Hari','dot' => '#a855f7', 'bg' => 'rgba(168, 85, 247, 0.22)', 'text' => '#d8b4fe'],
            'lainnya'    => ['name' => 'Event Lainnya',    'dot' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.22)', 'text' => '#6ee7b7'],
        ];
    @endphp

    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/50 text-xs sm:text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6">
        <!-- Header Atas Kalender -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight">
                    {{ $namaBulan[$month] }} {{ $year }}
                </h1>
                <p class="text-xs opacity-75 mt-0.5">Klik langsung kotak tanggal untuk melihat atau menandai agenda.</p>
            </div>

            <!-- Navigasi Bulan Minimalis -->
            <div class="flex items-center gap-1.5">
                <a href="{{ route('calendar.index', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-bold theme-soft border theme-border hover:opacity-85 transition">
                    ‹ Sebelumnya
                </a>
                <a href="{{ route('calendar.index') }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-bold theme-primary shadow-sm hover:opacity-90 transition">
                    Hari Ini
                </a>
                <a href="{{ route('calendar.index', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-bold theme-soft border theme-border hover:opacity-85 transition">
                    Berikutnya ›
                </a>
            </div>
        </div>

        <!-- Legenda Titik Warna Minimalis (Bukan Tombol) -->
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mb-4 text-[11px] opacity-85">
            @foreach($kategoriMeta as $meta)
                <span class="inline-flex items-center gap-1.5 font-medium">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $meta['dot'] }}; display: inline-block;"></span>
                    {{ $meta['name'] }}
                </span>
            @endforeach
        </div>

        <!-- Tabel Kalender Full-Width -->
        <div class="cal-wrapper">
            <!-- Header Nama Hari -->
            <div class="cal-header-grid theme-primary">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $idx => $hari)
                    <div class="cal-day-head {{ $idx >= 5 ? 'text-red-200' : '' }}">
                        <span class="hidden sm:inline">{{ $hari }}</span>
                        <span class="sm:hidden">{{ substr($hari, 0, 3) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Grid Tanggal -->
            <div class="cal-body-grid">
                @for($empty = 1; $empty < $startDayOfWeek; $empty++)
                    <div class="cal-box-empty"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $formattedLabel = $day . ' ' . $namaBulan[$month] . ' ' . $year;
                        $dayEvents = $eventsByDate[$dateStr] ?? [];
                        $isToday = ($dateStr === $todayStr);
                        $dayOfWeek = ($startDayOfWeek + $day - 2) % 7; // 5=Sabtu, 6=Minggu
                        $eventsJson = json_encode($dayEvents);
                    @endphp

                    <div onclick='openDateModal("{{ $dateStr }}", "{{ $formattedLabel }}", {!! $eventsJson !!})'
                         class="cal-box {{ $isToday ? 'theme-soft' : '' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-extrabold {{ $isToday ? 'w-6 h-6 rounded-full theme-primary inline-flex items-center justify-center shadow-sm' : ($dayOfWeek >= 5 ? 'text-red-400' : '') }}">
                                {{ $day }}
                            </span>
                            <span class="text-[10px] opacity-0 group-hover:opacity-75 font-bold">+</span>
                        </div>

                        <div class="mt-1">
                            @foreach(array_slice($dayEvents, 0, 3) as $ev)
                                @php $meta = $kategoriMeta[$ev['kategori']] ?? $kategoriMeta['lainnya']; @endphp
                                <span style="background: {{ $meta['bg'] }}; color: {{ $meta['text'] }}; border-left: 3px solid {{ $meta['dot'] }};"
                                      class="cal-pill">
                                    {{ $ev['judul'] }}
                                </span>
                            @endforeach
                            @if(count($dayEvents) > 3)
                                <span class="text-[10px] opacity-75 font-bold block mt-0.5 pl-1">
                                    +{{ count($dayEvents) - 3 }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                @endfor

                @php
                    $totalCells = ($startDayOfWeek - 1) + $daysInMonth;
                    $trailingEmpty = (7 - ($totalCells % 7)) % 7;
                @endphp
                @for($t = 0; $t < $trailingEmpty; $t++)
                    <div class="cal-box-empty"></div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Modal Popup Saat Kotak Tanggal Diklik -->
    <div id="date-modal" onclick="if(event.target === this) closeDateModal()"
         style="display: none; position: fixed; inset: 0; z-index: 9995; background: rgba(0, 0, 0, 0.68); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px;">
        <div class="theme-card rounded-2xl shadow-2xl w-full max-w-md p-6 border theme-border" style="max-height: 90vh; overflow-y: auto;">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200/20">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-70">Agenda Tanggal</span>
                    <h2 id="modal-date-title" class="text-lg sm:text-xl font-extrabold" style="color: var(--primary);"></h2>
                </div>
                <button type="button" onclick="closeDateModal()"
                        class="w-8 h-8 rounded-full theme-soft border theme-border font-bold text-sm flex items-center justify-center hover:opacity-80">
                    ✕
                </button>
            </div>

            <!-- Daftar Agenda di Tanggal yang Diklik -->
            <div id="modal-events-list" class="space-y-2 mb-5"></div>

            <!-- Form Tambah Penanda Baru untuk Tanggal Tersebut -->
            <form action="{{ route('calendar.store') }}" method="POST" class="space-y-3 pt-3 border-t border-gray-200/20">
                @csrf
                <input type="hidden" id="modal-date-input" name="tanggal">

                <p class="text-xs font-bold uppercase tracking-wider opacity-80">+ Tambah Penanda Baru</p>

                <div>
                    <select name="kategori" required class="w-full rounded-xl border p-2.5 text-sm">
                        <option value="tugas">📌 Tugas / Deadline</option>
                        <option value="ulangan">📝 Ulangan / ATS / PAS</option>
                        <option value="acara">🎉 Acara / Kegiatan Kelas</option>
                        <option value="peringatan">🇮🇩 Memperingati Hari Besar</option>
                        <option value="lainnya">✨ Event Lainnya</option>
                    </select>
                </div>

                <div>
                    <input type="text" name="judul" required placeholder="Judul (Contoh: ATS Pemrograman Lanjut)"
                           class="w-full rounded-xl border p-2.5 text-sm">
                </div>

                <div>
                    <textarea name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)..."
                              class="w-full rounded-xl border p-2.5 text-sm"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                    Simpan ke Tanggal Ini
                </button>
            </form>
        </div>
    </div>

    <script>
        const currentUserId = {{ Auth::id() }};
        const isAuthority = {{ $isAuthority ? 'true' : 'false' }};
        const csrfToken = '{{ csrf_token() }}';

        const badgeColors = {
            tugas:      { label: 'Tugas / Deadline', dot: '#ef4444', bg: 'rgba(239, 68, 68, 0.2)',  text: '#fca5a5' },
            ulangan:    { label: 'Ulangan / ATS',    dot: '#f59e0b', bg: 'rgba(245, 158, 11, 0.2)', text: '#fcd34d' },
            acara:      { label: 'Acara / Kegiatan', dot: '#3b82f6', bg: 'rgba(59, 130, 246, 0.2)', text: '#93c5fd' },
            peringatan: { label: 'Memperingati Hari',dot: '#a855f7', bg: 'rgba(168, 85, 247, 0.2)', text: '#d8b4fe' },
            lainnya:    { label: 'Event Lainnya',    dot: '#10b981', bg: 'rgba(16, 185, 129, 0.2)', text: '#6ee7b7' },
        };

        function openDateModal(dateStr, formattedLabel, events) {
            document.getElementById('modal-date-title').textContent = formattedLabel;
            document.getElementById('modal-date-input').value = dateStr;

            const listContainer = document.getElementById('modal-events-list');
            listContainer.innerHTML = '';

            if (!events || events.length === 0) {
                listContainer.innerHTML = '<p class="text-xs opacity-65 italic">Belum ada agenda pada tanggal ini.</p>';
            } else {
                events.forEach(ev => {
                    const meta = badgeColors[ev.kategori] || badgeColors.lainnya;
                    const canDelete = (ev.source === 'manual') && (isAuthority || Number(ev.user_id) === Number(currentUserId));

                    let actionHtml = '';
                    if (ev.url) {
                        actionHtml = `<a href="${ev.url}" class="text-[11px] font-bold hover:underline shrink-0" style="color: var(--primary);">Buka Mapel →</a>`;
                    } else if (canDelete) {
                        actionHtml = `
                            <form action="/kalender/${ev.id}" method="POST" onsubmit="return confirm('Hapus penanda ini?')">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-[11px] font-bold text-red-400 hover:underline shrink-0">Hapus</button>
                            </form>
                        `;
                    }

                    const card = document.createElement('div');
                    card.style.cssText = 'padding: 10px 12px; border-radius: 12px; background: rgba(0,0,0,0.18); border: 1px solid rgba(148,163,184,0.25); display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;';
                    card.innerHTML = `
                        <div>
                            <span style="background: ${meta.bg}; color: ${meta.text}; border-left: 3px solid ${meta.dot}; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 5px; display: inline-block; margin-bottom: 4px;">
                                ${meta.label}
                            </span>
                            <div class="text-xs sm:text-sm font-bold">${ev.judul}</div>
                            ${ev.keterangan ? `<div class="text-xs opacity-75 mt-0.5">${ev.keterangan}</div>` : ''}
                            <div class="text-[10px] opacity-55 mt-1">Oleh ${ev.author}</div>
                        </div>
                        ${actionHtml}
                    `;
                    listContainer.appendChild(card);
                });
            }

            document.getElementById('date-modal').style.display = 'flex';
        }

        function closeDateModal() {
            document.getElementById('date-modal').style.display = 'none';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDateModal();
        });
    </script>
</x-app-layout>