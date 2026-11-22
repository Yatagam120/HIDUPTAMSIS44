<x-app-layout>
    @php
        $students = $students ?? \App\Models\Student::orderBy('id')->get();

        $walas = $students->first(function ($s) {
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return in_array($tag, ['walas', 'wali_kelas', 'wali kelas']);
        });

        $ketuaKelas = $students->first(function ($s) {
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return in_array($tag, ['ketua_kelas', 'ketua kelas']);
        });

        $wakilKetua = $students->first(function ($s) {
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return in_array($tag, ['wakil_ketua', 'wakil ketua', 'wakil ketua kelas']);
        });

        $excludedIds = collect([$walas->id ?? null, $ketuaKelas->id ?? null, $wakilKetua->id ?? null])->filter();
        $members = $students->reject(fn($s) => $excludedIds->contains($s->id))->values();

        $myPendingFrame = \App\Models\FrameChangeRequest::where('user_id', auth()->id())->where('status', 'pending')->latest()->first();
        $latestApprovedFrame = \App\Models\FrameChangeRequest::where('status', 'approved')->latest()->first();
    @endphp

    <style>
        .tamsis-green-chart {
            background: radial-gradient(circle at top, #0b4f36 0%, #063524 60%, #042418 100%);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #ecfdf5;
        }
        .chart-avatar-ring {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.16);
            border: 2px solid rgba(110, 231, 183, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .chart-role-badge {
            display: inline-block;
            background: #059669;
            color: #ffffff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.06em;
            padding: 2px 10px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .chart-vline {
            width: 1.5px;
            height: 20px;
            background: rgba(167, 243, 208, 0.45);
            margin: 0 auto;
        }
        .chart-hline-wrap {
            position: relative;
            width: 56%;
            max-width: 340px;
            height: 18px;
            margin: 0 auto;
            border-top: 1.5px solid rgba(167, 243, 208, 0.45);
        }
        .chart-hline-wrap::before,
        .chart-hline-wrap::after {
            content: "";
            position: absolute;
            top: 0;
            width: 1.5px;
            height: 18px;
            background: rgba(167, 243, 208, 0.45);
        }
        .chart-hline-wrap::before { left: 0; }
        .chart-hline-wrap::after  { right: 0; }
    </style>

    <div class="max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-200 border border-emerald-400/40 text-xs sm:text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-200 border border-red-400/40 text-xs sm:text-sm font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Bagan Hirarki Kelas Bergaya Hijau -->
        <div class="tamsis-green-chart rounded-2xl shadow-xl p-5 sm:p-8 space-y-6">
            <div class="flex items-center justify-between gap-2">
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-950/70 hover:bg-emerald-900 border border-emerald-400/30 text-emerald-100">
                    ← Jadwal
                </a>

                @if(Route::has('students.create'))
                    <a href="{{ route('students.create') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-extrabold bg-emerald-600 hover:bg-emerald-500 text-white shadow">
                        + Tambah Siswa
                    </a>
                @endif
            </div>

            <!-- Puncak: Wali Kelas -->
            <div class="text-center space-y-1.5">
                @php
                    $walasName = $walas->name ?? $walas->nama ?? 'Wali Kelas';
                    $walasFrame = $walas->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                @endphp
                <div class="chart-avatar-ring">
                    @if($walasFrame)
                        <img src="{{ asset('storage/' . $walasFrame) }}" alt="{{ $walasName }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    @endif
                </div>
                <div class="text-xs sm:text-sm font-extrabold text-white">{{ $walasName }}</div>
                <div class="chart-vline"></div>
                <div class="chart-hline-wrap"></div>
            </div>

            <!-- Tingkat 2: Ketua Kelas & Wakil Ketua Kelas -->
            <div class="grid grid-cols-2 gap-4 max-w-md mx-auto text-center">
                <div class="space-y-1.5">
                    <span class="chart-role-badge" data-i18n="ketua_badge">KETUA KELAS</span>
                    @php
                        $ketuaName = $ketuaKelas->name ?? $ketuaKelas->nama ?? 'Ketua Kelas';
                        $ketuaFrame = $ketuaKelas->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                    @endphp
                    <div class="chart-avatar-ring">
                        @if($ketuaFrame)
                            <img src="{{ asset('storage/' . $ketuaFrame) }}" alt="{{ $ketuaName }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="text-xs font-bold text-emerald-50">{{ $ketuaName }}</div>
                </div>

                <div class="space-y-1.5">
                    <span class="chart-role-badge" data-i18n="wakil_badge">WAKIL KETUA KELAS</span>
                    @php
                        $wakilName = $wakilKetua->name ?? $wakilKetua->nama ?? 'Wakil Ketua Kelas';
                        $wakilFrame = $wakilKetua->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                    @endphp
                    <div class="chart-avatar-ring">
                        @if($wakilFrame)
                            <img src="{{ asset('storage/' . $wakilFrame) }}" alt="{{ $wakilName }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="text-xs font-bold text-emerald-50">{{ $wakilName }}</div>
                </div>
            </div>

            <!-- Tingkat 3: Anggota Kelas XI RPL 1 -->
            <div class="pt-3 space-y-4">
                <div class="text-center">
                    <span class="text-[11px] font-extrabold tracking-widest uppercase text-emerald-200/90" data-i18n="anggota_badge">
                        ANGGOTA KELAS XI RPL 1
                    </span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-y-5 gap-x-3 text-center">
                    @foreach($members as $member)
                        @php
                            $mName = $member->name ?? $member->nama ?? 'Siswa';
                            $mFrame = $member->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                        @endphp
                        <div class="space-y-1 min-w-0">
                            <div class="chart-avatar-ring">
                                @if($mFrame)
                                    <img src="{{ asset('storage/' . $mFrame) }}" alt="{{ $mName }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-emerald-200" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="text-[11px] font-semibold text-emerald-50/95 truncate px-0.5" title="{{ $mName }}">
                                {{ $mName }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pengajuan Ganti Gambar Bingkai Siswa (Wajib Izin Admin) -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold" data-i18n="frame_title">🖼️ Ganti Gambar Bingkai Siswa</h2>
                    <p class="text-xs opacity-75" data-i18n="frame_sub">Murid bisa mengajukan gambar bingkai siswa. Gambar baru baru diproses setelah mendapat izin / persetujuan Admin.</p>
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
                        <div class="opacity-80">Belum diproses ke bingkai siswa sebelum Admin menekan Setujui.</div>
                    </div>
                </div>
            @endif

            <form action="{{ route('siswa.frame.request') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                @csrf

                @if($students->isNotEmpty())
                    <select name="student_id" class="rounded-xl border px-3 py-2.5 text-xs font-bold">
                        <option value="">-- Pilih Siswa (Opsional) --</option>
                        @foreach($students as $st)
                            @php $stName = $st->name ?? $st->nama ?? ('Siswa #' . $st->id); @endphp
                            <option value="{{ $st->id }}">{{ $stName }}</option>
                        @endforeach
                    </select>
                @endif

                <input type="file" name="frame_image" accept="image/*" required
                       class="rounded-xl border p-2 text-xs">

                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold theme-primary shadow-md hover:opacity-90 transition"
                        data-i18n="frame_submit">
                    Ajukan Ganti Bingkai
                </button>
            </form>
        </div>
    </div>
</x-app-layout>