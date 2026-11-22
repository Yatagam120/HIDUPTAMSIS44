<x-app-layout>
    @php
        $students = $students ?? \App\Models\Student::orderBy('id')->get();
        $myPendingFrame = \App\Models\FrameChangeRequest::where('user_id', auth()->id())->where('status', 'pending')->latest()->first();
        $latestApprovedFrame = \App\Models\FrameChangeRequest::where('status', 'approved')->latest()->first();
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs sm:text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-300 border border-red-500/40 text-xs sm:text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Header Daftar Siswa -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-lg sm:text-2xl font-extrabold">Anggota Kelas XI RPL 1</h1>
                <p class="text-xs sm:text-sm opacity-75 mt-0.5">Daftar siswa dan struktur pengurus kelas XI RPL 1.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-extrabold border theme-border theme-soft hover:opacity-90">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

        <!-- Grid Kartu Siswa -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($students as $student)
                @php
                    $activeFrame = $student->frame_path ?: ($latestApprovedFrame->frame_path ?? null);
                @endphp
                <div class="theme-card rounded-2xl shadow-md p-4 border theme-border flex items-center gap-3.5">
                    <div class="relative w-16 h-16 shrink-0 rounded-2xl overflow-hidden border-2 theme-border theme-soft flex items-center justify-center">
                        @if($activeFrame)
                            <img src="{{ asset('storage/' . $activeFrame) }}" alt="Bingkai {{ $student->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-extrabold opacity-80">{{ strtoupper(substr($student->name ?? 'S', 0, 1)) }}</span>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="font-extrabold text-sm truncate">{{ $student->name }}</div>
                        @if(!empty($student->nis))
                            <div class="text-xs opacity-75">NIS: {{ $student->nis }}</div>
                        @endif
                        @if(!empty($student->jabatan))
                            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold theme-primary">
                                {{ $student->jabatan }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="theme-card rounded-2xl p-6 border theme-border col-span-full text-center text-xs sm:text-sm opacity-75">
                    Belum ada data siswa yang tercatat.
                </div>
            @endforelse
        </div>

        <!-- Form Pengajuan Ganti Gambar Bingkai Siswa (Wajib Persetujuan Admin) -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold">🖼️ Ganti Gambar Bingkai Siswa</h2>
                    <p class="text-xs opacity-75">Murid bisa mengajukan gambar bingkai siswa. Gambar baru baru diproses dan aktif setelah mendapat izin / persetujuan Admin.</p>
                </div>

                @if($myPendingFrame)
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-500/20 text-amber-300 border border-amber-400/40">
                        ⏳ Menunggu Izin Admin
                    </span>
                @elseif($latestApprovedFrame)
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-400/40">
                        ✅ Bingkai Disetujui Admin
                    </span>
                @endif
            </div>

            @if($myPendingFrame)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-amber-400/40 bg-amber-500/10 text-xs">
                    <img src="{{ asset('storage/' . $myPendingFrame->frame_path) }}" alt="Bingkai Menunggu Izin" class="w-12 h-12 rounded-xl object-cover border border-amber-400/40">
                    <div>
                        <div class="font-extrabold text-amber-300">Permintaan Bingkai Sedang Ditinjau Admin</div>
                        <div class="opacity-80">Belum diterapkan ke bingkai siswa sebelum Admin menekan Setujui.</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('siswa.frame.request') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                @csrf

                @if($students->isNotEmpty())
                    <select name="student_id" class="rounded-xl border px-3 py-2.5 text-xs font-bold">
                        <option value="">-- Pilih Siswa (Opsional) --</option>
                        @foreach($students as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                @endif

                <input type="file" name="frame_image" accept="image/*" required
                       class="rounded-xl border p-2 text-xs">

                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold theme-primary shadow-md hover:opacity-90 transition">
                    Ajukan Ganti Bingkai
                </button>
            </form>
        </div>
    </div>
</x-app-layout>