<x-app-layout>
    @php
        $allItems = collect($tasks ?? $items ?? $posts ?? []);
        $currentUserId = (int) auth()->id();

        $userIds = $allItems->pluck('user_id')->filter()->unique()->values();
        $usersMap = $userIds->isNotEmpty()
            ? \App\Models\User::whereIn('id', $userIds)->pluck('name', 'id')
            : collect();

        $typeBadges = [
            'tugas' => ['label' => 'TUGAS', 'class' => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/40'],
            'pr'    => ['label' => 'PR',    'class' => 'bg-purple-500/20 text-purple-300 border-purple-500/40'],
            'event' => ['label' => 'EVENT', 'class' => 'bg-amber-500/20 text-amber-300 border-amber-500/40'],
        ];
    @endphp

    <div class="max-w-5xl mx-auto space-y-4 sm:space-y-5 px-2 sm:px-0">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold hover:opacity-80" style="color: var(--primary);">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

        <div class="theme-card rounded-2xl p-4 sm:p-6 border theme-border space-y-1">
            <h1 class="text-lg sm:text-2xl font-extrabold">Daftar Tugas, PR & Event</h1>
            <p class="text-xs sm:text-sm opacity-75">Semua tugas, PR, dan agenda dari seluruh mata pelajaran.</p>
        </div>

        <!-- Filter Cepat -->
        <div class="grid grid-cols-4 sm:flex sm:flex-wrap gap-1.5 sm:gap-2">
            <button type="button" onclick="filterTasksList('all', this)" class="task-filter-btn theme-primary px-2.5 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-extrabold border theme-border">
                Semua ({{ $allItems->count() }})
            </button>
            <button type="button" onclick="filterTasksList('tugas', this)" class="task-filter-btn theme-card px-2.5 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-extrabold border theme-border">
                Tugas ({{ $allItems->where('type', 'tugas')->count() }})
            </button>
            <button type="button" onclick="filterTasksList('pr', this)" class="task-filter-btn theme-card px-2.5 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-extrabold border theme-border">
                PR ({{ $allItems->where('type', 'pr')->count() }})
            </button>
            <button type="button" onclick="filterTasksList('event', this)" class="task-filter-btn theme-card px-2.5 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-extrabold border theme-border">
                Event ({{ $allItems->where('type', 'event')->count() }})
            </button>
        </div>

        <div class="space-y-3" id="tasks-list-container">
            @forelse($allItems as $task)
                @php
                    $tType = strtolower(trim((string) ($task->type ?? 'tugas')));
                    $badge = $typeBadges[$tType] ?? $typeBadges['tugas'];

                    $subjName = $task->subject->nama_mapel
                        ?? $task->subject->name
                        ?? $task->subject->kode_mapel
                        ?? 'Mata Pelajaran';
                    $subjKode = $task->subject->kode_mapel ?? '';

                    $authorName = $usersMap[(int) ($task->user_id ?? 0)] ?? 'Siswa';

                    $completedBy = is_array($task->completed_by ?? null)
                        ? $task->completed_by
                        : (json_decode($task->completed_by ?? '[]', true) ?: []);
                    $isDone = in_array($currentUserId, array_map('intval', $completedBy), true);

                    $dueText = null;
                    $dueClass = 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40';
                    $dueStatus = 'TENGGAT';

                    if (!empty($task->due_date)) {
                        try {
                            $due = \Carbon\Carbon::parse($task->due_date)->startOfDay();
                            $diff = now()->startOfDay()->diffInDays($due, false);
                            $dueText = $due->translatedFormat('d M Y');
                            if ($diff < 0) {
                                $dueClass = 'bg-red-500/25 text-red-200 border-red-500/50';
                                $dueStatus = 'LEWAT TENGGAT';
                            } elseif ($diff === 0) {
                                $dueClass = 'bg-red-500/25 text-red-200 border-red-500/50';
                                $dueStatus = 'HARI INI';
                            } elseif ($diff <= 2) {
                                $dueClass = 'bg-amber-500/25 text-amber-200 border-amber-500/50';
                                $dueStatus = 'TENGGAT DEKAT';
                            }
                        } catch (\Throwable $e) {
                            $dueText = (string) $task->due_date;
                        }
                    }
                @endphp

                <div data-task-type="{{ $tType }}" class="task-card-item theme-card rounded-2xl p-4 sm:p-5 border theme-border space-y-2.5 {{ $isDone ? 'opacity-70' : '' }}">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase border {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                            <a href="{{ route('subjects.show', ['subject' => $task->subject_id, 'tab' => $tType]) }}"
                               class="px-2.5 py-0.5 rounded-md text-[10px] sm:text-xs font-extrabold theme-soft hover:underline"
                               style="color: var(--primary);">
                                {{ $subjKode ? $subjKode . ' - ' : '' }}{{ $subjName }}
                            </a>
                            @if($dueText && !$isDone)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $dueClass }}">
                                    ⏰ {{ $dueStatus }}: {{ $dueText }}
                                </span>
                            @endif
                        </div>

                        @if(in_array($tType, ['tugas', 'pr'], true) && \Illuminate\Support\Facades\Route::has('items.toggle-complete'))
                            <form method="POST" action="{{ route('items.toggle-complete', $task->id) }}">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1 rounded-lg text-[11px] font-extrabold border {{ $isDone ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'theme-soft theme-border' }}">
                                    {{ $isDone ? '✅ Selesai' : '☑️ Tandai Selesai' }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <div>
                        <a href="{{ route('subjects.show', ['subject' => $task->subject_id, 'tab' => $tType]) }}"
                           class="text-sm sm:text-base font-extrabold uppercase hover:underline">
                            {{ $task->title ?? 'Tanpa Judul' }}
                        </a>
                        <div class="text-[11px] opacity-75 mt-0.5">
                            Oleh <strong>{{ $authorName }}</strong>
                            @if($dueText)
                                • Tenggat: <strong>{{ $dueText }}</strong>
                            @endif
                        </div>
                    </div>

                    @if(!empty($task->description))
                        <p class="text-xs sm:text-sm opacity-90 whitespace-pre-line">{{ $task->description }}</p>
                    @endif
                </div>
            @empty
                <div class="theme-card rounded-2xl p-8 border theme-border text-center text-xs sm:text-sm opacity-70">
                    Belum ada Tugas, PR, atau Event yang tercatat.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function filterTasksList(type, btn) {
            document.querySelectorAll('.task-filter-btn').forEach(b => {
                b.classList.remove('theme-primary');
                b.classList.add('theme-card');
            });
            if (btn) {
                btn.classList.remove('theme-card');
                btn.classList.add('theme-primary');
            }

            document.querySelectorAll('.task-card-item').forEach(card => {
                if (type === 'all' || card.dataset.taskType === type) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }
    </script>
</x-app-layout>