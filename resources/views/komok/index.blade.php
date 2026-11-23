<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/40 text-[10px] font-extrabold mb-1">
                    🔒 RUANG EKSKLUSIF PENGURUS INTI (KETUA, WAKIL, PPTS, ADMIN)
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold">🎭 Galeri & Arsip Komok</h1>
                <p class="text-xs opacity-75 mt-1">Khusus Ketua Kelas, Wakil Ketua Kelas, PPTS, dan Admin.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 rounded-xl bg-red-500/20 border border-red-500/40 text-red-300 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form Upload Foto / Video Komok dengan tombol "+" -->
        <form action="{{ route('komok.store') }}" method="POST" enctype="multipart/form-data"
              class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
            @csrf
            <div class="text-sm font-extrabold">📸 Posting ke Komok</div>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="title" placeholder="Judul postingan (opsional)"
                       class="flex-1 rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <label class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold cursor-pointer hover:opacity-90 shrink-0">
                    <span class="text-base leading-none font-black">+</span>
                    <span id="komok-file-label">Pilih Foto / Video</span>
                    <input type="file" name="media" required accept="image/*,video/mp4,video/webm,video/quicktime" class="hidden"
                           onchange="document.getElementById('komok-file-label').textContent = this.files[0]?.name || 'Pilih Foto / Video'">
                </label>
            </div>
            <textarea name="caption" rows="2" placeholder="Keterangan / caption..."
                      class="w-full rounded-xl border theme-border px-3 py-2 text-xs"></textarea>
            <button type="submit" class="theme-primary px-5 py-2 rounded-xl text-xs font-extrabold shadow">
                Posting ke Komok
            </button>
        </form>

        <!-- Feed Media Komok (Ukuran Card & Gambar Proporsional) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($posts as $p)
                <div class="theme-card border theme-border rounded-2xl overflow-hidden shadow flex flex-col justify-between">
                    <div>
                        <div class="bg-black/40 flex items-center justify-center overflow-hidden max-h-72">
                            @if($p->media_type === 'video')
                                <video controls class="w-full max-h-72 object-contain bg-black">
                                    <source src="{{ asset($p->media_path) }}">
                                </video>
                            @else
                                <img src="{{ asset($p->media_path) }}" alt="{{ $p->title ?? 'Komok' }}"
                                     class="w-full max-h-72 object-contain">
                            @endif
                        </div>

                        <div class="p-4 space-y-1">
                            @if($p->title)
                                <h3 class="text-sm font-extrabold">{{ $p->title }}</h3>
                            @endif
                            @if($p->caption)
                                <p class="text-xs opacity-85 whitespace-pre-line">{{ $p->caption }}</p>
                            @endif
                            <div class="text-[10px] opacity-65 pt-1">
                                Diunggah oleh <strong>{{ $p->author->name ?? 'Pengurus' }}</strong> • {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-3 flex justify-end">
                        <form action="{{ route('komok.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus media Komok ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 rounded-lg bg-red-500/20 text-red-400 border border-red-500/40 text-[11px] font-extrabold">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada media foto atau video di Komok.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>