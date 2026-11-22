<x-app-layout>
    <!-- Header Halaman List Tugas, PR & Event -->
    <div class="theme-card rounded-2xl shadow-md p-6 mb-6 border-l-4 theme-border flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold">Daftar Tugas, PR & Event</h1>
            <p class="text-xs sm:text-sm opacity-75 mt-1">Rekap seluruh tugas, PR, dan event dari semua mata pelajaran XI RPL 1.</p>
        </div>

        <!-- Filter Semua / Tugas / PR / Event -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('tasks.index', ['kategori' => 'semua']) }}"
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition shadow-sm {{ $filter === 'semua' ? 'theme-primary' : 'theme-soft border theme-border hover:opacity-80' }}">
                Semua ({{ $tasks->count() }})
            </a>
            <a href="{{ route('tasks.index', ['kategori' => 'tugas']) }}"
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition shadow-sm {{ $filter === 'tugas' ? 'theme-primary' : 'theme-soft border theme-border hover:opacity-80' }}">
                Tugas
            </a>
            <a href="{{ route('tasks.index', ['kategori' => 'pr']) }}"
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition shadow-sm {{ $filter === 'pr' ? 'theme-primary' : 'theme-soft border theme-border hover:opacity-80' }}">
                PR
            </a>
            <a href="{{ route('tasks.index', ['kategori' => 'event']) }}"
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition shadow-sm {{ $filter === 'event' ? 'theme-primary' : 'theme-soft border theme-border hover:opacity-80' }}">
                Event
            </a>
        </div>
    </div>

    <!-- Daftar Kartu Tugas, PR & Event -->
    <div class="space-y-4">
        @forelse($tasks as $post)
            @php
                $statusBadge = null;
                if ($post->tanggal_deadline) {
                    $today = \Carbon\Carbon::today();
                    $deadline = \Carbon\Carbon::parse($post->tanggal_deadline)->startOfDay();
                    $diffDays = $today->diffInDays($deadline, false);

                    if ($diffDays <= 0) {
                        $statusBadge = [
                            'label' => $post->kategori === 'event'
                                ? ($diffDays === 0 ? '🎉 HARI INI ACARANYA' : '📅 EVENT SELESAI')
                                : ($diffDays === 0 ? '🚨 HARI INI DEADLINE' : '🚨 LEWAT DEADLINE'),
                            'style' => 'background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444;',
                        ];
                    } elseif ($diffDays <= 2) {
                        $statusBadge = [
                            'label' => '⚠️ SEBENTAR LAGI (' . $diffDays . ' HARI LAGI)',
                            'style' => 'background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b;',
                        ];
                    }
                }
                $isDoneByMe = $post->reactions->where('emoji', '✅')->where('user_id', Auth::id())->isNotEmpty();
            @endphp

            <div class="theme-card rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200/30">
                <div class="flex flex-wrap justify-between items-start gap-3">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <!-- Badge Mata Pelajaran -->
                            <a href="{{ route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori]) }}"
                               class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-0.5 rounded-full theme-primary shadow-sm hover:opacity-90">
                                {{ $post->subject->kode_mapel }} — {{ $post->subject->nama_mapel }}
                            </a>

                            <!-- Badge Kategori Tugas / PR / Event -->
                            <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full theme-soft border theme-border" style="color: var(--primary);">
                                {{ strtoupper($post->kategori) }}
                            </span>

                            @if($statusBadge)
                                <span style="{{ $statusBadge['style'] }}" class="text-[10px] sm:text-xs font-extrabold px-2.5 py-0.5 rounded-full">
                                    {{ $statusBadge['label'] }}
                                </span>
                            @endif

                            @if($isDoneByMe)
                                <span class="text-[10px] sm:text-xs font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500">
                                    ✅ {{ $post->kategori === 'event' ? 'Ikut / Siap' : 'Sudah Dikerjakan' }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold mt-1">{{ $post->judul }}</h3>

                        <p class="text-xs opacity-75 mt-1">
                            Oleh <strong>{{ $post->user->name }}</strong>
                            @if($post->tanggal_deadline)
                                • {{ $post->kategori === 'event' ? 'Tanggal Acara:' : 'Tenggat:' }}
                                <span class="font-bold">{{ \Carbon\Carbon::parse($post->tanggal_deadline)->format('d M Y') }}</span>
                            @else
                                • Tanpa batas waktu
                            @endif
                        </p>
                    </div>

                    <a href="{{ route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori]) }}"
                       class="text-xs font-bold px-3.5 py-2 rounded-xl theme-soft border theme-border hover:opacity-85 transition shrink-0" style="color: var(--primary);">
                        Buka Mapel →
                    </a>
                </div>

                @if($post->deskripsi)
                    <p class="mt-3 text-sm leading-relaxed whitespace-pre-line opacity-90">{{ $post->deskripsi }}</p>
                @endif

                @if($post->attachments && $post->attachments->count() > 0)
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($post->attachments as $file)
                            @if($file->file_type !== 'video')
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran"
                                         style="width: 72px; height: 72px; object-fit: cover;"
                                         class="rounded-xl border theme-border hover:scale-105 transition">
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Tombol Cepat Checklist Selesai ✅ -->
                <div class="mt-4 pt-3 border-t border-gray-200/30 flex items-center justify-between flex-wrap gap-2">
                    <form action="{{ route('posts.react', $post->id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="emoji" value="✅">
                        <button type="submit"
                                class="px-3 py-1 rounded-full text-xs font-bold border transition flex items-center gap-1.5 {{ $isDoneByMe ? 'theme-primary border-transparent shadow-sm' : 'theme-soft border-gray-300/40 hover:opacity-80' }}">
                            <span>✅</span>
                            <span>
                                @if($post->kategori === 'event')
                                    {{ $isDoneByMe ? 'Sudah Siap / Ikut' : 'Tandai Ikut' }}
                                @else
                                    {{ $isDoneByMe ? 'Sudah Dikerjakan' : 'Tandai Selesai' }}
                                @endif
                            </span>
                            <span>({{ $post->reactions->where('emoji', '✅')->count() }})</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="theme-card rounded-2xl shadow-md p-10 text-center opacity-75">
                🎉 Mantap! Tidak ada tugas, PR, maupun event yang tercatat saat ini.
            </div>
        @endforelse
    </div>
</x-app-layout>