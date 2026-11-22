<x-app-layout>
    <style>
        @keyframes goldRingGlow {
            0%, 100% { box-shadow: 0 0 10px rgba(251, 191, 36, 0.85), 0 0 20px rgba(245, 158, 11, 0.45); }
            50% { box-shadow: 0 0 16px rgba(253, 224, 71, 1), 0 0 28px rgba(251, 191, 36, 0.75); }
        }
        @keyframes pptsBlueGlow {
            0%, 100% { box-shadow: 0 0 8px rgba(59, 130, 246, 0.8), 0 0 16px rgba(37, 99, 235, 0.45); }
            50% { box-shadow: 0 0 14px rgba(96, 165, 250, 1), 0 0 24px rgba(59, 130, 246, 0.7); }
        }

        .org-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: transform 0.2s ease;
        }
        .org-item:hover .org-circle {
            transform: scale(1.08);
        }

        .avatar-default-bg {
            background: #2b4c65;
            border: 1.5px solid rgba(96, 165, 250, 0.3);
            color: #5eead4;
        }

        /* Bingkai Lingkaran Emas Archie L */
        .ring-archie-gold {
            border: 2.5px solid #fbbf24 !important;
            animation: goldRingGlow 2.4s infinite ease-in-out;
        }

        /* Bingkai Lingkaran Biru (PPTS) */
        .ring-ppts-blue {
            border: 3px solid #3b82f6 !important;
            animation: pptsBlueGlow 2.4s infinite ease-in-out;
        }

        /* Bingkai Lingkaran Biru Tua (Ex-PPTS) */
        .ring-exppts-darkblue {
            border: 3px solid #1e3a8a !important;
            box-shadow: 0 0 8px rgba(30, 58, 138, 0.85), inset 0 0 4px rgba(29, 78, 216, 0.5);
        }

        /* Flex Center: 8 kolom per baris & baris terakhir otomatis di tengah */
        .org-members-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px 14px;
            max-width: 780px;
            margin: 0 auto;
        }
        .org-member-slot {
            width: 82px;
            flex: 0 0 82px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .org-member-name {
            width: 100%;
            font-size: 9.5px;
            font-weight: 700;
            margin-top: 5px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }
    </style>

    @php
        $isAuthority = in_array(Auth::user()->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);

        $formatShortName = function ($fullName) {
            $parts = preg_split('/\s+/', trim($fullName));
            if (count($parts) <= 1) {
                return $parts[0];
            }
            $first = $parts[0];
            if (mb_strlen($first) > 9) {
                $first = mb_substr($first, 0, 7) . '...';
            }
            $initials = '';
            for ($i = 1; $i < count($parts); $i++) {
                $initials .= mb_strtoupper(mb_substr($parts[$i], 0, 1));
            }
            return $first . ' ' . $initials;
        };
    @endphp

    @if(session('success'))
        <div class="mb-3 p-2.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs font-semibold max-w-3xl mx-auto">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol + Tambah Siswa di Pojok Kanan Atas (Tanpa Legenda PPTS/Ex-PPTS) -->
    @if($isAuthority)
        <div class="max-w-4xl mx-auto flex justify-end px-2 mb-1">
            <a href="{{ route('students.create') }}"
               class="px-3.5 py-1 rounded-full text-[11px] font-bold theme-primary shadow-sm hover:opacity-90 transition">
                + Tambah Siswa
            </a>
        </div>
    @endif

    <!-- Tech Tree Struktur Organisasi Kelas -->
    <div class="px-2 text-center select-none">

        <!-- 1. WALI KELAS -->
        @if($walas)
            <div class="flex flex-col items-center">
                <a href="{{ route('students.show', $walas->id) }}" class="org-item inline-block">
                    @if($walas->foto)
                        <img src="{{ asset('storage/' . $walas->foto) }}" alt="{{ $walas->nama }}"
                             class="org-circle border-2 theme-border shadow-md">
                    @else
                        <div class="org-circle avatar-default-bg shadow-md">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="text-[10px] font-bold mt-1">{{ $walas->nama }}</div>
                </a>

                <!-- Garis Tech Tree T-Branch -->
                <div style="width: 1.5px; height: 14px; background: rgba(148, 163, 184, 0.45); margin-top: 4px;"></div>
                <div style="width: 220px; height: 1.5px; background: rgba(148, 163, 184, 0.45);"></div>
            </div>
        @endif

        <!-- 2. KETUA KELAS & WAKIL KETUA KELAS -->
        @if($ketua || $wakil)
            <div style="display: flex; justify-content: center; align-items: flex-start; gap: 56px; margin: 10px auto 16px auto;">
                @if($ketua)
                    <a href="{{ route('students.show', $ketua->id) }}" class="org-item flex flex-col items-center" style="min-width: 135px;">
                        <span style="padding: 4px 16px; border-radius: 9999px; font-size: 9.5px; font-weight: 800; letter-spacing: 0.05em;"
                              class="uppercase border theme-border theme-soft mb-2 whitespace-nowrap">
                            Ketua Kelas
                        </span>
                        @if($ketua->foto)
                            <img src="{{ asset('storage/' . $ketua->foto) }}" alt="{{ $ketua->nama }}"
                                 class="org-circle border-2 theme-border shadow-md">
                        @else
                            <div class="org-circle avatar-default-bg shadow-md">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="text-[10.5px] font-bold mt-1">{{ $ketua->nama }}</div>
                    </a>
                @endif

                @if($wakil)
                    <a href="{{ route('students.show', $wakil->id) }}" class="org-item flex flex-col items-center" style="min-width: 135px;">
                        <span style="padding: 4px 16px; border-radius: 9999px; font-size: 9.5px; font-weight: 800; letter-spacing: 0.05em;"
                              class="uppercase border theme-border theme-soft mb-2 whitespace-nowrap">
                            Wakil Ketua Kelas
                        </span>
                        @if($wakil->foto)
                            <img src="{{ asset('storage/' . $wakil->foto) }}" alt="{{ $wakil->nama }}"
                                 class="org-circle border-2 theme-border shadow-md">
                        @else
                            <div class="org-circle avatar-default-bg shadow-md">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="text-[10.5px] font-bold mt-1">{{ $wakil->nama }}</div>
                    </a>
                @endif
            </div>
        @endif

        <!-- 3. ANGGOTA KELAS XI RPL 1 -->
        <h2 class="text-[11px] font-extrabold uppercase tracking-wider mb-4">
            Anggota Kelas XI RPL 1
        </h2>

        <div class="org-members-flex">
            @foreach($murid as $s)
                @php
                    $isArchie = stripos($s->nama, 'Archie Lionel') !== false;
                    $isPpts   = $s->jabatan === 'ppts';
                    $isExPpts = $s->jabatan === 'ex_ppts';

                    $ringClass = '';
                    if ($isArchie) {
                        $ringClass = 'ring-archie-gold';
                    } elseif ($isPpts) {
                        $ringClass = 'ring-ppts-blue';
                    } elseif ($isExPpts) {
                        $ringClass = 'ring-exppts-darkblue';
                    }

                    $displayName = $isArchie ? 'Archie L' : $formatShortName($s->nama);
                @endphp

                <a href="{{ route('students.show', $s->id) }}"
                   class="org-item org-member-slot">
                    <div class="relative inline-block">
                        @if($s->foto)
                            <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama }}"
                                 class="org-circle border theme-border {{ $ringClass }}">
                        @else
                            <div class="org-circle avatar-default-bg {{ $ringClass }}">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                        @endif

                        @if($isArchie)
                            <span style="position: absolute; top: -9px; right: -4px; font-size: 13px;">👑</span>
                        @endif
                    </div>

                    <span class="org-member-name {{ $isArchie ? 'text-amber-300' : '' }}">
                        {{ $displayName }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>