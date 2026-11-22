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

        $pptsList = $students->filter(function ($s) {
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return $tag === 'ppts';
        })->values();

        $exPptsList = $students->filter(function ($s) {
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return in_array($tag, ['ex_ppts', 'ex ppts', 'exppts']);
        })->values();

        $adminArchie = $students->first(function ($s) {
            $name = strtolower(trim((string) ($s->name ?? $s->nama ?? '')));
            $tag = strtolower(trim((string) ($s->hierarchy ?? $s->role ?? $s->jabatan ?? '')));
            return str_contains($name, 'archie') || $tag === 'admin';
        });

        $featuredIds = collect([
            $walas->id ?? null,
            $ketuaKelas->id ?? null,
            $wakilKetua->id ?? null,
            $adminArchie->id ?? null,
        ])->merge($pptsList->pluck('id'))->merge($exPptsList->pluck('id'))->filter();

        $members = $students->reject(fn($s) => $featuredIds->contains($s->id))->values();
        $latestApprovedFrame = \App\Models\FrameChangeRequest::where('status', 'approved')->latest()->first();
    @endphp

    <style>
        .clickable-person-btn {
            cursor: pointer;
            transition: transform 0.18s ease, border-color 0.18s ease, background-color 0.18s ease;
        }
        .clickable-person-btn:hover {
            transform: translateY(-2px);
            border-color: var(--primary) !important;
        }
        .person-avatar {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            background: var(--primary-soft);
            border: 1.5px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .role-chip {
            display: inline-block;
            background: var(--primary);
            color: #ffffff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.05em;
            padding: 2px 8px;
            border-radius: 5px;
            text-transform: uppercase;
        }
        .tree-vline {
            width: 1.5px;
            height: 18px;
            background: var(--border-color);
            margin: 0 auto;
        }
        .tree-hline {
            position: relative;
            width: 56%;
            max-width: 320px;
            height: 16px;
            margin: 0 auto;
            border-top: 1.5px solid var(--border-color);
        }
        .tree-hline::before,
        .tree-hline::after {
            content: "";
            position: absolute;
            top: 0;
            width: 1.5px;
            height: 16px;
            background: var(--border-color);
        }
        .tree-hline::before { left: 0; }
        .tree-hline::after  { right: 0; }
    </style>

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

        <!-- Bagan Hirarki Kelas (Mengikuti Tema Aktif & Bisa Diklik) -->
        <div class="theme-card rounded-2xl shadow-lg p-5 sm:p-8 border theme-border space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h1 class="text-lg sm:text-2xl font-extrabold">Struktur & Anggota Kelas XI RPL 1</h1>
                    <p class="text-xs opacity-75">Klik salah satu nama untuk melihat detail dan mengedit gambar bingkainya.</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold border theme-border theme-soft">
                        ← Jadwal
                    </a>
                    @if(Route::has('students.create'))
                        <a href="{{ route('students.create') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-extrabold theme-primary">
                            + Tambah Siswa
                        </a>
                    @endif
                </div>
            </div>

            <!-- Wali Kelas -->
            @php
                $wName = $walas->name ?? $walas->nama ?? 'Wali Kelas';
                $wRole = $walas->hierarchy ?? $walas->role ?? $walas->jabatan ?? 'walas';
                $wFrame = $walas->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
            @endphp
            <div class="text-center space-y-1.5">
                <button type="button"
                        onclick="openPersonModal({
                            id: '{{ $walas->id ?? '' }}',
                            name: @js($wName),
                            role: @js($wRole),
                            nis: @js($walas->nis ?? '-'),
                            frame: @js($wFrame ? asset('storage/' . $wFrame) : '')
                        })"
                        class="clickable-person-btn inline-flex flex-col items-center gap-1 px-4 py-2 rounded-xl border border-transparent">
                    <span class="role-chip">WALI KELAS</span>
                    <div class="person-avatar">
                        @if($wFrame)
                            <img src="{{ asset('storage/' . $wFrame) }}" alt="{{ $wName }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-extrabold">{{ strtoupper(substr($wName, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="text-xs sm:text-sm font-extrabold">{{ $wName }}</div>
                </button>
                <div class="tree-vline"></div>
                <div class="tree-hline"></div>
            </div>

            <!-- Ketua Kelas & Wakil Ketua Kelas -->
            @php
                $kName = $ketuaKelas->name ?? $ketuaKelas->nama ?? 'Ketua Kelas';
                $kRole = $ketuaKelas->hierarchy ?? $ketuaKelas->role ?? $ketuaKelas->jabatan ?? 'ketua_kelas';
                $kFrame = $ketuaKelas->frame_path ?? ($latestApprovedFrame->frame_path ?? null);

                $vkName = $wakilKetua->name ?? $wakilKetua->nama ?? 'Wakil Ketua Kelas';
                $vkRole = $wakilKetua->hierarchy ?? $wakilKetua->role ?? $wakilKetua->jabatan ?? 'wakil_ketua';
                $vkFrame = $wakilKetua->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
            @endphp
            <div class="grid grid-cols-2 gap-4 max-w-md mx-auto text-center">
                <button type="button"
                        onclick="openPersonModal({
                            id: '{{ $ketuaKelas->id ?? '' }}',
                            name: @js($kName),
                            role: @js($kRole),
                            nis: @js($ketuaKelas->nis ?? '-'),
                            frame: @js($kFrame ? asset('storage/' . $kFrame) : '')
                        })"
                        class="clickable-person-btn flex flex-col items-center gap-1 p-2 rounded-xl border border-transparent">
                    <span class="role-chip">KETUA KELAS</span>
                    <div class="person-avatar">
                        @if($kFrame)
                            <img src="{{ asset('storage/' . $kFrame) }}" alt="{{ $kName }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-extrabold">{{ strtoupper(substr($kName, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="text-xs font-bold">{{ $kName }}</div>
                </button>

                <button type="button"
                        onclick="openPersonModal({
                            id: '{{ $wakilKetua->id ?? '' }}',
                            name: @js($vkName),
                            role: @js($vkRole),
                            nis: @js($wakilKetua->nis ?? '-'),
                            frame: @js($vkFrame ? asset('storage/' . $vkFrame) : '')
                        })"
                        class="clickable-person-btn flex flex-col items-center gap-1 p-2 rounded-xl border border-transparent">
                    <span class="role-chip">WAKIL KETUA KELAS</span>
                    <div class="person-avatar">
                        @if($vkFrame)
                            <img src="{{ asset('storage/' . $vkFrame) }}" alt="{{ $vkName }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-extrabold">{{ strtoupper(substr($vkName, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="text-xs font-bold">{{ $vkName }}</div>
                </button>
            </div>

            <!-- Baris Peran Khusus: PPTS, EX PPTS & Admin / Archie L -->
            <div class="pt-2 border-t theme-border space-y-3">
                <div class="text-center">
                    <span class="text-[11px] font-extrabold tracking-wider uppercase opacity-85">
                        PPTS • EX PPTS • ADMIN / ARCHIE L
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-3xl mx-auto text-center">
                    @php
                        $pptsItem = $pptsList->first();
                        $pptsName = $pptsItem->name ?? $pptsItem->nama ?? 'PPTS';
                        $pptsFrame = $pptsItem->frame_path ?? ($latestApprovedFrame->frame_path ?? null);

                        $exPptsItem = $exPptsList->first();
                        $exPptsName = $exPptsItem->name ?? $exPptsItem->nama ?? 'EX PPTS';
                        $exPptsFrame = $exPptsItem->frame_path ?? ($latestApprovedFrame->frame_path ?? null);

                        $archName = $adminArchie->name ?? $adminArchie->nama ?? 'Archie L';
                        $archRole = $adminArchie->hierarchy ?? $adminArchie->role ?? $adminArchie->jabatan ?? 'Admin';
                        $archFrame = $adminArchie->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                    @endphp

                    <button type="button"
                            onclick="openPersonModal({
                                id: '{{ $pptsItem->id ?? '' }}',
                                name: @js($pptsName),
                                role: 'PPTS',
                                nis: @js($pptsItem->nis ?? '-'),
                                frame: @js($pptsFrame ? asset('storage/' . $pptsFrame) : '')
                            })"
                            class="clickable-person-btn flex flex-col items-center gap-1 p-2.5 rounded-xl border theme-border theme-soft">
                        <span class="role-chip">PPTS</span>
                        <div class="person-avatar">
                            @if($pptsFrame)
                                <img src="{{ asset('storage/' . $pptsFrame) }}" alt="{{ $pptsName }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-extrabold">P</span>
                            @endif
                        </div>
                        <div class="text-xs font-bold truncate max-w-full">{{ $pptsName }}</div>
                    </button>

                    <button type="button"
                            onclick="openPersonModal({
                                id: '{{ $exPptsItem->id ?? '' }}',
                                name: @js($exPptsName),
                                role: 'EX PPTS',
                                nis: @js($exPptsItem->nis ?? '-'),
                                frame: @js($exPptsFrame ? asset('storage/' . $exPptsFrame) : '')
                            })"
                            class="clickable-person-btn flex flex-col items-center gap-1 p-2.5 rounded-xl border theme-border theme-soft">
                        <span class="role-chip">EX PPTS</span>
                        <div class="person-avatar">
                            @if($exPptsFrame)
                                <img src="{{ asset('storage/' . $exPptsFrame) }}" alt="{{ $exPptsName }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-extrabold">EX</span>
                            @endif
                        </div>
                        <div class="text-xs font-bold truncate max-w-full">{{ $exPptsName }}</div>
                    </button>

                    <button type="button"
                            onclick="openPersonModal({
                                id: '{{ $adminArchie->id ?? '' }}',
                                name: @js($archName),
                                role: @js($archRole),
                                nis: @js($adminArchie->nis ?? '-'),
                                frame: @js($archFrame ? asset('storage/' . $archFrame) : '')
                            })"
                            class="clickable-person-btn col-span-2 flex flex-col items-center gap-1 p-2.5 rounded-xl border theme-border theme-soft">
                        <span class="role-chip">ADMIN / ARCHIE L</span>
                        <div class="person-avatar">
                            @if($archFrame)
                                <img src="{{ asset('storage/' . $archFrame) }}" alt="{{ $archName }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-extrabold">AL</span>
                            @endif
                        </div>
                        <div class="text-xs font-bold truncate max-w-full">{{ $archName }}</div>
                    </button>
                </div>
            </div>

            <!-- Anggota Kelas XI RPL 1 -->
            <div class="pt-3 border-t theme-border space-y-4">
                <div class="text-center">
                    <span class="text-[11px] font-extrabold tracking-widest uppercase opacity-85">
                        ANGGOTA KELAS XI RPL 1
                    </span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-y-4 gap-x-2 text-center">
                    @foreach($members as $member)
                        @php
                            $mName = $member->name ?? $member->nama ?? 'Siswa';
                            $mRole = $member->hierarchy ?? $member->role ?? $member->jabatan ?? 'siswa';
                            $mFrame = $member->frame_path ?? ($latestApprovedFrame->frame_path ?? null);
                        @endphp
                        <button type="button"
                                onclick="openPersonModal({
                                    id: '{{ $member->id ?? '' }}',
                                    name: @js($mName),
                                    role: @js($mRole),
                                    nis: @js($member->nis ?? '-'),
                                    frame: @js($mFrame ? asset('storage/' . $mFrame) : '')
                                })"
                                class="clickable-person-btn flex flex-col items-center gap-1 p-1.5 rounded-xl border border-transparent min-w-0">
                            <div class="person-avatar">
                                @if($mFrame)
                                    <img src="{{ asset('storage/' . $mFrame) }}" alt="{{ $mName }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-extrabold">{{ strtoupper(substr(trim((string) $mName), 0, 1)) ?: 'S' }}</span>
                                @endif
                            </div>
                            <div class="text-[11px] font-semibold truncate w-full" title="{{ $mName }}">
                                {{ $mName }}
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail & Mode Edit Gambar Bingkai (Muncul Saat Item Diklik) -->
    <div id="person-detail-modal" class="fixed inset-0 z-[9995] hidden items-center justify-center bg-black/60 p-4">
        <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-5 space-y-4">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <span id="modal-person-role" class="role-chip">ROLE</span>
                    <h2 id="modal-person-name" class="text-base sm:text-lg font-extrabold mt-1.5">Nama</h2>
                    <p id="modal-person-nis" class="text-xs opacity-75">NIS: -</p>
                </div>
                <button type="button" onclick="closePersonModal()" class="px-2.5 py-1 rounded-lg text-xs font-extrabold border theme-border">
                    ✕
                </button>
            </div>

            <div class="flex items-center gap-3 p-3 rounded-xl border theme-border theme-soft">
                <div id="modal-person-avatar" class="person-avatar shrink-0"></div>
                <div class="text-xs">
                    <div class="font-bold">Data Terpilih</div>
                    <div class="opacity-75">Klik <b>Edit</b> untuk mengganti gambar bingkai (menunggu persetujuan Admin).</div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <button type="button" onclick="togglePersonEditMode()" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                    ✏️ Edit
                </button>
            </div>

            <!-- Form Edit & Upload Gambar Hanya Muncul Saat Tombol Edit Ditekan -->
            <div id="person-edit-section" class="hidden pt-3 border-t theme-border space-y-3">
                <form action="{{ route('siswa.frame.request') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="hidden" id="modal-student-id" name="student_id" value="">

                    <div>
                        <label class="block text-xs font-bold mb-1">Pilih Gambar Bingkai Baru</label>
                        <input type="file" name="frame_image" accept="image/*" required class="w-full rounded-xl border p-2 text-xs">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closePersonModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold border theme-border">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                            Simpan & Ajukan ke Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openPersonModal(data) {
            const modal = document.getElementById('person-detail-modal');
            const editSec = document.getElementById('person-edit-section');
            const avatarBox = document.getElementById('modal-person-avatar');

            document.getElementById('modal-person-name').textContent = data.name || '-';
            document.getElementById('modal-person-role').textContent = (data.role || 'SISWA').toUpperCase();
            document.getElementById('modal-person-nis').textContent = 'NIS: ' + (data.nis && data.nis !== '' ? data.nis : '-');
            document.getElementById('modal-student-id').value = data.id || '';

            if (data.frame) {
                avatarBox.innerHTML = `<img src="${data.frame}" alt="${data.name}" class="w-full h-full object-cover">`;
            } else {
                const initial = (data.name || 'S').trim().charAt(0).toUpperCase() || 'S';
                avatarBox.innerHTML = `<span class="text-sm font-extrabold">${initial}</span>`;
            }

            editSec.classList.add('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePersonModal() {
            const modal = document.getElementById('person-detail-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function togglePersonEditMode() {
            document.getElementById('person-edit-section').classList.toggle('hidden');
        }
    </script>
</x-app-layout>