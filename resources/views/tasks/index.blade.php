<x-app-layout>
    <div class="theme-card rounded-2xl shadow-md p-6 mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold">Daftar Tugas, PR & Event Kelas</h1>
            <p class="text-xs sm:text-sm opacity-75 mt-0.5">Gabungan seluruh tenggat dari semua mata pelajaran XI RPL 1.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach(['semua' => 'Semua', 'tugas' => 'ðŸ“Œ Tugas', 'pr' => 'ðŸ  PR', 'event' => 'ðŸŽ‰ Event'] as $key => $label)
                <a href="{{ route('tasks.index', ['filter' => $key]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === $key ? 'theme-primary shadow-sm' : 'theme-soft border theme-border hover:opacity-80' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        @forelse($tasks as $post)
            @php
                $isDone = $post->reactions->where('emoji', 'âœ…')->where('user_id', Auth::id())->isNotEmpty();
                $statusBadge = null;
                if ($post->tanggal_deadline && !$isDone) {
                    $today = \Carbon\Carbon::today();
                    $deadline = \Carbon\Carbon::parse($post->tanggal_deadline)->startOfDay();
                    $diffDays = $today->diffInDays($deadline, false);

                    if ($diffDays <= 0) {
                        $statusBadge = [
                            'label' => $diffDays === 0 ? 'ðŸš¨ HARI INI DEADLINE' : 'ðŸš¨ LEWAT DEADLINE',
                            'style' => 'background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444;',
                        ];
                    } elseif ($diffDays <= 2) {
                        $statusBadge = [
                            'label' => 'âš ï¸ WAKTU MEPET (' . $diffDays . ' HARI LAGI)',
                            'style' => 'background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b;',
                        ];
                    }
                }
            @endphp

            <div class="theme-card rounded-2xl shadow-md p-5 border border-gray-200/30 {{ $isDone ? 'opacity-70' : '' }}">
                <div class="flex flex-wrap justify-between items-start gap-3">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="text-[11px] font-extrabold uppercase px-2.5 py-0.5 rounded-full theme-primary">
                                {{ $post->subject->kode_mapel ?? 'MAPEL' }}
                            </span>
                            <span class="text-[11px] font-bold uppercase px-2.5 py-0.5 rounded-full theme-soft border theme-border">
                                {{ strtoupper($post->kategori) }}
                            </span>
                            @if($isDone)
                                <span class="text-[11px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500">
                                    âœ… Sudah Dikerjakan
                                </span>
                            @elseif($statusBadge)
                                <span style="{{ $statusBadge['style'] }}" class="text-[11px] font-extrabold px-2.5 py-0.5 rounded-full">
                                    {{ $statusBadge['label'] }}
                                </span>
                            @endif
                        </div>

                        <h2 class="text-lg font-bold">{{ $post->judul }}</h2>
                        <p class="text-xs opacity-75 mt-0.5">
                            {{ $post->subject->nama_mapel ?? '' }} â€¢ Oleh <strong>{{ $post->user->name ?? 'User' }}</strong>
                            @if($post->tanggal_deadline)
                                â€¢ Tenggat: <strong>{{ \Carbon\Carbon::parse($post->tanggal_deadline)->format('d M Y') }}</strong>
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('posts.react', $post->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="emoji" value="âœ…">
                            <button type="submit"
                                    class="px-3 py-1.5 rounded-xl text-xs font-bold border transition {{ $isDone ? 'theme-primary border-transparent' : 'theme-soft theme-border hover:opacity-85' }}">
                                {{ $isDone ? 'âœ… Selesai' : 'â˜‘ï¸ Tandai Selesai' }}
                            </button>
                        </form>

                        <a href="{{ route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori]) }}"
                           class="px-3 py-1.5 rounded-xl text-xs font-bold theme-soft border theme-border hover:opacity-85">
                            Buka Mapel â†’
                        </a>
                    </div>
                </div>

                @if($post->deskripsi)
                    <p class="mt-3 text-sm opacity-90 whitespace-pre-line">{{ $post->deskripsi }}</p>
                @endif

                <!-- Lampiran Foto / Video Tugas, PR & Event -->
                @if($post->attachments && $post->attachments->count() > 0)
                    <div class="mt-4 flex flex-wrap gap-2.5">
                        @foreach($post->attachments as $file)
                            @if($file->file_type === 'video')
                                <video controls style="width: 180px; height: 110px;" class="rounded-xl border theme-border object-cover">
                                    <source src="{{ asset('storage/' . $file->file_path) }}">
                                </video>
                            @else
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran"
                                         style="width: 92px; height: 92px; object-fit: cover;"
                                         class="rounded-xl border theme-border hover:scale-105 transition">
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="theme-card rounded-2xl shadow-md p-10 text-center opacity-75">
                Belum ada tugas, PR, atau event yang tercatat.
            </div>
        @endforelse
    </div>
<!-- MODULE-POLISH-V6-START -->
<style id="module-polish-v6">
    /* Tugas & Materi: spacing card lebih lega & empty state lebih jelas */
    main .task-card,
    main .material-card {
        padding: 1rem 1.15rem;
        border-radius: 14px;
    }

    main .empty-state-box {
        padding: 2rem 1.25rem;
        border-radius: 16px;
        line-height: 1.6;
    }

    /* Admin users: jarak antar kontrol lebih rapi */
    main table th,
    main table td {
        padding: 0.65rem 0.75rem;
        vertical-align: middle;
    }

    </style>
<!-- MODULE-POLISH-V6-END -->
</x-app-layout>
