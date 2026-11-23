<x-app-layout>
    @php
        $uid = (int) auth()->id();
        $activeFilter = strtolower(trim((string) request()->query('filter', 'semua')));

        $postTbl = \Illuminate\Support\Facades\Schema::hasTable('subject_posts')
            ? 'subject_posts'
            : (\Illuminate\Support\Facades\Schema::hasTable('subject_items') ? 'subject_items' : null);

        $subjMap = \Illuminate\Support\Facades\Schema::hasTable('subjects')
            ? \Illuminate\Support\Facades\DB::table('subjects')->get()->keyBy('id')
            : collect();

        $userMap = \Illuminate\Support\Facades\Schema::hasTable('users')
            ? \Illuminate\Support\Facades\DB::table('users')->get()->keyBy('id')
            : collect();

        if ($postTbl) {
            $q = \Illuminate\Support\Facades\DB::table($postTbl)->orderByDesc('id');
            if (\Illuminate\Support\Facades\Schema::hasColumn($postTbl, 'status')) {
                $q->where('status', 'approved');
            }
            $allRecords = $q->get();

            $listItems = $allRecords->map(function ($row) use ($subjMap, $userMap) {
                $row->type = strtolower(trim((string) ($row->category ?? $row->kategori ?? $row->type ?? $row->jenis ?? 'tugas')));
                $row->title = $row->title ?? $row->judul ?? 'Tanpa Judul';
                $row->description = $row->description ?? $row->deskripsi ?? $row->content ?? '';
                $row->due_date = $row->due_date ?? $row->deadline ?? $row->tanggal_deadline ?? null;
                $row->subject = isset($row->subject_id) ? $subjMap->get($row->subject_id) : null;
                $row->author = isset($row->user_id) ? $userMap->get($row->user_id) : null;
                return $row;
            });
        } else {
            $listItems = collect($tasks ?? $items ?? [])->map(function ($row) {
                $row->type = strtolower(trim((string) ($row->type ?? $row->category ?? 'tugas')));
                $row->title = $row->title ?? $row->judul ?? 'Tanpa Judul';
                $row->description = $row->description ?? $row->deskripsi ?? '';
                $row->due_date = $row->due_date ?? $row->deadline ?? null;
                return $row;
            });
        }

        if ($activeFilter !== 'semua' && in_array($activeFilter, ['catatan', 'pr', 'tugas', 'event'], true)) {
            $listItems = $listItems->where('type', $activeFilter)->values();
        }
    @endphp

    <div class="max-w-5xl mx-auto space-y-5">
        <!-- Header List Tugas + Filter Pojok Kanan Atas -->
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">📋 List Tugas & Catatan Kelas</h1>
                <p class="text-xs opacity-75 mt-1">Filter berdasarkan Catatan, PR, Tugas, atau Event.</p>
            </div>

            <!-- Filter Pojok Kanan Atas -->
            <div class="flex flex-wrap items-center gap-1.5 sm:justify-end">
                @foreach(['semua' => 'Semua', 'catatan' => '📝 Catatan', 'pr' => '🏠 PR', 'tugas' => '📌 Tugas', 'event' => '🎉 Event'] as $fKey => $fLabel)
                    <a href="{{ url()->current() }}?filter={{ $fKey }}"
                       class="px-3 py-1.5 rounded-xl border theme-border text-xs font-extrabold transition {{ $activeFilter === $fKey ? 'theme-primary shadow' : 'theme-soft hover:opacity-90' }}">
                        {{ $fLabel }}
                    </a>
                @endforeach
            </div>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($listItems as $t)
                @php
                    $doneArr = is_array($t->completed_by ?? null)
                        ? $t->completed_by
                        : (json_decode((string) ($t->completed_by ?? '[]'), true) ?: []);
                    $isDone = in_array($uid, array_map('intval', $doneArr), true);
                    $subjName = $t->subject->nama_mapel ?? $t->subject->name ?? $t->subject->kode_mapel ?? 'Mata Pelajaran';
                    $detailUrl = \Illuminate\Support\Facades\Route::has('subjects.show') && !empty($t->subject_id)
                        ? route('subjects.show', ['subject' => $t->subject_id, 'tab' => $t->type])
                        : url('/mapel/' . ($t->subject_id ?? 1) . '?tab=' . $t->type);
                @endphp
                <div class="theme-card border theme-border rounded-2xl p-5 flex flex-col justify-between gap-3 shadow">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded theme-primary text-[10px] font-extrabold uppercase">{{ $t->type }}</span>
                                <span class="text-xs font-extrabold opacity-85">{{ $subjName }}</span>
                            </div>
                            @if(!empty($t->due_date))
                                <span class="text-[11px] font-bold opacity-75">📅 {{ \Carbon\Carbon::parse($t->due_date)->format('d M Y') }}</span>
                            @endif
                        </div>

                        <h3 class="text-base font-extrabold {{ $isDone ? 'line-through opacity-60' : '' }}">{{ $t->title }}</h3>

                        @if(!empty($t->author->name))
                            <div class="text-[11px] opacity-70">Dibuat oleh <strong>{{ $t->author->name }}</strong></div>
                        @endif

                        @if(!empty($t->description))
                            <p class="text-xs opacity-85 whitespace-pre-line">{{ $t->description }}</p>
                        @endif

                        @if(!empty($t->media_path))
                            <div class="pt-1">
                                @if(($t->media_type ?? 'image') === 'video')
                                    <video controls class="w-full max-h-64 rounded-xl border theme-border bg-black">
                                        <source src="{{ asset($t->media_path) }}">
                                    </video>
                                @else
                                    <img src="{{ asset($t->media_path) }}" alt="{{ $t->title }}"
                                         class="w-full max-h-64 object-cover rounded-xl border theme-border">
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="pt-3 border-t theme-border flex items-center justify-between gap-2">
                        <a href="{{ $detailUrl }}"
                           class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                            💬 Buka & Komentar
                        </a>

                        @if(in_array($t->type, ['tugas', 'pr', 'event'], true) && \Illuminate\Support\Facades\Route::has('items.toggle-complete'))
                            <form action="{{ route('items.toggle-complete', $t->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-xl text-xs font-extrabold border {{ $isDone ? 'bg-emerald-500 text-white border-emerald-500' : 'theme-primary border-transparent' }}">
                                    {{ $isDone ? '✅ Selesai' : '⬜ Tandai Selesai' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada item pada kategori "{{ ucfirst($activeFilter) }}".
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>