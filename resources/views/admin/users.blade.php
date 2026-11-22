<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-xs sm:text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-300 border border-red-500/40 text-xs sm:text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border">
            <h1 class="text-lg sm:text-2xl font-extrabold" data-i18n="ap_title">Admin Panel (AP)</h1>
            <p class="text-xs sm:text-sm opacity-75 mt-0.5" data-i18n="ap_sub">Kelola persetujuan akun, role pengguna, izin bingkai siswa, dan tinjau kritik dari kelas XI RPL 1.</p>
        </div>

        <!-- Persetujuan Ganti Bingkai Siswa -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border space-y-4">
            <div>
                <h2 class="text-base sm:text-lg font-extrabold">🖼️ Persetujuan Ganti Bingkai Siswa</h2>
                <p class="text-xs opacity-75">Setujui permintaan agar gambar bingkai murid diproses dan diterapkan.</p>
            </div>

            @forelse(($frameRequests ?? collect()) as $req)
                <div class="flex flex-wrap items-center justify-between gap-3 p-3.5 rounded-xl border theme-border theme-soft">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $req->frame_path) }}" alt="Preview Bingkai"
                             class="w-16 h-16 rounded-xl object-cover border theme-border">
                        <div class="text-xs">
                            <div class="font-extrabold text-sm">{{ $req->user->name ?? $req->student_name }}</div>
                            <div class="opacity-75">Target: {{ $req->student_name ?? 'Siswa Kelas' }} • {{ $req->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('admin.frame.approve', $req->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-600 hover:bg-emerald-500 text-white shadow">
                                ✓ Setujui & Proses
                            </button>
                        </form>
                        <form action="{{ route('admin.frame.reject', $req->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-red-600 hover:bg-red-500 text-white shadow">
                                ✕ Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs opacity-70">Belum ada permintaan ganti gambar bingkai yang menunggu persetujuan.</p>
            @endforelse
        </div>

        <!-- Manajemen Akun Pengguna -->
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border space-y-4">
            <h2 class="text-base sm:text-lg font-extrabold">👥 Manajemen Akun Pengguna</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b theme-border opacity-80">
                            <th class="py-2.5 px-3">Nama</th>
                            <th class="py-2.5 px-3">Email</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3">Role</th>
                            <th class="py-2.5 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y theme-border">
                        @foreach($users as $u)
                            <tr>
                                <td class="py-2.5 px-3 font-bold">{{ $u->name }}</td>
                                <td class="py-2.5 px-3 opacity-80">{{ $u->email }}</td>
                                <td class="py-2.5 px-3">
                                    @if($u->is_approved)
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-amber-500/20 text-amber-300 border border-amber-500/40">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3">
                                    <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="rounded-lg border px-2 py-1 text-xs font-bold">
                                            @foreach(['admin' => 'Admin', 'guru' => 'Guru', 'ketua_kelas' => 'Ketua Kelas', 'wakil_ketua' => 'Wakil Ketua', 'murid' => 'Murid'] as $val => $label)
                                                <option value="{{ $val }}" {{ $u->role === $val ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="py-2.5 px-3 text-right">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        @if(!$u->is_approved)
                                            <form action="{{ route('admin.users.approve', $u->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1 rounded-lg text-xs font-extrabold bg-emerald-600 hover:bg-emerald-500 text-white">
                                                    Setujui
                                                </button>
                                            </form>
                                        @endif

                                        @if((int) $u->id !== (int) auth()->id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $u->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 rounded-lg text-xs font-extrabold bg-red-600 hover:bg-red-500 text-white">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kritik & Laporan Bug -->
        @php
            $avgRating = ($feedbacks && $feedbacks->count() > 0) ? number_format((float) $feedbacks->avg('rating'), 1) : '0.0';
        @endphp
        <div class="theme-card rounded-2xl shadow-lg p-4 sm:p-6 border theme-border space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold" data-i18n="critic_title">Kritik</h2>
                    <p class="text-xs opacity-75" data-i18n="critic_sub">Ulasan bintang, masukan, dan laporan bug dari pengguna web kelas.</p>
                </div>
                <div class="px-3.5 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                    <span data-i18n="avg_rating_label">Rata-rata Rating Web</span>: ⭐ {{ $avgRating }} / 5.0
                </div>
            </div>

            <div class="space-y-3">
                @forelse($feedbacks as $fb)
                    <div class="p-4 rounded-xl border theme-border theme-soft space-y-2.5">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="text-xs sm:text-sm font-extrabold">
                                {{ $fb->user->name ?? 'Pengguna Kelas' }}
                                <span class="ml-2 text-amber-400">★ {{ number_format((float) $fb->rating, 1) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] opacity-70">{{ $fb->created_at?->diffForHumans() }}</span>
                                <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Hapus kritik ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-600/80 hover:bg-red-600 text-white">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="text-xs sm:text-sm whitespace-pre-line">{{ $fb->komentar }}</p>

                        @if(is_array($fb->media_paths) && count($fb->media_paths) > 0)
                            <div class="flex flex-wrap gap-2.5 pt-1">
                                @foreach($fb->media_paths as $media)
                                    @php
                                        $mPath = $media['path'] ?? '';
                                        $mType = $media['type'] ?? 'image';
                                        $mUrl  = $mPath ? asset('storage/' . $mPath) : '';
                                    @endphp
                                    @if($mUrl)
                                        @if($mType === 'video')
                                            <video src="{{ $mUrl }}" controls class="w-44 h-28 rounded-xl object-cover border theme-border bg-black"></video>
                                        @else
                                            <a href="{{ $mUrl }}" target="_blank" class="block">
                                                <img src="{{ $mUrl }}" alt="Lampiran Kritik" class="w-28 h-28 rounded-xl object-cover border theme-border">
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs opacity-75" data-i18n="critic_empty">Belum ada kritik, saran, atau laporan bug yang masuk.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>