<x-app-layout>
    @php
        $tabs = [
            'catatan' => 'Catatan',
            'tugas'   => 'Tugas',
            'pr'      => 'PR',
            'event'   => 'Event',
        ];
        $typeBadges = [
            'catatan' => 'bg-sky-500/20 text-sky-300 border-sky-500/40',
            'tugas'   => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/40',
            'pr'      => 'bg-purple-500/20 text-purple-300 border-purple-500/40',
            'event'   => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
        ];

        $currentTab = strtolower(trim((string) (session('active_tab') ?? $activeTab ?? request('tab', 'catatan'))));
        if (!array_key_exists($currentTab, $tabs)) {
            $currentTab = 'catatan';
        }

        $notif = (string) ($notifColor ?? request('notif', ''));
        $currentUserId = (int) auth()->id();
        $subjectId = (int) ($subject->id ?? 0);
        $subjectTitle = $subject->name ?? $subject->nama ?? $subject->title ?? 'Mata Pelajaran';
        $teacherName = $subject->teacher ?? $subject->guru ?? null;

        $safeItems = $items ?? null;
        if ($safeItems === null) {
            if (method_exists($subject, 'items')) {
                $safeItems = $subject->items()->latest()->get();
            } elseif (class_exists(\App\Models\SubjectItem::class) && $subjectId > 0) {
                $safeItems = \App\Models\SubjectItem::where('subject_id', $subjectId)->latest()->get();
            } else {
                $safeItems = collect();
            }
        }
        if (!($safeItems instanceof \Illuminate\Support\Collection)) {
            $safeItems = collect($safeItems);
        }

        $userIds = $safeItems->pluck('user_id')->filter()->unique()->values();
        $usersMap = $userIds->isNotEmpty()
            ? \App\Models\User::whereIn('id', $userIds)->pluck('name', 'id')
            : collect();
    @endphp

    <div class="max-w-5xl mx-auto space-y-4 sm:space-y-5 px-1 sm:px-0">
        <div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold hover:opacity-80" style="color: var(--primary);">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

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

        <div class="theme-card rounded-2xl p-4 sm:p-7 border theme-border space-y-2">
            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider theme-soft" style="color: var(--primary);">
                {{ $subjectTitle }}
            </span>
            <h1 class="text-lg sm:text-3xl font-extrabold">{{ $subjectTitle }}</h1>
            @if(!empty($teacherName))
                <p class="text-xs opacity-75">Guru Pengampu: {{ $teacherName }}</p>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center sm:justify-between gap-2.5 sm:gap-3">
            <div class="grid grid-cols-4 sm:flex sm:flex-wrap items-center gap-1.5 sm:gap-2">
                @foreach($tabs as $key => $label)
                    @php
                        $isActive = $currentTab === $key;
                        $hasSourceNotif = in_array($notif, ['yellow', 'red', 'blue'], true) && $isActive;
                        $tabCount = $safeItems->filter(function ($it) use ($key) {
                            $t = strtolower(trim((string) ($it->category ?? $it->kategori ?? $it->type ?? $it->jenis ?? $it->tipe ?? 'catatan')));
                            return $t === $key;
                        })->count();
                    @endphp
                    <button type="button"
                            data-tab="{{ $key }}"
                            onclick="switchSubjectTab('{{ $key }}')"
                            class="relative subject-tab-btn px-2 sm:px-4 py-2 rounded-xl text-[11px] sm:text-sm font-extrabold border theme-border inline-flex items-center justify-center gap-1 {{ $isActive ? 'theme-primary' : 'theme-card' }}">
                        @if($hasSourceNotif)
                            <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>
                        @endif
                        <span>{{ $label }}</span>
                        @if($tabCount > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/25">{{ $tabCount }}</span>
                        @endif
                    </button>
                @endforeach
            </div>

            <button type="button"
                    onclick="openNewItemModal()"
                    id="btn-add-subject-item"
                    class="w-full sm:w-auto px-4 py-2.5 sm:py-2 rounded-xl text-xs sm:text-sm font-extrabold theme-primary shadow text-center">
                + Tambah {{ $tabs[$currentTab] ?? 'Catatan' }} Baru
            </button>
        </div>

        @foreach($tabs as $key => $label)
            @php
                $tabItems = $safeItems->filter(function ($it) use ($key) {
                    $rawType = strtolower(trim((string) ($it->category ?? $it->kategori ?? $it->type ?? $it->jenis ?? $it->tipe ?? 'catatan')));
                    return $rawType === $key;
                });
            @endphp
            <div id="panel-{{ $key }}" class="subject-tab-panel space-y-3 sm:space-y-4 {{ $currentTab === $key ? '' : 'hidden' }}">
                @forelse($tabItems as $item)
                    @php
                        $itemType = strtolower(trim((string) ($item->category ?? $item->kategori ?? $item->type ?? $item->jenis ?? $item->tipe ?? $key)));
                        if (!array_key_exists($itemType, $tabs)) {
                            $itemType = $key;
                        }
                        $itemTypeLabel = strtoupper($tabs[$itemType] ?? $label);
                        $itemTypeStyle = $typeBadges[$itemType] ?? 'theme-soft theme-border';

                        $itemOwnerId = (int) ($item->user_id ?? 0);
                        $isOwner = $currentUserId > 0 && $itemOwnerId === $currentUserId;
                        $authorName = $usersMap[$itemOwnerId] ?? 'Siswa';

                        $completedBy = is_array($item->completed_by ?? null)
                            ? $item->completed_by
                            : (json_decode($item->completed_by ?? '[]', true) ?: []);
                        $isDoneByMe = in_array($currentUserId, array_map('intval', $completedBy), true);

                        $dueText = null;
                        $dueFormattedInput = '';
                        $dueBadgeClass = 'bg-slate-500/20 text-slate-300 border-slate-500/40';
                        $dueLabelPrefix = 'TENGGAT';

                        $rawDue = $item->due_date ?? $item->deadline ?? $item->tanggal ?? null;
                        if (!empty($rawDue)) {
                            try {
                                $due = \Carbon\Carbon::parse($rawDue)->startOfDay();
                                $diffDays = now()->startOfDay()->diffInDays($due, false);
                                $dueText = $due->translatedFormat('d M Y');
                                $dueFormattedInput = $due->format('Y-m-d');
                                if ($diffDays < 0) {
                                    $dueBadgeClass = 'bg-red-500/25 text-red-200 border-red-500/50';
                                    $dueLabelPrefix = 'LEWAT TENGGAT';
                                } elseif ($diffDays === 0) {
                                    $dueBadgeClass = 'bg-red-500/25 text-red-200 border-red-500/50';
                                    $dueLabelPrefix = 'HARI INI';
                                } elseif ($diffDays <= 2) {
                                    $dueBadgeClass = 'bg-amber-500/25 text-amber-200 border-amber-500/50';
                                    $dueLabelPrefix = 'TENGGAT DEKAT';
                                } else {
                                    $dueBadgeClass = 'bg-emerald-500/25 text-emerald-200 border-emerald-500/50';
                                    $dueLabelPrefix = 'TENGGAT';
                                }
                            } catch (\Throwable $e) {
                                $dueText = (string) $rawDue;
                            }
                        }
                    @endphp

                    <div class="theme-card rounded-2xl p-4 sm:p-5 border theme-border space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                            <div class="space-y-1.5">
                                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase border {{ $itemTypeStyle }}">
                                        {{ $itemTypeLabel }}
                                    </span>
                                    <h2 class="text-sm sm:text-base font-extrabold uppercase">{{ $item->title ?? $item->judul ?? 'Tanpa Judul' }}</h2>
                                    @if($dueText && !$isDoneByMe)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $dueBadgeClass }}">
                                            ⏰ {{ $dueLabelPrefix }}: {{ $dueText }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] sm:text-xs opacity-75 flex flex-wrap items-center gap-x-2 gap-y-1">
                                    <span>Oleh <strong>{{ $authorName }}</strong></span>
                                    @if($dueText)
                                        <span>• Tenggat: <strong>{{ $dueText }}</strong></span>
                                    @endif
                                </div>
                            </div>

                            @if($isOwner)
                                <div class="flex items-center gap-3 text-xs font-extrabold pt-1 sm:pt-0">
                                    <button type="button"
                                            data-item-id="{{ $item->id }}"
                                            data-item-title="{{ $item->title ?? $item->judul ?? '' }}"
                                            data-item-description="{{ $item->description ?? $item->deskripsi ?? '' }}"
                                            data-item-due="{{ $dueFormattedInput }}"
                                            onclick="openEditItemModalFromBtn(this)"
                                            class="text-indigo-400 hover:underline">
                                        Edit
                                    </button>
                                    @if(\Illuminate\Support\Facades\Route::has('subject.items.destroy'))
                                        <form method="POST"
                                              action="{{ route('subject.items.destroy', [$subject->id, $item->id]) }}"
                                              onsubmit="return confirm('Hapus postingan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @php $descText = $item->description ?? $item->deskripsi ?? null; @endphp
                        @if(!empty($descText))
                            <p class="text-xs sm:text-sm opacity-90 whitespace-pre-line">{{ $descText }}</p>
                        @endif

                        @if(in_array($key, ['tugas', 'pr'], true) && \Illuminate\Support\Facades\Route::has('items.toggle-complete'))
                            <div class="pt-3 border-t theme-border flex items-center justify-between">
                                <form method="POST" action="{{ route('items.toggle-complete', $item->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-extrabold border {{ $isDoneByMe ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40' : 'theme-soft theme-border' }}">
                                        {{ $isDoneByMe ? '✅ Selesai' : '☑️ Tandai Selesai' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="theme-card rounded-2xl p-6 sm:p-8 border theme-border text-center text-xs sm:text-sm opacity-70">
                        Belum ada {{ strtolower($label) }} untuk mata pelajaran ini.
                    </div>
                @endforelse
            </div>
        @endforeach
    </div>

    <!-- Modal Tambah Post Baru -->
    <div id="new-item-modal" class="fixed inset-0 z-[9995] hidden items-center justify-center bg-black/65 p-4">
        <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-5 space-y-4">
            <div class="flex items-center justify-between">
                <h3 id="new-item-modal-title" class="text-base font-extrabold">Tambah Post Baru</h3>
                <button type="button" onclick="closeNewItemModal()" class="px-2.5 py-1 rounded-lg text-xs font-bold border theme-border">✕</button>
            </div>

            @if(\Illuminate\Support\Facades\Route::has('subject.items.store'))
                <form method="POST" action="{{ route('subject.items.store', $subject->id) }}" class="space-y-3">
                    @csrf
                    <input type="hidden" id="new-item-type" name="type" value="{{ $currentTab }}">

                    <div>
                        <label class="block text-xs font-bold mb-1">Judul</label>
                        <input type="text" name="title" required placeholder="Judul..." class="w-full rounded-xl border px-3 py-2 text-xs">
                    </div>

                    <div id="new-item-due-wrap">
                        <label class="block text-xs font-bold mb-1">Tanggal Tenggat</label>
                        <input type="date" name="due_date" class="w-full rounded-xl border px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold mb-1">Deskripsi / Keterangan</label>
                        <textarea name="description" rows="3" placeholder="Tulis detail..." class="w-full rounded-xl border p-2.5 text-xs"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeNewItemModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold border theme-border">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">Simpan</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Modal Edit Post -->
    <div id="edit-item-modal" class="fixed inset-0 z-[9995] hidden items-center justify-center bg-black/65 p-4">
        <div class="theme-card rounded-2xl border theme-border shadow-2xl max-w-md w-full p-5 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-extrabold">Edit Postingan</h3>
                <button type="button" onclick="closeEditItemModal()" class="px-2.5 py-1 rounded-lg text-xs font-bold border theme-border">✕</button>
            </div>

            <form id="edit-item-form" method="POST" action="" class="space-y-3">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-bold mb-1">Judul</label>
                    <input type="text" id="edit-item-title" name="title" required class="w-full rounded-xl border px-3 py-2 text-xs">
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Tanggal Tenggat</label>
                    <input type="date" id="edit-item-due" name="due_date" class="w-full rounded-xl border px-3 py-2 text-xs">
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Deskripsi / Keterangan</label>
                    <textarea id="edit-item-desc" name="description" rows="3" class="w-full rounded-xl border p-2.5 text-xs"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditItemModal()" class="px-3.5 py-2 rounded-xl text-xs font-bold border theme-border">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold theme-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentSubjectTab = @json($currentTab);
        const tabLabels = {
            catatan: 'Catatan',
            tugas: 'Tugas',
            pr: 'PR',
            event: 'Event'
        };

        function switchSubjectTab(tab) {
            currentSubjectTab = tab;
            document.querySelectorAll('.subject-tab-panel').forEach(p => p.classList.add('hidden'));
            const activePanel = document.getElementById('panel-' + tab);
            if (activePanel) activePanel.classList.remove('hidden');

            document.querySelectorAll('.subject-tab-btn').forEach(btn => {
                if (btn.getAttribute('data-tab') === tab) {
                    btn.classList.add('theme-primary');
                    btn.classList.remove('theme-card');
                } else {
                    btn.classList.remove('theme-primary');
                    btn.classList.add('theme-card');
                }
            });

            const addBtn = document.getElementById('btn-add-subject-item');
            if (addBtn) {
                addBtn.textContent = `+ Tambah ${tabLabels[tab] || 'Catatan'} Baru`;
            }
        }

        function openNewItemModal() {
            document.getElementById('new-item-type').value = currentSubjectTab;
            document.getElementById('new-item-modal-title').textContent = `Tambah ${tabLabels[currentSubjectTab] || 'Catatan'} Baru`;
            const dueWrap = document.getElementById('new-item-due-wrap');
            if (dueWrap) {
                dueWrap.style.display = currentSubjectTab === 'catatan' ? 'none' : 'block';
            }
            const m = document.getElementById('new-item-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeNewItemModal() {
            const m = document.getElementById('new-item-modal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }

        function openEditItemModalFromBtn(btn) {
            openEditItemModal({
                id: btn.dataset.itemId || '',
                title: btn.dataset.itemTitle || '',
                description: btn.dataset.itemDescription || '',
                due_date: btn.dataset.itemDue || ''
            });
        }

        function openEditItemModal(item) {
            const form = document.getElementById('edit-item-form');
            form.action = `/mapel/{{ $subject->id }}/items/${item.id}`;
            document.getElementById('edit-item-title').value = item.title || '';
            document.getElementById('edit-item-due').value = item.due_date || '';
            document.getElementById('edit-item-desc').value = item.description || '';

            const m = document.getElementById('edit-item-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }

        function closeEditItemModal() {
            const m = document.getElementById('edit-item-modal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
    </script>
</x-app-layout>