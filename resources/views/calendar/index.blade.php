<x-app-layout>
    <style>
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 6px;
        }
        .cal-cell {
            min-height: 92px;
            border-radius: 12px;
            padding: 6px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            transition: transform 0.15s ease, border-color 0.15s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .cal-cell:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }
        .cal-badge {
            font-size: 9.5px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            margin-top: 3px;
        }
        @media (min-width: 640px) {
            .cal-cell { min-height: 112px; padding: 8px; }
            .cal-badge { font-size: 10.5px; }
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

        $kategoriStyles = [
            'tugas'      => ['label' => '📌 Tugas / Deadline', 'bg' => 'rgba(239, 68, 68, 0.22)',  'color' => '#f87171', 'border' => '#ef4444'],
            'ulangan'    => ['label' => '📝 Ulangan / ATS',    'bg' => 'rgba(245, 158, 11, 0.22)', 'color' => '#fbbf24', 'border' => '#f59e0b'],
            'acara'      => ['label' => '🎉 Acara / Kegiatan', 'bg' => 'rgba(59, 130, 246, 0.22)', 'color' => '#60a5fa', 'border' => '#3b82f6'],
            'peringatan' => ['label' => '🇮🇩 Memperingati Hari', 'bg' => 'rgba(168, 85, 247, 0.22)', 'color' => '#c084fc', 'border' => '#a855f7'],
            'lainnya'    => ['label' => '✨ Event Lainnya',    'bg' => 'rgba(16, 185, 129, 0.22)', 'color' => '#34d399', 'border' => '#10b981'],
        ];
    @endphp

    @if(session('success'))
        <div class="mb-4 p-3.5 rounded-xl bg-emerald-100 text-emerald-900 border border-emerald-300 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 theme-card rounded-2xl shadow-md p-4 sm:p-6">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold">
                        {{ $namaBulan[$month] }} {{ $year }}
                    </h1>
                    <p class="text-xs opacity-75 mt-0.5">Klik tanggal mana saja untuk menandai agenda kelas XI RPL 1.</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('calendar.index', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold theme-soft border theme-border hover:opacity-80">
                        ← Prev
                    </a>
                    <a href="{{ route('calendar.index') }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold theme-primary shadow-sm hover:opacity-90">
                        Hari Ini
                    </a>
                    <a href="{{ route('calendar.index', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold theme-soft border theme-border hover:opacity-80">
                        Next →
                    </a>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($kategoriStyles as $katKey => $style)
                    <span style="background: {{ $style['bg'] }}; color: {{ $style['color'] }}; border: 1px solid {{ $style['border'] }};"
                          class="text-[10px] sm:text-xs font-bold px-2.5 py-0.5 rounded-full">
                        {{ $style['label'] }}
                    </span>
                @endforeach
            </div>

            <div class="cal-grid text-center mb-2">
                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $idx => $hari)
                    <div class="text-xs font-extrabold py-1.5 rounded-lg {{ $idx >= 5 ? 'text-red-400' : 'opacity-80' }}">
                        {{ $hari }}
                    </div>
                @endforeach
            </div>

            <div class="cal-grid">
                @for($empty = 1; $empty < $startDayOfWeek; $empty++)
                    <div class="rounded-xl opacity-25 border border-gray-500/20"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $dayEvents = $eventsByDate[$dateStr] ?? [];
                        $isToday = ($dateStr === $todayStr);
                    @endphp

                    <div onclick="selectCalendarDate('{{ $dateStr }}')"
                         class="cal-cell {{ $isToday ? 'theme-soft border-2 theme-border shadow-md' : 'bg-black/10' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-extrabold {{ $isToday ? 'px-2 py-0.5 rounded-full theme-primary' : '' }}">
                                {{ $day }}
                            </span>
                            @if(count($dayEvents) > 0)
                                <span class="text-[10px] font-bold opacity-75">{{ count($dayEvents) }}</span>
                            @endif
                        </div>

                        <div class="mt-1 overflow-hidden">
                            @foreach(array_slice($dayEvents, 0, 3) as $ev)
                                @php $st = $kategoriStyles[$ev['kategori']] ?? $kategoriStyles['lainnya']; @endphp
                                <span style="background: {{ $st['bg'] }}; color: {{ $st['color'] }}; border-left: 2.5px solid {{ $st['border'] }};"
                                      class="cal-badge" title="{{ $ev['judul'] }}">
                                    {{ $ev['judul'] }}
                                </span>
                            @endforeach
                            @if(count($dayEvents) > 3)
                                <span class="text-[9px] opacity-75 font-bold block mt-0.5">+{{ count($dayEvents) - 3 }} lainnya</span>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="space-y-6">
            <div class="theme-card rounded-2xl shadow-md p-6 border theme-border">
                <h2 class="text-lg font-bold mb-1">Tandai Tanggal Kalender</h2>
                <p class="text-xs opacity-75 mb-4">Tandai tugas, ulangan/ATS, acara, atau peringatan hari.</p>

                <form action="{{ route('calendar.store') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold mb-1">Pilih Tanggal</label>
                        <input type="date" id="cal-date-input" name="tanggal" required
                               value="{{ now()->toDateString() }}"
                               min="2020-01-01" max="2099-12-31"
                               oninput="if(this.value.split('-')[0].length > 4) this.value = this.value.slice(0, 10);"
                               class="w-full rounded-xl border p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1">Jenis Penanda</label>
                        <select name="kategori" required class="w-full rounded-xl border p-2.5 text-sm">
                            <option value="tugas" style="background-color:#0f172a; color:#f8fafc;">📌 Tugas / Deadline</option>
                            <option value="ulangan">📝 Ulangan / ATS / PAS</option>
                            <option value="acara">🎉 Acara / Kegiatan Kelas</option>
                            <option value="peringatan">🇮🇩 Memperingati Hari Besar</option>
                            <option value="lainnya">✨ Event Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1">Judul Agenda</label>
                        <input type="text" name="judul" required placeholder="Contoh: ATS Pemrograman Lanjut"
                               class="w-full rounded-xl border p-2.5 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" placeholder="Catatan tambahan..."
                                  class="w-full rounded-xl border p-2.5 text-sm"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                        Simpan Penanda
                    </button>
                </form>

            <div class="theme-card rounded-2xl shadow-md p-6">
                <h3 class="text-base font-bold mb-3">Agenda Bulan {{ $namaBulan[$month] }}</h3>

                <div class="space-y-2.5 max-h-96 overflow-y-auto pr-1">
                    @php $hasAnyEvent = false; @endphp
                    @foreach($eventsByDate as $tgl => $list)
                        @foreach($list as $ev)
                            @php
                                $hasAnyEvent = true;
                                $st = $kategoriStyles[$ev['kategori']] ?? $kategoriStyles['lainnya'];
                                $canDelete = ($ev['source'] === 'manual') && ($isAuthority || (int)$ev['user_id'] === (int)Auth::id());
                            @endphp
                            <div class="p-3 rounded-xl border border-gray-200/20 bg-black/10 flex items-start justify-between gap-2">
                                <div>
                                    <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                        <span class="text-[11px] font-extrabold">
                                            {{ \Carbon\Carbon::parse($tgl)->format('d M Y') }}
                                        </span>
                                        <span style="background: {{ $st['bg'] }}; color: {{ $st['color'] }}; border: 1px solid {{ $st['border'] }};"
                                              class="text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            {{ $st['label'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm font-bold">{{ $ev['judul'] }}</p>
                                    @if($ev['keterangan'])
                                        <p class="text-xs opacity-75 mt-0.5">{{ $ev['keterangan'] }}</p>
                                    @endif
                                    <p class="text-[10px] opacity-60 mt-1">Oleh {{ $ev['author'] }}</p>
                                </div>

                                @if($ev['url'])
                                    <a href="{{ $ev['url'] }}" class="text-[11px] font-bold hover:underline shrink-0" style="color: var(--primary);">
                                        Buka →
                                    </a>
                                @elseif($canDelete)
                                    <div style="display:inline-flex; align-items:center; gap:10px;">
    <button type="button"
        onclick="openEditCalendarModal(this, '{{ data_get($ev, 'id') }}', '{{ data_get($ev, 'tanggal') ?? data_get($ev, 'date') ?? data_get($ev, 'date_str') ?? '' }}', '{{ data_get($ev, 'jenis') ?? data_get($ev, 'type') ?? 'tugas' }}', @js(data_get($ev, 'judul') ?? data_get($ev, 'title') ?? ''), @js(data_get($ev, 'keterangan') ?? data_get($ev, 'description') ?? ''))"
        style="color:#fbbf24; font-size:12px; font-weight:700; background:none; border:none; cursor:pointer; padding:0;">
        ✏️ Edit
    </button>
    <form action="{{ route('calendar.destroy', $ev['id']) }}" method="POST" onsubmit="return confirm('Hapus penanda ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] font-bold text-red-400 hover:underline shrink-0" style="color:#f87171; font-size:12px; font-weight:700; background:none; border:none; cursor:pointer; padding:0; display:inline-flex; align-items:center; gap:4px;">🗑️ Hapus</button>
                                    </form>
</div>
</div>
                                @endif
                            </div>
                        @endforeach
                    @endforeach

                    @if(!$hasAnyEvent)
                        <p class="text-xs opacity-70 text-center py-4">Belum ada tanggal yang ditandai di bulan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectCalendarDate(dateStr) {
            const input = document.getElementById('cal-date-input');
            if (input) {
                input.value = dateStr;
                input.focus();
            }
        }
    </script>
<div id="edit-calendar-modal" class="hidden fixed inset-0 z-[9995] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
    <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-extrabold">✏️ Edit Agenda Kalender</h3>
            <button type="button" onclick="closeEditCalendarModal()" class="text-sm font-bold opacity-75 hover:opacity-100">✕</button>
        </div>

        <form id="edit-calendar-form" method="POST" class="space-y-3.5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold mb-1">Tanggal</label>
                <input type="date" id="edit-cal-tanggal" name="tanggal" required class="w-full rounded-xl border p-2.5 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Jenis Agenda</label>
                <select id="edit-cal-jenis" name="jenis" style="background-color:#0f172a; color:#f8fafc;" class="w-full rounded-xl border p-2.5 text-sm">
    <option value="tugas" style="background-color:#0f172a; color:#f8fafc;">📌 Tugas / Deadline</option>
    <option value="ulangan" style="background-color:#0f172a; color:#f8fafc;">📙 Ulangan / ATS / PAS</option>
    <option value="acara" style="background-color:#0f172a; color:#f8fafc;">🎉 Acara / Kegiatan Kelas</option>
    <option value="hari_besar" style="background-color:#0f172a; color:#f8fafc;">🇮🇩 Memperingati Hari Besar</option>
    <option value="event" style="background-color:#0f172a; color:#f8fafc;">✨ Event Lainnya</option>
</select>
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Judul Agenda</label>
                <input type="text" id="edit-cal-judul" name="judul" required class="w-full rounded-xl border p-2.5 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Keterangan (Opsional)</label>
                <textarea id="edit-cal-keterangan" name="keterangan" rows="3" class="w-full rounded-xl border p-2.5 text-sm"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditCalendarModal()" class="px-4 py-2 rounded-xl border theme-border text-xs font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl theme-primary text-xs font-extrabold shadow-md">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function parseIndoDateToIso(text) {
        const months = {
            jan: '01', januari: '01',
            feb: '02', februari: '02',
            mar: '03', maret: '03',
            apr: '04', april: '04',
            mei: '05', may: '05',
            jun: '06', juni: '06',
            jul: '07', juli: '07',
            agu: '08', agt: '08', agustus: '08', aug: '08',
            sep: '09', september: '09',
            okt: '10', oktober: '10', oct: '10',
            nov: '11', november: '11',
            des: '12', desember: '12', dec: '12'
        };
        const m = (text || '').match(/(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})/);
        if (!m) return '';
        const day = m[1].padStart(2, '0');
        const mon = months[m[2].toLowerCase()] || '01';
        return `${m[3]}-${mon}-${day}`;
    }

    function openEditCalendarModal(btnEl, id, tanggal, jenis, judul, keterangan) {
        if (typeof playSfx === 'function') playSfx('click');
        const form = document.getElementById('edit-calendar-form');
        form.action = `/kalender/${id}`;

        let isoDate = (tanggal || '').toString().slice(0, 10);
        if (!/^\d{4}-\d{2}-\d{2}$/.test(isoDate) && btnEl) {
            const card = btnEl.closest('div.rounded-xl, div.rounded-2xl, div.border, li') || btnEl.parentElement?.parentElement;
            if (card) isoDate = parseIndoDateToIso(card.innerText);
        }

        document.getElementById('edit-cal-tanggal').value = isoDate;
                const rawJenis = (jenis || '').toLowerCase();
        const cardText = (btnEl?.closest('div.rounded-xl, div.rounded-2xl, div.border, li')?.innerText || '').toLowerCase();
        let mappedJenis = 'tugas';
        if (rawJenis.includes('ulang') || rawJenis.includes('ats') || rawJenis.includes('pas') || cardText.includes('ulangan / ats')) mappedJenis = 'ulangan';
        else if (rawJenis.includes('acara') || rawJenis.includes('kegiatan') || cardText.includes('acara / kegiatan')) mappedJenis = 'acara';
        else if (rawJenis.includes('besar') || rawJenis.includes('memperingati') || cardText.includes('hari besar')) mappedJenis = 'hari_besar';
        else if (rawJenis.includes('event') || rawJenis.includes('lain') || cardText.includes('event lainnya')) mappedJenis = 'event';
        document.getElementById('edit-cal-jenis').value = mappedJenis;
        document.getElementById('edit-cal-judul').value = judul || '';
        document.getElementById('edit-cal-keterangan').value = keterangan || '';
        document.getElementById('edit-calendar-modal').classList.remove('hidden');
    }

    function closeEditCalendarModal() {
        document.getElementById('edit-calendar-modal').classList.add('hidden');
    }
</script>

<!-- Modal Create Agenda Langsung Saat Klik Hari -->
<div id="quick-create-day-modal" class="hidden fixed inset-0 z-[9996] flex items-center justify-center bg-black/75 backdrop-blur-sm p-4">
    <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between gap-2">
            <div>
                <h3 class="text-lg font-extrabold">📅 Tandai Tanggal Kalender</h3>
                <p id="qc-day-subtitle" class="text-xs opacity-75">Isi detail agenda untuk tanggal yang dipilih.</p>
            </div>
            <button type="button" onclick="closeQuickCreateDayModal()" class="px-2.5 py-1 rounded-lg border theme-border text-xs font-bold hover:opacity-80">✕</button>
        </div>

        <form id="quick-create-day-form" method="POST" action="{{ url('/kalender') }}" class="space-y-3.5">
            @csrf

            <div>
                <label class="block text-xs font-bold mb-1">Tanggal</label>
                <input type="date" id="qc-tanggal" name="tanggal" required class="w-full rounded-xl border p-2.5 text-sm" style="background-color:#0f172a; color:#f8fafc;">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Jenis Penanda</label>
                <select id="qc-jenis" name="jenis" class="w-full rounded-xl border p-2.5 text-sm" style="background-color:#0f172a; color:#f8fafc;">
                    <option value="tugas" style="background-color:#0f172a; color:#f8fafc;">📌 Tugas / Deadline</option>
                    <option value="pr" style="background-color:#0f172a; color:#f8fafc;">🏠 PR (Pekerjaan Rumah)</option>
                    <option value="ulangan" style="background-color:#0f172a; color:#f8fafc;">📙 Ulangan / ATS / PAS</option>
                    <option value="acara" style="background-color:#0f172a; color:#f8fafc;">🎉 Acara / Kegiatan Kelas</option>
                    <option value="hari_besar" style="background-color:#0f172a; color:#f8fafc;">🇮🇩 Memperingati Hari Besar</option>
                    <option value="event" style="background-color:#0f172a; color:#f8fafc;">✨ Event Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Judul Agenda</label>
                <input type="text" id="qc-judul" name="judul" placeholder="Contoh: Tugas / Event Hari Sabtu..." required class="w-full rounded-xl border p-2.5 text-sm" style="background-color:#0f172a; color:#f8fafc;">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Keterangan (Opsional)</label>
                <textarea id="qc-keterangan" name="keterangan" rows="3" placeholder="Catatan tambahan..." class="w-full rounded-xl border p-2.5 text-sm" style="background-color:#0f172a; color:#f8fafc;"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeQuickCreateDayModal()" class="px-4 py-2 rounded-xl border theme-border text-xs font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl theme-primary text-xs font-extrabold shadow-md">Simpan Penanda</button>
            </div>
        </form>
    </div>
</div>



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

            // Cari pembungkus khusus form create (pastikan tidak menyembunyikan daftar "Agenda Bulan")
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
            // Jika wrapper juga memuat "Agenda Bulan", sembunyikan elemen saudara sebelum Agenda Bulan saja
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
</x-app-layout>
