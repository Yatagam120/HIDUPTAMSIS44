<x-app-layout>
    <div class="space-y-8">
        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-red-500/20 text-red-300 border border-red-500/40 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <!-- Bagian 1: Manajemen Akun & Role Pengguna -->
        <div class="theme-card rounded-2xl shadow-md p-6 border theme-border">
            <div class="mb-5">
                <h1 class="text-xl sm:text-2xl font-extrabold" data-i18n="ap_title">Admin Panel (AP)</h1>
                <p class="text-xs sm:text-sm opacity-75 mt-0.5" data-i18n="ap_sub">Kelola persetujuan akun, role pengguna, dan tinjau kritik dari kelas XI RPL 1.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="theme-primary">
                            <th class="p-3 rounded-tl-xl">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3 rounded-tr-xl text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/20">
                        @foreach($users as $u)
                            <tr>
                                <td class="p-3 font-bold">{{ $u->name }}</td>
                                <td class="p-3 opacity-80">{{ $u->email }}</td>
                                <td class="p-3">
                                    <form action="{{ route('admin.users.role', $u->id) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="rounded-lg border px-2.5 py-1 text-xs font-bold">
                                            @foreach(['admin' => 'Admin', 'guru' => 'Walas / Guru', 'ketua_kelas' => 'Ketua Kelas', 'wakil_ketua' => 'Wakil Ketua', 'murid' => 'Murid'] as $rKey => $rLabel)
                                                <option value="{{ $rKey }}" {{ $u->role === $rKey ? 'selected' : '' }}>
                                                    {{ $rLabel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="p-3 text-right space-x-2">
                                    @if(isset($u->is_approved) && !$u->is_approved)
                                        <form action="{{ route('admin.users.approve', $u->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-bold bg-emerald-600 text-white hover:opacity-90">
                                                Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if((int) $u->id !== (int) Auth::id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 rounded-lg text-xs font-bold text-red-400 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bagian 2: Section Kritik / Critic (Mengikuti Bahasa Aktif) -->
        <div class="theme-card rounded-2xl shadow-md p-6 border-t-4 theme-border">
            @php
                $avgRating = isset($feedbacks) && $feedbacks->count() > 0 ? round($feedbacks->avg('rating'), 2) : 0;
            @endphp

            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div>
                    <h2 class="text-xl font-extrabold" data-i18n="critic_title">Kritik</h2>
                    <p class="text-xs opacity-75 mt-0.5" data-i18n="critic_sub">Ulasan bintang, masukan, dan laporan bug dari pengguna web kelas.</p>
                </div>

                <div class="px-4 py-2 rounded-xl theme-soft border theme-border text-right">
                    <div class="text-[10px] font-bold uppercase opacity-75" data-i18n="avg_rating_label">Rata-rata Rating Web</div>
                    <div class="text-base font-extrabold text-amber-400">
                        ★ {{ number_format($avgRating, 1) }} / 5.0
                        <span class="text-xs opacity-75 font-normal">({{ isset($feedbacks) ? $feedbacks->count() : 0 }})</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($feedbacks ?? [] as $fb)
                    <div class="p-4 rounded-xl border border-gray-200/25 bg-black/15">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-bold text-sm">{{ $fb->user->name ?? 'User' }}</span>
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full theme-soft border theme-border">
                                        {{ $fb->user->role ?? 'murid' }}
                                    </span>
                                    <span class="text-xs font-extrabold text-amber-400 bg-amber-400/15 px-2.5 py-0.5 rounded-full border border-amber-400/40">
                                        ★ {{ number_format($fb->rating, 1) }} / 5.0
                                    </span>
                                </div>
                                <p class="text-[11px] opacity-65 mt-0.5">{{ $fb->created_at->format('d M Y • H:i') }}</p>
                            </div>

                            <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-400 hover:underline">Hapus</button>
                            </form>
                        </div>

                        <p class="mt-3 text-sm leading-relaxed whitespace-pre-line">{{ $fb->komentar }}</p>

                        @if(is_array($fb->media_paths) && count($fb->media_paths) > 0)
                            <div class="mt-3 flex flex-wrap gap-2.5">
                                @foreach($fb->media_paths as $item)
                                    @if(($item['type'] ?? '') === 'video')
                                        <video controls style="width: 190px; height: 115px;" class="rounded-xl border theme-border object-cover">
                                            <source src="{{ asset('storage/' . $item['path']) }}">
                                        </video>
                                    @else
                                        <a href="{{ asset('storage/' . $item['path']) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $item['path']) }}" alt="Lampiran Kritik"
                                                 style="width: 90px; height: 90px; object-fit: cover;"
                                                 class="rounded-xl border theme-border hover:scale-105 transition">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs opacity-70 text-center py-6" data-i18n="critic_empty">Belum ada kritik, saran, atau laporan bug yang masuk.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>