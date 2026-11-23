<x-app-layout>
    @php
        $uid = (int) auth()->id();
        $listItems = $tasks ?? $items ?? collect();
    @endphp

    <div class="max-w-5xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">📌 Daftar Semua Tugas, PR & Event</h1>
                <p class="text-xs opacity-75 mt-1">Lihat lampiran foto & video, cek tenggat waktu, dan tandai tugas yang sudah selesai.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                ← Kembali ke Jadwal Utama
            </a>
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
                    $subjName = $t->subject->nama_mapel ?? $t->subject->kode_mapel ?? 'Mata Pelajaran';
                @endphp
                <div class="theme-card border theme-border rounded-2xl p-5 flex flex-col justify-between gap-3 shadow">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded theme-primary text-[10px] font-extrabold uppercase">{{ $t->type }}</span>
                                <span class="text-xs font-extrabold opacity-85">{{ $subjName }}</span>
                            </div>
                            @if($t->due_date)
                                <span class="text-[11px] font-bold opacity-75">📅 {{ \Carbon\Carbon::parse($t->due_date)->format('d M Y') }}</span>
                            @endif
                        </div>

                        <h3 class="text-base font-extrabold {{ $isDone ? 'line-through opacity-60' : '' }}">{{ $t->title }}</h3>

                        @if($t->description)
                            <p class="text-xs opacity-85 whitespace-pre-line">{{ $t->description }}</p>
                        @endif

                        <!-- Media Foto & Video di List Tugas (#5) -->
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
                        <a href="{{ route('subjects.show', ['subject' => $t->subject_id, 'tab' => $t->type]) }}"
                           class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                            💬 Buka & Komentar
                        </a>

                        <form action="{{ route('items.toggle-complete', $t->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1.5 rounded-xl text-xs font-extrabold border {{ $isDone ? 'bg-emerald-500 text-white border-emerald-500' : 'theme-primary border-transparent' }}">
                                {{ $isDone ? '✅ Selesai' : '⬜ Tandai Selesai' }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada Tugas, PR, atau Event yang tercatat.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>