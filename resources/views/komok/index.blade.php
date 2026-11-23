<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-[10px] font-extrabold uppercase tracking-wider mb-1">
                    🔒 Ruang Eksklusif Pengurus Inti (Ketua, Wakil, PPTS, Admin)
                </span>
                <h1 class="text-xl sm:text-2xl font-extrabold">🎭 Galeri & Arsip Komok</h1>
                <p class="text-xs opacity-75 mt-0.5">Khusus Ketua Kelas, Wakil Ketua Kelas, PPTS, dan Admin.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                ← Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 rounded-xl bg-rose-500/20 border border-rose-500/40 text-rose-300 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('komok.store') }}" method="POST" enctype="multipart/form-data"
              class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow-lg">
            @csrf
            <h2 class="text-sm font-extrabold">📸 Posting ke Komok</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="title" placeholder="Judul postingan (opsional)"
                       class="sm:col-span-2 rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <label class="px-3 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold cursor-pointer flex items-center justify-center gap-1.5">
                    <span>+ Pilih Foto / Video</span>
                    <input type="file" name="media" accept="image/*,video/*" required class="hidden"
                           onchange="document.getElementById('komok-file-name').textContent = this.files[0] ? this.files[0].name : '';">
                </label>
            </div>
            <div id="komok-file-name" class="text-[11px] font-bold opacity-75"></div>
            <textarea name="caption" rows="2" placeholder="Keterangan / caption..."
                      class="w-full rounded-xl border theme-border px-3 py-2 text-xs"></textarea>
            <button type="submit" class="theme-primary px-4 py-2 rounded-xl text-xs font-extrabold shadow">
                Posting ke Komok
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse(($posts ?? collect()) as $p)
                <div class="theme-card border theme-border rounded-2xl overflow-hidden flex flex-col justify-between shadow">
                    <div>
                        @if(($p->media_type ?? 'image') === 'video' && !empty($p->media_path))
                            <video controls class="w-full max-h-80 bg-black">
                                <source src="{{ asset($p->media_path) }}">
                            </video>
                        @elseif(!empty($p->resolved_src))
                            <img src="{{ $p->resolved_src }}" alt="{{ $p->title ?? 'Komok' }}"
                                 class="w-full max-h-80 object-cover">
                        @else
                            <div class="p-8 text-center text-xs opacity-60 bg-black/20">
                                ⚠️ File media lama terhapus saat rebuild server. Silakan upload ulang.
                            </div>
                        @endif

                        <div class="p-4 space-y-1">
                            @if(!empty($p->title))
                                <h3 class="text-sm font-extrabold">{{ $p->title }}</h3>
                            @endif
                            @if(!empty($p->caption))
                                <p class="text-xs opacity-85 whitespace-pre-line">{{ $p->caption }}</p>
                            @endif
                            <div class="text-[11px] opacity-65 pt-1">
                                Diunggah oleh <strong>{{ $p->author->name ?? 'Pengurus' }}</strong>
                                @if(!empty($p->created_at))
                                    • {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-4 flex justify-end">
                        <form action="{{ route('komok.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus postingan Komok ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 rounded-lg bg-rose-500/20 text-rose-300 border border-rose-500/40 text-xs font-bold">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada foto atau video di Komok.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>