<x-app-layout>
    <style>
        @keyframes birthdayRainbowSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes birthdayGlowPulse {
            0%, 100% { box-shadow: 0 0 14px rgba(236, 72, 153, 0.7), 0 0 26px rgba(59, 130, 246, 0.55); }
            50% { box-shadow: 0 0 22px rgba(250, 204, 21, 0.9), 0 0 34px rgba(168, 85, 247, 0.75); }
        }
        .birthday-avatar-ring {
            position: relative !important;
            padding: 3px !important;
            border-radius: 9999px !important;
            background: conic-gradient(#ff0055, #ff9900, #ffee00, #00dd77, #0099ff, #aa00ff, #ff0055) !important;
            animation: birthdayGlowPulse 2.2s ease-in-out infinite !important;
        }
        .birthday-avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 9999px;
            background: conic-gradient(#ff0055, #ff9900, #ffee00, #00dd77, #0099ff, #aa00ff, #ff0055);
            z-index: -1;
            animation: birthdayRainbowSpin 3.5s linear infinite;
            filter: blur(4px);
            opacity: 0.85;
        }
        .birthday-name-rainbow {
            background: linear-gradient(90deg, #f43f5e, #f59e0b, #10b981, #3b82f6, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900 !important;
        }
    </style>
    <canvas id="birthday-confetti-canvas" class="fixed inset-0 pointer-events-none z-[99999] hidden"></canvas>
    @php
        $students = $students ?? \App\Models\Student::orderBy('id')->get();
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';

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

        $topIds = collect([$walas->id ?? null, $ketuaKelas->id ?? null, $wakilKetua->id ?? null])->filter();

        // Urutkan anggota kelas berdasarkan nomor absen / abjad nama agar Archie Lionel berada setelah Anisha dan sebelum Azzahra
        $members = $students->reject(fn($s) => $topIds->contains($s->id))
            ->sortBy(function ($s) {
                $absen = $s->absen ?? $s->no_absen ?? $s->nomor_absen ?? null;
                if (!is_null($absen) && is_numeric($absen)) {
                    return str_pad((string) $absen, 4, '0', STR_PAD_LEFT);
                }
                return strtolower(trim((string) ($s->name ?? $s->nama ?? '')));
            })
            ->values();

        $latestApprovedFrame = \App\Models\FrameChangeRequest::where('status', 'approved')->latest()->first();

        $resolveRingStyle = function ($student) {
            $name = strtolower(trim((string) ($student->name ?? $student->nama ?? '')));
            $tag  = strtolower(trim((string) ($student->hierarchy ?? $student->role ?? $student->jabatan ?? '')));

            if (str_contains($name, 'archie') || $tag === 'admin') {
                return 'ring-gold';
            }
            if ($tag === 'ppts') {
                return 'ring-ppts-blue';
            }
            if (in_array($tag, ['ex_ppts', 'ex ppts', 'exppts'])) {
                return 'ring-ex-ppts-grey';
            }
            return 'ring-default';
        };

        $formatStudentPayload = function ($s, $fallbackName, $fallbackRole) use ($resolveRingStyle, $latestApprovedFrame) {
            $name = $s->name ?? $s->nama ?? $fallbackName;
            $role = $s->hierarchy ?? $s->role ?? $s->jabatan ?? $fallbackRole;
            $framePath = $s->frame_path ?? ($latestApprovedFrame->frame_path ?? null);

            $birthDate = $s->birth_date ?? $s->tanggal_lahir ?? '';
            $age = $s->age ?? $s->umur ?? '';
            if (empty($age) && !empty($birthDate)) {
                try {
                    $age = \Carbon\Carbon::parse($birthDate)->age;
                } catch (\Throwable $e) {
                    $age = '';
                }
            }

            return [
                'id'         => $s->id ?? '',
                'name'       => $name,
                'role'       => $role,
                'nis'        => $s->nis ?? '-',
                'birth_date' => $birthDate ? \Carbon\Carbon::parse($birthDate)->format('Y-m-d') : '',
                'age'        => $age !== '' ? (string) $age : '',
                'gender'     => $s->gender ?? $s->jenis_kelamin ?? '',
                'quote'      => $s->quote ?? '',
                'ring'       => $resolveRingStyle($s ?? (object)['name' => $name, 'role' => $role]),
                'frame'      => $framePath ? asset('storage/' . $framePath) : '',
            ];
        };
    @endphp

    <style>
        .org-circle {
            width: 52px;
            height: 52px;
            border-radius: 9999px;
            background: rgba(15, 23, 42, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .ring-default { border: 2px solid rgba(148, 163, 184, 0.55); }
        .ring-ppts-blue {
            border: 2.5px solid #38bdf8;
            box-shadow: 0 0 14px rgba(56, 189, 248, 0.85), 0 0 26px rgba(59, 130, 246, 0.45);
        }
        .ring-ex-ppts-grey {
            border: 2.5px solid #9ca3af;
            box-shadow: 0 0 8px rgba(156, 163, 175, 0.35);
        }
        .ring-gold {
            border: 2.5px solid #fbbf24;
            box-shadow: 0 0 14px rgba(251, 191, 36, 0.8), 0 0 24px rgba(245, 158, 11, 0.4);
        }
        .role-pill-dark {
            display: inline-block;
            background: rgba(15, 23, 42, 0.78);
            color: #f8fafc;
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.06em;
            padding: 2px 10px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .org-vline {
            width: 1.5px;
            height: 22px;
            background: rgba(148, 163, 184, 0.45);
            margin: 0 auto;
        }
        .org-hline {
            position: relative;
            width: 56%;
            max-width: 340px;
            height: 18px;
            margin: 0 auto;
            border-top: 1.5px solid rgba(148, 163, 184, 0.45);
        }
        .org-hline::before,
        .org-hline::after {
            content: "";
            position: absolute;
            top: 0;
            width: 1.5px;
            height: 18px;
            background: rgba(148, 163, 184, 0.45);
        }
        .org-hline::before { left: 0; }
        .org-hline::after  { right: 0; }
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

        <div class="theme-card rounded-2xl shadow-lg p-5 sm:p-8 border theme-border space-y-7">
            <div class="flex items-center justify-between gap-2">
                <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold border theme-border theme-soft">
                    ← Jadwal
                </a>

                @if($isAdmin && Route::has('students.create'))
                    <a href="{{ route('students.create') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-extrabold theme-primary shadow">
                        + Tambah Siswa
                    </a>
                @endif
            </div>

            <!-- Wali Kelas -->
            @php $wPayload = $formatStudentPayload($walas, 'Gunadi', 'walas'); @endphp
            <div class="text-center space-y-1.5">
                <button type="button" onclick='openStudentModal(@json($wPayload))'
                        class="org-node inline-flex flex-col items-center gap-1.5 cursor-pointer focus:outline-none">
                    <div class="org-circle {{ $wPayload['ring'] }}">
                        @if($wPayload['frame'])
                            <img src="{{ $wPayload['frame'] }}" alt="{{ $wPayload['name'] }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 opacity-85" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="text-xs sm:text-sm font-extrabold">{{ $wPayload['name'] }}</div>
                </button>
                <div class="org-vline"></div>
                <div class="org-hline"></div>
            </div>

            <!-- Ketua & Wakil Ketua Kelas -->
            @php
                $kPayload = $formatStudentPayload($ketuaKelas, 'Agung Ismail', 'ketua_kelas');
                $vkPayload = $formatStudentPayload($wakilKetua, 'Kayla Nabilla Putri', 'wakil_ketua');
            @endphp
            <div class="grid grid-cols-2 gap-4 max-w-md mx-auto text-center">
                <div class="space-y-1.5">
                    <span class="role-pill-dark">KETUA KELAS</span>
                    <button type="button" onclick='openStudentModal(@json($kPayload))'
                            class="org-node flex flex-col items-center gap-1.5 mx-auto cursor-pointer focus:outline-none">
                        <div class="org-circle {{ $kPayload['ring'] }}">
                            @if($kPayload['frame'])
                                <img src="{{ $kPayload['frame'] }}" alt="{{ $kPayload['name'] }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 opacity-85" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="text-xs font-bold">{{ $kPayload['name'] }}</div>
                    </button>
                </div>

                <div class="space-y-1.5">
                    <span class="role-pill-dark">WAKIL KETUA KELAS</span>
                    <button type="button" onclick='openStudentModal(@json($vkPayload))'
                            class="org-node flex flex-col items-center gap-1.5 mx-auto cursor-pointer focus:outline-none">
                        <div class="org-circle {{ $vkPayload['ring'] }}">
                            @if($vkPayload['frame'])
                                <img src="{{ $vkPayload['frame'] }}" alt="{{ $vkPayload['name'] }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 opacity-85" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="text-xs font-bold">{{ $vkPayload['name'] }}</div>
                    </button>
                </div>
            </div>

            <!-- Anggota Kelas XI RPL 1 -->
            <div class="pt-2 space-y-4">
                <div class="text-center">
                    <span class="text-[11px] font-extrabold tracking-widest uppercase opacity-90">
                        ANGGOTA KELAS XI RPL 1
                    </span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-y-5 gap-x-2 text-center">
                    @foreach($members as $member)
                        @php $mPayload = $formatStudentPayload($member, 'Siswa', 'murid'); @endphp
                        <button type="button" onclick='openStudentModal(@json($mPayload))'
                                class="org-node flex flex-col items-center gap-1 min-w-0 cursor-pointer focus:outline-none">
                            <div class="org-circle {{ $mPayload['ring'] }}">
                                @if($mPayload['frame'])
                                    <img src="{{ $mPayload['frame'] }}" alt="{{ $mPayload['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 opacity-85" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="text-[11px] font-semibold truncate w-full px-0.5" title="{{ $mPayload['name'] }}">
                                {{ $mPayload['name'] }}
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Murid -->
    <div id="student-detail-modal" class="fixed inset-0 z-[9995] hidden items-center justify-center bg-black/65 p-4 overflow-y-auto">
        <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-5 space-y-4 my-auto">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <span id="smodal-role" class="role-pill-dark">ROLE</span>
                    <h2 id="smodal-name" class="text-base sm:text-lg font-extrabold mt-1.5">Nama</h2>
                    <p id="smodal-nis" class="text-xs opacity-75">NIS: -</p>
                </div>
                <button type="button" onclick="closeStudentModal()" class="px-2.5 py-1 rounded-lg text-xs font-extrabold border theme-border">
                    ✕
                </button>
            </div>

            <div class="flex items-center gap-3.5 p-3 rounded-xl border theme-border theme-soft">
                <div id="smodal-avatar" class="org-circle shrink-0"></div>
                <div class="text-xs space-y-1 min-w-0 flex-1">
                    <div><span class="opacity-70">Tanggal Lahir:</span> <strong id="smodal-birth-date">-</strong></div>
                    <div><span class="opacity-70">Umur:</span> <strong id="smodal-age">-</strong></div>
                    <div><span class="opacity-70">Gender:</span> <strong id="smodal-gender">-</strong></div>
                </div>
            </div>

            <div class="p-3 rounded-xl border theme-border theme-soft text-xs">
                <div class="opacity-70 font-bold mb-1">Quote</div>
                <p id="smodal-quote" class="italic opacity-95">"-"</p>
            </div>

            @if($isAdmin)
                <div class="flex items-center justify-between gap-2 pt-1">
                    <form id="smodal-delete-form" method="POST" action="" onsubmit="return confirm('Hapus data murid ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-extrabold bg-red-600 hover:bg-red-500 text-white">
                            🗑️ Hapus
                        </button>
                    </form>

                    <button type="button" onclick="toggleStudentEditForm()" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                        ✏️ Edit
                    </button>
                </div>

                <!-- Admin: Bisa atur Role/Status (PPTS, EX PPTS, Murid, dll.), Tanggal Lahir, Umur, Gender, Quote & PP/Bingkai -->
                <div id="smodal-edit-box" class="hidden pt-3 border-t theme-border space-y-3">
                    <form id="smodal-edit-form" method="POST" action="" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-[11px] font-bold mb-1">Role / Status Siswa</label>
                            <select id="sedit-role-tag" name="role_tag" class="w-full rounded-xl border px-2.5 py-1.5 text-xs font-bold">
                                <option value="murid">Murid (Standar)</option>
                                <option value="ppts">PPTS (Outline Biru Glowing)</option>
                                <option value="ex_ppts">EX PPTS (Outline Abu-abu)</option>
                                <option value="ketua_kelas">Ketua Kelas</option>
                                <option value="wakil_ketua">Wakil Ketua Kelas</option>
                                <option value="walas">Wali Kelas</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5">
                            <div>
                                <label class="block text-[11px] font-bold mb-1">Tanggal Lahir</label>
                                <input type="date" id="sedit-birth-date" name="birth_date" class="w-full rounded-xl border px-2.5 py-1.5 text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold mb-1">Umur</label>
                                <input type="number" id="sedit-age" name="age" min="1" max="120" placeholder="Otomatis / isi" class="w-full rounded-xl border px-2.5 py-1.5 text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold mb-1">Gender</label>
                            <select id="sedit-gender" name="gender" class="w-full rounded-xl border px-2.5 py-1.5 text-xs font-bold">
                                <option value="">-- Pilih Gender --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold mb-1">Quote</label>
                            <textarea id="sedit-quote" name="quote" rows="2" placeholder="Tulis quote murid..." class="w-full rounded-xl border p-2 text-xs"></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold mb-1">Ganti PP / Bingkai (Opsional)</label>
                            <input type="file" name="frame_image" accept="image/*" class="w-full rounded-xl border p-1.5 text-xs">
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeStudentModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold border theme-border">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Role Murid: Hanya bisa ganti PP murid -->
                <div class="flex justify-end">
                    <button type="button" onclick="toggleStudentEditForm()" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                        🖼️ Ganti PP Murid
                    </button>
                </div>

                <div id="smodal-edit-box" class="hidden pt-3 border-t theme-border space-y-3">
                    <form action="{{ route('siswa.frame.request') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="hidden" id="smodal-student-id" name="student_id" value="">

                        <div>
                            <label class="block text-xs font-bold mb-1">Upload PP / Foto Murid Baru</label>
                            <input type="file" name="frame_image" accept="image/*" required class="w-full rounded-xl border p-2 text-xs">
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeStudentModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold border theme-border">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">
                                Ajukan PP
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        function openStudentModal(data) {
            const modal = document.getElementById('student-detail-modal');
            const editBox = document.getElementById('smodal-edit-box');
            const avatar = document.getElementById('smodal-avatar');

            document.getElementById('smodal-name').textContent = data.name || '-';
            document.getElementById('smodal-role').textContent = (data.role || 'murid').toUpperCase();
            document.getElementById('smodal-nis').textContent = 'NIS: ' + (data.nis && data.nis !== '' ? data.nis : '-');

            document.getElementById('smodal-birth-date').textContent = data.birth_date || '-';
            document.getElementById('smodal-age').textContent = data.age ? (data.age + ' tahun') : '-';
            document.getElementById('smodal-gender').textContent = data.gender || '-';
            document.getElementById('smodal-quote').textContent = data.quote ? `"${data.quote}"` : '"-"';

            avatar.className = 'org-circle shrink-0 ' + (data.ring || 'ring-default');
            if (data.frame) {
                avatar.innerHTML = `<img src="${data.frame}" alt="${data.name}" class="w-full h-full object-cover">`;
            } else {
                avatar.innerHTML = `<svg class="w-6 h-6 opacity-85" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>`;
            }

            const studentIdInput = document.getElementById('smodal-student-id');
            if (studentIdInput) studentIdInput.value = data.id || '';

            const editForm = document.getElementById('smodal-edit-form');
            const delForm = document.getElementById('smodal-delete-form');
            if (editForm && data.id) editForm.action = `/students/${data.id}/profile`;
            if (delForm && data.id) delForm.action = `/students/${data.id}`;

            const roleTagInput = document.getElementById('sedit-role-tag');
            if (roleTagInput) {
                const rawRole = (data.role || 'murid').toLowerCase().trim().replace(/\s+/g, '_');
                const allowed = ['murid', 'ppts', 'ex_ppts', 'ketua_kelas', 'wakil_ketua', 'walas'];
                roleTagInput.value = rawRole === 'exppts' ? 'ex_ppts' : (allowed.includes(rawRole) ? rawRole : 'murid');
            }

            const birthInput = document.getElementById('sedit-birth-date');
            const ageInput = document.getElementById('sedit-age');
            const genderInput = document.getElementById('sedit-gender');
            const quoteInput = document.getElementById('sedit-quote');

            if (birthInput) birthInput.value = data.birth_date || '';
            if (ageInput) ageInput.value = data.age || '';
            if (genderInput) genderInput.value = data.gender || '';
            if (quoteInput) quoteInput.value = data.quote || '';

            editBox.classList.add('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStudentModal() {
            const modal = document.getElementById('student-detail-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function toggleStudentEditForm() {
            document.getElementById('smodal-edit-box').classList.toggle('hidden');
        }
    </script>
    <script>
        (function () {
            const today = new Date();
            const todayMonth = today.getMonth() + 1;
            const todayDay = today.getDate();

            const monthMap = {
                januari: 1, january: 1, jan: 1,
                februari: 2, february: 2, feb: 2,
                maret: 3, march: 3, mar: 3,
                april: 4, apr: 4,
                mei: 5, may: 5,
                juni: 6, june: 6, jun: 6,
                juli: 7, july: 7, jul: 7,
                agustus: 8, august: 8, agu: 8, aug: 8,
                september: 9, sep: 9, sept: 9,
                oktober: 10, october: 10, okt: 10, oct: 10,
                november: 11, nov: 11,
                desember: 12, december: 12, des: 12, dec: 12
            };

            function parseBirthMonthDay(rawStr) {
                if (!rawStr) return null;
                const s = String(rawStr).trim().toLowerCase();

                // Format YYYY-MM-DD
                let m = s.match(/(\d{4})-(\d{1,2})-(\d{1,2})/);
                if (m) return { month: parseInt(m[2], 10), day: parseInt(m[3], 10) };

                // Format DD/MM/YYYY atau DD-MM-YYYY
                m = s.match(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/);
                if (m) return { month: parseInt(m[2], 10), day: parseInt(m[1], 10) };

                // Format "23 November 2009" / "23 Nov"
                m = s.match(/(\d{1,2})\s+([a-z]+)/);
                if (m && monthMap[m[2]]) {
                    return { month: monthMap[m[2]], day: parseInt(m[1], 10) };
                }
                return null;
            }

            let confettiAnimId = null;
            function launchTwitterBirthdayConfetti() {
                const canvas = document.getElementById('birthday-confetti-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                canvas.classList.remove('hidden');

                const colors = ['#ff0055', '#ff9900', '#ffee00', '#00dd77', '#00aaff', '#aa44ff', '#ff66cc'];
                const pieces = Array.from({ length: 150 }, () => ({
                    x: Math.random() * canvas.width,
                    y: Math.random() * -canvas.height,
                    w: 6 + Math.random() * 8,
                    h: 8 + Math.random() * 10,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    vy: 2.8 + Math.random() * 4.2,
                    vx: -2 + Math.random() * 4,
                    rot: Math.random() * 360,
                    vRot: -6 + Math.random() * 12
                }));

                if (confettiAnimId) cancelAnimationFrame(confettiAnimId);
                let frame = 0;

                function draw() {
                    frame++;
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    pieces.forEach(p => {
                        p.x += p.vx;
                        p.y += p.vy;
                        p.rot += p.vRot;
                        ctx.save();
                        ctx.translate(p.x, p.y);
                        ctx.rotate((p.rot * Math.PI) / 180);
                        ctx.fillStyle = p.color;
                        ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
                        ctx.restore();
                    });

                    if (frame < 260) {
                        confettiAnimId = requestAnimationFrame(draw);
                    } else {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        canvas.classList.add('hidden');
                    }
                }
                draw();
            }

            function showBirthdayToastBanner(studentName) {
                let banner = document.getElementById('birthday-celebration-banner');
                if (!banner) {
                    banner = document.createElement('div');
                    banner.id = 'birthday-celebration-banner';
                    banner.className = 'fixed top-16 left-1/2 -translate-x-1/2 z-[99998] px-5 py-3.5 rounded-2xl border-2 border-pink-400/80 bg-zinc-950/95 text-white shadow-2xl text-center max-w-sm w-[92%] backdrop-blur-md transition-all';
                    document.body.appendChild(banner);
                }
                banner.innerHTML = `
                    <div class="text-xl mb-0.5">🎂🎉🎈</div>
                    <div class="text-xs uppercase tracking-wider text-pink-300 font-extrabold">Selamat Ulang Tahun!</div>
                    <div class="text-sm font-black mt-0.5 birthday-name-rainbow">${studentName}</div>
                    <div class="text-[11px] text-zinc-300 mt-1">Semoga panjang umur, sehat selalu, dan sukses di XI RPL 1!</div>
                `;
                banner.classList.remove('hidden');
                clearTimeout(banner._hideTimer);
                banner._hideTimer = setTimeout(() => banner.classList.add('hidden'), 5500);
            }

            document.addEventListener('DOMContentLoaded', () => {
                const birthdayNames = [];

                // Scan semua node/kartu siswa di halaman hirarki
                document.querySelectorAll('[data-birth-date], [data-student-id], button, div').forEach(el => {
                    if (el.dataset.bdayChecked) return;
                    const rawBirth = el.dataset.birthDate || el.getAttribute('data-tanggal-lahir') || '';
                    if (!rawBirth) return;
                    el.dataset.bdayChecked = '1';

                    const parsed = parseBirthMonthDay(rawBirth);
                    if (parsed && parsed.month === todayMonth && parsed.day === todayDay) {
                        const sName = el.dataset.studentName || el.getAttribute('data-name') || el.innerText.split('\n')[0].trim();
                        birthdayNames.push(sName);

                        // Beri ring warna-warni pada avatar di dalamnya
                        const avatar = el.querySelector('img, .rounded-full');
                        if (avatar) {
                            avatar.classList.add('birthday-avatar-ring');
                        } else {
                            el.classList.add('birthday-avatar-ring');
                        }

                        // Tambahkan badge kue ulang tahun
                        if (!el.querySelector('.bday-cake-badge')) {
                            const badge = document.createElement('span');
                            badge.className = 'bday-cake-badge inline-block ml-1 text-xs';
                            badge.textContent = '🎂';
                            el.appendChild(badge);
                        }

                        // Saat diklik -> semburkan confetti & kartu ucapan ultah ala X/Twitter!
                        el.addEventListener('click', () => {
                            launchTwitterBirthdayConfetti();
                            showBirthdayToastBanner(sName);
                        });
                    }
                });

                // Otomatis semburkan confetti pembuka jika hari ini ada siswa yang berulang tahun
                if (birthdayNames.length > 0) {
                    setTimeout(() => {
                        launchTwitterBirthdayConfetti();
                        showBirthdayToastBanner(birthdayNames.join(' & '));
                    }, 500);
                }
            });
        })();
    </script>
    <div id="student-pp-lightbox" onclick="this.classList.add('hidden'); this.classList.remove('flex');"
         class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black/90 p-4 cursor-zoom-out">
        <div class="relative max-w-md w-full flex flex-col items-center gap-3" onclick="event.stopPropagation()">
            <img id="student-pp-lightbox-img" src="" alt="Foto Profil Siswa"
                 class="hidden max-h-[75vh] w-auto rounded-2xl border-2 border-white/25 shadow-2xl object-contain">
            <div id="student-pp-lightbox-guest"
                 class="hidden w-56 h-56 rounded-full bg-zinc-800 border-2 border-white/25 flex items-center justify-center shadow-2xl">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-32 h-32 text-zinc-300">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div id="student-pp-lightbox-name" class="text-sm font-extrabold text-white"></div>
            <button type="button" onclick="document.getElementById('student-pp-lightbox').classList.add('hidden'); document.getElementById('student-pp-lightbox').classList.remove('flex');"
                    class="px-4 py-1.5 rounded-full bg-white/15 text-white text-xs font-extrabold hover:bg-white/25">
                ✕ Tutup Foto
            </button>
        </div>
    </div>

    <script>
        function openStudentPpInspect(src, nameText) {
            const lb = document.getElementById('student-pp-lightbox');
            const lbImg = document.getElementById('student-pp-lightbox-img');
            const lbGuest = document.getElementById('student-pp-lightbox-guest');
            const lbName = document.getElementById('student-pp-lightbox-name');
            if (!lb) return;

            if (lbName) lbName.textContent = nameText || '';

            if (src && !src.endsWith('/')) {
                lbGuest.classList.add('hidden');
                lbImg.src = src;
                lbImg.classList.remove('hidden');
            } else {
                lbImg.classList.add('hidden');
                lbGuest.classList.remove('hidden');
            }

            lb.classList.remove('hidden');
            lb.classList.add('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Pasang event klik Inspect PP pada avatar/foto di dalam modal Biodata siswa
            document.querySelectorAll('.fixed .rounded-full').forEach(avatarEl => {
                if (avatarEl.closest('#student-pp-lightbox') || avatarEl.tagName === 'BUTTON') return;
                avatarEl.style.cursor = 'zoom-in';
                avatarEl.title = 'Klik PP untuk memperbesar';
                avatarEl.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const modalBox = this.closest('.fixed');
                    const nameEl = modalBox ? modalBox.querySelector('h2, h3, .text-xl, .text-2xl') : null;
                    const studentName = nameEl ? nameEl.textContent.trim() : '';
                    const imgInside = this.tagName === 'IMG' ? this : this.querySelector('img');
                    const imgSrc = imgInside ? imgInside.getAttribute('src') : '';
                    openStudentPpInspect(imgSrc, studentName);
                });
            });
        });
    </script>
    <script>
        (function () {
            const guestSvg = `<svg viewBox="0 0 24 24" fill="currentColor" class="w-3/5 h-3/5 text-zinc-300 opacity-85 pointer-events-none"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>`;

            function cleanGuestAvatars() {
                // 1. Sembunyikan modal lama "Preview Foto" jika ada
                document.querySelectorAll('img[alt="Preview Foto"]').forEach(img => {
                    const modalWrap = img.closest('.fixed');
                    if (modalWrap) modalWrap.remove();
                });

                // 2. Ubah setiap avatar lingkaran yang masih berisi teks nama menjadi ikon Guest SVG
                document.querySelectorAll('.rounded-full').forEach(circle => {
                    if (circle.closest('#student-pp-lightbox') || circle.tagName === 'BUTTON' || circle.tagName === 'IMG') return;
                    if (circle.querySelector('img, svg')) return;
                    const txt = (circle.textContent || '').trim();
                    if (txt.length > 0 && txt.length <= 24 && circle.offsetWidth >= 32) {
                        circle.innerHTML = guestSvg;
                        circle.classList.add('flex', 'items-center', 'justify-center');
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                cleanGuestAvatars();
                const observer = new MutationObserver(cleanGuestAvatars);
                observer.observe(document.body, { childList: true, subtree: true });
            });

            // 3. Klik pada avatar/PP di dalam modal Biodata -> buka Lightbox Inspect PP
            document.addEventListener('click', function (e) {
                const modalBox = e.target.closest('.fixed');
                if (!modalBox || modalBox.id === 'student-pp-lightbox') return;

                const avatarClicked = e.target.closest('.rounded-full');
                if (!avatarClicked || avatarClicked.tagName === 'BUTTON') return;
                if (avatarClicked.offsetWidth < 44) return;

                e.stopPropagation();
                const nameEl = modalBox.querySelector('h2, h3, .text-xl, .text-2xl');
                const studentName = nameEl ? nameEl.textContent.trim() : '';
                const imgInside = avatarClicked.tagName === 'IMG' ? avatarClicked : avatarClicked.querySelector('img');
                const imgSrc = imgInside ? imgInside.getAttribute('src') : '';

                if (typeof openStudentPpInspect === 'function') {
                    openStudentPpInspect(imgSrc, studentName);
                }
            }, true);
        })();
    </script>
<script id="force-guest-avatar-svg">
document.addEventListener('DOMContentLoaded', function () {
    const svgIcon = '<svg viewBox="0 0 24 24" fill="currentColor" style="width:62%;height:62%;opacity:0.85;pointer-events:none;"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>';
    function replaceTextAvatars() {
        document.querySelectorAll('main .rounded-full').forEach(el => {
            if (el.querySelector('img, svg')) return;
            const txt = (el.textContent || '').trim();
            if (txt.length > 0 && txt.length <= 24) {
                el.innerHTML = svgIcon;
                el.style.display = 'flex';
                el.style.alignItems = 'center';
                el.style.justifyContent = 'center';
            }
        });
    }
    replaceTextAvatars();
    setTimeout(replaceTextAvatars, 300);
});
</script>
</x-app-layout>