<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-sm font-semibold hover:underline" style="color: var(--primary);">
            ← Kembali ke Jadwal Utama
        </a>
    </div>

    <!-- Header Mata Pelajaran -->
    <div class="theme-card rounded-2xl shadow-md p-6 mb-6 border-l-4 theme-border">
        <span class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full theme-soft border theme-border" style="color: var(--primary);">
            {{ $subject->kode_mapel }}
        </span>
        <h1 class="text-2xl sm:text-3xl font-bold mt-2">{{ $subject->nama_mapel }}</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3.5 rounded-xl bg-emerald-100 text-emerald-900 border border-emerald-300 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3.5 rounded-xl bg-red-500/20 text-red-200 border border-red-500 text-xs sm:text-sm font-semibold">
            {{ $errors->first() }}
        </div>
    @endif

    @php
        $tabs = [
            'catatan' => 'Catatan',
            'tugas'   => 'Tugas',
            'pr'      => 'PR',
            'event'   => 'Event',
        ];
        $isAuthority = in_array(Auth::user()->role, ['admin', 'guru', 'ketua_kelas', 'wakil_ketua']);
    @endphp

    <!-- Baris Tab Navigasi + Tombol "+ Tambah Baru" -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div class="flex flex-wrap gap-2">
            @foreach($tabs as $key => $label)
                <a href="{{ route('subject.show', ['subject' => $subject->id, 'tab' => $key]) }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm {{ $tab === $key ? 'theme-primary' : 'theme-card hover:opacity-80' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <button type="button" id="toggle-create-btn" onclick="toggleCreateForm()"
                class="px-5 py-2.5 rounded-xl text-sm font-bold theme-primary shadow-md hover:opacity-90 transition flex items-center gap-1.5">
            <span>+</span>
            <span>Tambah {{ $tabs[$tab] }} Baru</span>
        </button>
    </div>

    <!-- Form Tambah Konten (Tersembunyi di Awal, Muncul Saat Tombol Diklik) -->
    <div id="create-post-panel" class="{{ $errors->any() ? '' : 'hidden' }} mb-6">
        <div class="theme-card rounded-2xl shadow-lg p-6 max-w-2xl mx-auto border-t-4 theme-border">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">Tambah {{ $tabs[$tab] }} Baru</h2>
                <button type="button" onclick="toggleCreateForm()"
                        class="text-xs font-bold px-3 py-1 rounded-lg theme-soft border theme-border hover:opacity-80">
                    ✕ Tutup
                </button>
            </div>

            <form action="{{ route('subject.posts.store', $subject->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="kategori" value="{{ $tab }}">

                <div>
                    <label class="block text-xs font-bold mb-1">Judul {{ $tabs[$tab] }}</label>
                    <input type="text" name="judul" required placeholder="Contoh: Bab 2 Trigonometri"
                           class="w-full rounded-xl border p-2.5 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" rows="3" placeholder="Tulis detail materi atau instruksi..."
                              class="w-full rounded-xl border p-2.5 text-sm"></textarea>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold">Lampiran Foto / Video</label>
                        <button type="button" id="clear-files-btn" onclick="clearSelectedFiles()" class="hidden text-[11px] font-bold text-red-500 hover:underline">
                            Hapus Semua
                        </button>
                    </div>
                    <input type="file" id="media-input" name="media[]" multiple accept="image/*,video/*"
                           onchange="renderHorizontalPreview(event)"
                           class="w-full rounded-xl border p-2 text-xs">
                    <div id="horizontal-preview" class="hidden mt-3 flex flex-wrap gap-2.5"></div>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Tanggal / Deadline (Opsional)</label>
                    <input type="date" name="tanggal_deadline" min="2020-01-01" max="2099-12-31"
                           oninput="if(this.value.split('-')[0].length > 4) this.value = this.value.slice(0, 10);"
                           class="w-full rounded-xl border p-2.5 text-sm">
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                    Simpan {{ $tabs[$tab] }}
                </button>
            </form>
        </div>
    </div>

    <!-- Daftar Konten (Lebar Penuh / Full-Width) -->
    <div class="space-y-4">
        @forelse($posts as $post)
            @php
                $canModifyThisPost = $isAuthority || ((int) $post->user_id === (int) Auth::id());

                $statusBadge = null;
                if ($post->tanggal_deadline) {
                    $today = \Carbon\Carbon::today();
                    $deadline = \Carbon\Carbon::parse($post->tanggal_deadline)->startOfDay();
                    $diffDays = $today->diffInDays($deadline, false);

                    if ($diffDays <= 0) {
                        $statusBadge = [
                            'label' => $today->isSameDay($deadline) ? '🚨 HARI INI DEADLINE' : '🚨 LEWAT DEADLINE',
                            'style' => 'background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444;',
                        ];
                    } elseif ($diffDays <= 2) {
                        $statusBadge = [
                            'label' => '⚠️ WAKTU MEPET (' . $diffDays . ' HARI LAGI)',
                            'style' => 'background: rgba(245, 158, 11, 0.2); color: #f59e0b; border: 1px solid #f59e0b;',
                        ];
                    }
                }
            @endphp

            <div class="theme-card rounded-2xl shadow-md p-5 sm:p-6 border border-gray-200/30">
                <div class="flex flex-wrap justify-between items-start gap-2">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-lg sm:text-xl font-bold">{{ $post->judul }}</h3>
                            @if($statusBadge)
                                <span style="{{ $statusBadge['style'] }}" class="text-[10px] sm:text-xs font-extrabold px-2.5 py-0.5 rounded-full tracking-wide">
                                    {{ $statusBadge['label'] }}
                                </span>
                            @endif
                        </div>

                        <p class="text-xs opacity-75 mt-1">
                            Oleh <strong>{{ $post->user->name }}</strong> ({{ str_replace('_', ' ', $post->user->role) }})
                            @if($post->tanggal_deadline)
                                • Tenggat: <span class="font-bold">{{ \Carbon\Carbon::parse($post->tanggal_deadline)->format('d M Y') }}</span>
                            @endif
                        </p>
                    </div>

                    @if($canModifyThisPost)
                        <div class="flex items-center gap-3">
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-xs font-bold hover:underline" style="color: var(--primary);">
                                Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>

                @if($post->deskripsi)
                    <p class="mt-3 text-sm leading-relaxed whitespace-pre-line opacity-90">{{ $post->deskripsi }}</p>
                @endif

                @if($post->attachments && $post->attachments->count() > 0)
                    <div class="mt-4 flex flex-wrap gap-2.5">
                        @foreach($post->attachments as $file)
                            @if($file->file_type === 'video')
                                <video controls style="width: 180px; height: 110px;" class="rounded-xl border theme-border object-cover">
                                    <source src="{{ asset('storage/' . $file->file_path) }}">
                                </video>
                            @else
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $file->file_path) }}" alt="Lampiran"
                                         style="width: 88px; height: 88px; object-fit: cover;"
                                         class="rounded-xl border theme-border hover:scale-105 transition">
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Reaksi Emoji & Checklist Selesai ✅ -->
                <div class="mt-5 pt-3 border-t border-gray-200/30 flex flex-wrap items-center gap-2">
                    @php $emojis = ['✅', '👍', '❤️', '🔥', '👏', '😭']; @endphp
                    @foreach($emojis as $emoji)
                        @php
                            $count = $post->reactions->where('emoji', $emoji)->count();
                            $userReacted = $post->reactions->where('emoji', $emoji)->where('user_id', Auth::id())->isNotEmpty();
                        @endphp
                        <form action="{{ route('posts.react', $post->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="emoji" value="{{ $emoji }}">
                            <button type="submit" title="{{ $emoji === '✅' ? 'Tandai Sudah Dikerjakan' : '' }}"
                                    class="px-2.5 py-1 rounded-full text-xs font-bold border transition flex items-center gap-1 {{ $userReacted ? 'theme-primary border-transparent shadow-sm' : 'theme-soft border-gray-300/40 hover:opacity-80' }}">
                                <span>{{ $emoji }}</span>
                                @if($emoji === '✅')
                                    <span class="text-[10px]">Selesai</span>
                                @endif
                                @if($count > 0)
                                    <span>({{ $count }})</span>
                                @endif
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="theme-card rounded-2xl shadow-md p-10 text-center opacity-75">
                Belum ada data {{ strtolower($tabs[$tab]) }} untuk mata pelajaran ini.
            </div>
        @endforelse
    </div>

    <script>
        function toggleCreateForm() {
            const panel = document.getElementById('create-post-panel');
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        let selectedFilesList = new DataTransfer();

        function renderHorizontalPreview(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                selectedFilesList.items.add(files[i]);
            }
            document.getElementById('media-input').files = selectedFilesList.files;
            updatePreviewUI();
        }

        function removeSingleFile(index) {
            const newTransfer = new DataTransfer();
            for (let i = 0; i < selectedFilesList.files.length; i++) {
                if (i !== index) newTransfer.items.add(selectedFilesList.files[i]);
            }
            selectedFilesList = newTransfer;
            document.getElementById('media-input').files = selectedFilesList.files;
            updatePreviewUI();
        }

        function clearSelectedFiles() {
            selectedFilesList = new DataTransfer();
            document.getElementById('media-input').value = '';
            updatePreviewUI();
        }

        function updatePreviewUI() {
            const container = document.getElementById('horizontal-preview');
            const clearBtn = document.getElementById('clear-files-btn');
            container.innerHTML = '';

            if (selectedFilesList.files.length === 0) {
                container.classList.add('hidden');
                clearBtn.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            clearBtn.classList.remove('hidden');

            Array.from(selectedFilesList.files).forEach((file, idx) => {
                const wrapper = document.createElement('div');
                wrapper.style.cssText = 'position: relative; width: 74px; height: 74px; border-radius: 10px; overflow: hidden; border: 2px solid var(--primary); flex-shrink: 0;';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
                    wrapper.appendChild(img);
                } else {
                    const vidLabel = document.createElement('div');
                    vidLabel.textContent = '🎬 Video';
                    vidLabel.style.cssText = 'width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; background: rgba(0,0,0,0.4); color: #fff;';
                    wrapper.appendChild(vidLabel);
                }

                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.textContent = '×';
                delBtn.onclick = () => removeSingleFile(idx);
                delBtn.style.cssText = 'position: absolute; top: 2px; right: 2px; width: 18px; height: 18px; border-radius: 50%; background: #ef4444; color: #fff; font-size: 12px; font-weight: bold; line-height: 1; display: flex; align-items: center; justify-content: center;';
                wrapper.appendChild(delBtn);

                container.appendChild(wrapper);
            });
        }
    </script>
</x-app-layout>