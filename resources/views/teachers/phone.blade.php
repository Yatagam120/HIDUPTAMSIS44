<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-5">
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold">📞 Nomor WhatsApp Guru XI RPL 1</h1>
                <p class="text-xs opacity-75 mt-1">
                    {{ $isHighAuth ? 'Anda memiliki otoritas tinggi: nomor langsung tayang & dapat memverifikasi pengajuan siswa.' : 'Pengajuan nomor baru dari siswa/ex-PPTS akan diverifikasi Admin / Ketua Kelas terlebih dahulu.' }}
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">← Kembali ke Jadwal Utama</a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah / Ajukan Nomor Guru -->
        <form action="{{ route('teachers.phone.store') }}" method="POST" class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
            @csrf
            <div class="text-sm font-extrabold">➕ {{ $isHighAuth ? 'Tambah Nomor WA Guru' : 'Ajukan Nomor WA Guru Baru' }}</div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="teacher_name" required placeholder="Nama Guru (mis. Pak Budi, S.Kom)"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <input type="text" name="subject_name" placeholder="Mata Pelajaran (mis. Pemrograman Lanjut)"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <input type="text" name="phone_number" required placeholder="No. WA (mis. 6281234567890)"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
            </div>
            <button type="submit" class="theme-primary px-4 py-2 rounded-xl text-xs font-extrabold shadow">
                {{ $isHighAuth ? 'Simpan Langsung' : 'Ajukan ke Admin' }}
            </button>
        </form>

        <!-- Daftar Nomor Guru -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($contacts as $c)
                @php
                    $waClean = preg_replace('/[^0-9]/', '', $c->phone_number);
                    if (str_starts_with($waClean, '0')) {
                        $waClean = '62' . substr($waClean, 1);
                    }
                @endphp
                <div class="theme-card border theme-border rounded-2xl p-4 flex flex-col justify-between gap-3 shadow">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm font-extrabold">{{ $c->teacher_name }}</span>
                            @if($c->status === 'pending')
                                <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/40 text-[10px] font-extrabold">
                                    Menunggu ACC
                                </span>
                            @endif
                        </div>
                        <div class="text-xs opacity-75 mt-0.5">{{ $c->subject_name ?: 'Guru Mapel / Wali' }}</div>
                        <div class="mt-2 font-mono text-xs font-bold tracking-wide" style="color: var(--primary);">
                            {{ $c->phone_number }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-2 pt-2 border-t theme-border">
                        <a href="https://wa.me/{{ $waClean }}" target="_blank" rel="noopener"
                           class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white text-xs font-extrabold hover:opacity-90">
                            💬 Chat WA
                        </a>

                        @if($isHighAuth)
                            <div class="flex items-center gap-1.5">
                                @if($c->status === 'pending')
                                    <form action="{{ route('teachers.phone.approve', $c->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-sky-500 text-white text-[11px] font-extrabold">
                                            ✓ ACC
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('teachers.phone.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus nomor guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-red-500/20 text-red-400 border border-red-500/40 text-[11px] font-extrabold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                    Belum ada nomor WhatsApp guru yang tersimpan.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>