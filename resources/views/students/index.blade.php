<x-app-layout>
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

        // Urutkan anggota kelas berdasarkan nomor absen / abjad nama agar Archie Lionel berada setelah Anisha dan sebelum Azzahra (absen 6)
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

            <!-- Anggota Kelas XI RPL 1 (Urut Absen: Archie setelah Anisha sebelum Azzahra) -->
            <div class="pt-2 space-y-4">
                <div class="text-center">
                    <span class="text-[11px] font-extrabold tracking-widest uppercase opacity-90">
                        ANGGOTA KELAS XI RPL 1
                    </span>
                </div>

                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-y-5 gap-x-2 text-center">
                    @foreach($members as $member)
                        @php $mPayload = $formatStudentPayload($member, 'Siswa', 'siswa'); @endphp
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

                <!-- Admin: Bisa edit Tanggal Lahir, Umur, Gender, Quote & PP/Bingkai (tanpa dropdown ubah role) -->
                <div id="smodal-edit-box" class="hidden pt-3 border-t theme-border space-y-3">
                    <form id="smodal-edit-form" method="POST" action="" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        @method('PATCH')

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
                <!-- Role Murid: Hanya bisa ganti PP murid (tidak bisa ubah nama, umur, gender, quote, maupun role) -->
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
            document.getElementById('smodal-role').textContent = (data.role || 'siswa').toUpperCase();
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
</x-app-layout>