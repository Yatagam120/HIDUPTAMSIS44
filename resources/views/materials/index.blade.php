<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">📚 Bank Materi Ujian (AAS, ATS, Ulangan)</h1>
                <p class="text-xs opacity-75 mt-1">Kumpulan kisi-kisi, rangkuman, foto catatan, video pembahasan, dan dokumen ujian XI RPL 1.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">← Kembali ke Jadwal Utama</a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Jenis Ujian -->
        <div class="flex flex-wrap gap-2">
            @foreach(['Semua', 'AAS', 'ATS', 'Ulangan', 'Rangkuman'] as $jenis)
                <a href="{{ route('materials.index', ['jenis' => $jenis]) }}"
                   class="px-3 py-1.5 rounded-xl border theme-border text-xs font-extrabold {{ ($examFilter ?? 'Semua') === $jenis ? 'theme-primary' : 'theme-card' }}">
                    {{ $jenis }}
                </a>
            @endforeach
        </div>

        <!-- Form Upload Materi -->
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data"
              class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
            @csrf
            <div class="text-sm font-extrabold">➕ Tambah Materi / Kisi-Kisi Baru</div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="title" required placeholder="Judul Materi (mis. Kisi-kisi AAS Pemrograman)"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <select name="exam_type" class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                    <option value="AAS">AAS (Asesmen Akhir Semester)</option>
                    <option value="ATS">ATS (Asesmen Tengah Semester)</option>
                    <option value="Ulangan">Ulangan Harian</option>
                    <option value="Rangkuman">Rangkuman / Modul</option>
                </select>
                <input type="text" name="subject_name" placeholder="Nama Mapel (mis. MTK / PL)"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
            </div>
            <textarea name="description" rows="2" placeholder="Catatan ringkas atau poin kisi-kisi..."
                      class="w-full rounded-xl border theme-border px-3 py-2 text-xs"></textarea>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold cursor-pointer hover:opacity-90">
                    <span class="text-base leading-none font-black">+</span>
                    <span id="material-file-label">Unggah File / Foto / Video</span>
                    <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.webp,.mp4,.webm"
                       class="hidden" onchange="document.getElementById('material-file-label').textContent = this.files[0]?.name || 'Unggah File / Foto / Video'">
                </label>
                <button type="submit" class="theme-primary px-4 py-2 rounded-xl text-xs font-extrabold shadow">
                    Upload Materi
                </button>
            </div>
        </form>

        <!-- Daftar Materi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($materials as $m)
                <div class="theme-card border theme-border rounded-2xl p-4 space-y-3 shadow flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-0.5 rounded-full theme-primary text-[10px] font-extrabold">{{ $m->exam_type }}</span>
                            <span class="text-[11px] opacity-70 font-bold">{{ $m->subject_name ?: 'Umum' }}</span>
                        </div>
                        <h3 class="text-sm font-extrabold">{{ $m->title }}</h3>
                        @if($m->description)
                            <p class="text-xs opacity-80 whitespace-pre-line">{{ $m->description }}</p>
                        @endif

                        @if($m->file_path)
                            @if($m->file_type === 'image')
                                <img src="{{ asset($m->file_path) }}" alt="{{ $m->title }}"
                                     class="w-full max-h-56 object-cover rounded-xl border theme-border">
                            @elseif($m->file_type === 'video')
                                <video controls class="w-full max-h-56 rounded-xl border theme-border bg-black">
                                    <source src="{{ asset($m->file_path) }}">
                                </video>
                            @else
                                <a href="{{ asset($m->file_path) }}" target="_blank"
                                   class="inline-flex items-center gap-2 px-3 py-2 rounded-xl theme-soft border theme-border text-xs font-extrabold">
                                    📄 Buka / Download Dokumen Materi
                                </a>
                            @endif
                        @endif
                    </div>

                    @if($isHighAuth)
                        <div class="pt-2 border-t theme-border flex justify-end">
                            <form action="{{ route('materials.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-red-500/20 text-red-400 border border-red-500/40 text-[11px] font-extrabold">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada materi ujian yang diunggah.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>