<x-app-layout>
    @php
        $isCreator = stripos($student->nama, 'archie lionel') !== false;
        $isAuthority = in_array(Auth::user()->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);
        $roleLabels = [
            'walas'       => 'Wali Kelas XI RPL 1',
            'ketua_kelas' => 'Ketua Kelas',
            'wakil_ketua' => 'Wakil Ketua Kelas',
            'siswa'       => 'Anggota Kelas XI RPL 1',
        ];
    @endphp

    <div class="mb-4 max-w-lg mx-auto">
        <a href="{{ route('students.index') }}" class="text-sm font-semibold hover:underline" style="color: var(--primary);" data-i18n="back_siswa">
            ← Kembali ke Daftar Siswa
        </a>
    </div>

    <div class="theme-card rounded-2xl shadow-lg p-6 sm:p-8 max-w-lg mx-auto text-center border-t-4 {{ $isCreator ? 'border-yellow-400' : 'theme-border' }}">
        <!-- Foto Profil Bulat -->
        <div class="flex justify-center mb-4">
            @if($isCreator)
                <div style="width: 136px; height: 136px; padding: 4px; border-radius: 50%; background: linear-gradient(135deg, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c); box-shadow: 0 0 24px rgba(250, 204, 21, 0.55);">
                    <div style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; background: linear-gradient(145deg, #422006, #713f12); display: flex; align-items: center; justify-content: center;">
                        @if($student->foto)
                            <img src="{{ asset('storage/' . $student->foto) }}" alt="{{ $student->nama }}" class="w-full h-full object-cover">
                        @else
                            <svg style="width: 52%; height: 52%; color: #fde047;" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        @endif
                    </div>
                </div>
            @else
                <div style="width: 128px; height: 128px;" class="rounded-full overflow-hidden border-4 theme-border shadow-md flex items-center justify-center theme-soft">
                    @if($student->foto)
                        <img src="{{ asset('storage/' . $student->foto) }}" alt="{{ $student->nama }}" class="w-full h-full object-cover">
                    @else
                        <svg style="width: 50%; height: 50%; color: var(--primary);" class="opacity-70" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                    @endif
                </div>
            @endif
        </div>

        <!-- Badge Jabatan / Mahkota Admin Pemegang Web -->
        <div class="flex flex-wrap justify-center gap-2 mb-2">
            @if($isCreator)
                <span style="background: linear-gradient(135deg, #ca8a04, #facc15); color: #1c1917;"
                      class="text-xs font-black uppercase tracking-wider px-3.5 py-1 rounded-full shadow-md">
                    👑 Admin & Pemegang Web
                </span>
            @endif
            <span class="text-xs font-bold uppercase tracking-wider px-3.5 py-1 rounded-full theme-soft border theme-border" style="color: var(--primary);">
                {{ $roleLabels[$student->jabatan ?? 'siswa'] ?? 'Anggota Kelas XI RPL 1' }}
            </span>
        </div>

        <h1 class="text-xl sm:text-2xl font-extrabold mt-2">{{ $student->nama }}</h1>

        @if($isAuthority)
            <div class="mt-6 pt-5 border-t border-gray-200/30 flex justify-center gap-3">
                <a href="{{ route('students.edit', $student->id) }}"
                   class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold theme-primary shadow-sm hover:opacity-90 transition">
                    Edit Data & Foto
                </a>

                <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-red-600 text-white shadow-sm hover:bg-red-700 transition">
                        Hapus
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>