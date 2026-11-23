<x-app-layout>
    @php
        $rawRole = strtolower(trim((string) (auth()->user()->role ?? auth()->user()->jabatan ?? 'siswa')));
        $isHighAuth = in_array($rawRole, ['admin', 'guru', 'ppts', 'ketua_kelas', 'ketua kelas', 'wakil_ketua_kelas', 'wakil ketua kelas'], true);
        $uid = (int) auth()->id();
        $tabs = [
            'catatan' => ['label' => 'Catatan', 'icon' => '📝'],
            'tugas'   => ['label' => 'Tugas',   'icon' => '📌'],
            'pr'      => ['label' => 'PR',      'icon' => '🏠'],
            'event'   => ['label' => 'Event',   'icon' => '🎉'],
        ];
    @endphp

    <div class="max-w-5xl mx-auto space-y-5">
        <!-- Header Mapel -->
        <div class="theme-card border theme-border rounded-2xl p-5 flex flex-wrap items-center justify-between gap-3 shadow-lg">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-wider opacity-70">{{ $subject->kode_mapel ?? 'MAPEL' }}</div>
                <h1 class="text-xl sm:text-2xl font-extrabold">{{ $subject->nama_mapel }}</h1>
                <p class="text-xs opacity-75 mt-0.5">Guru Pengampu: <strong>{{ $subject->guru_pengampu ?? '-' }}</strong></p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-3.5 py-2 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                ← Kembali ke Jadwal Utama
            </a>
        </div>

        @if(session('success'))
            <div class="p-3 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-3 rounded-xl bg-red-500/20 border border-red-500/40 text-red-300 text-xs font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Navigasi 4 Tab -->
        <div class="grid grid-cols-4 gap-2">
            @foreach($tabs as $tKey => $tMeta)
                @php
                    $cnt = $items->where('type', $tKey)->count();
                @endphp
                <button type="button"
                        data-tab="{{ $tKey }}"
                        onclick="switchSubjectTab('{{ $tKey }}')"
                        class="subj-tab-btn px-3 py-2.5 rounded-xl border theme-border text-xs font-extrabold flex items-center justify-center gap-1.5 {{ $activeTab === $tKey ? 'theme-primary shadow' : 'theme-card' }}">
                    <span>{{ $tMeta['icon'] }}</span>
                    <span>{{ $tMeta['label'] }}</span>
                    <span class="px-1.5 py-0.2 rounded-full bg-black/20 text-[10px]">{{ $cnt }}</span>
                </button>
            @endforeach
        </div>

        <!-- Form Tambah Postingan + Upload & Crop Gambar Sebelum Confirm Post (#2, #6) -->
        <div class="space-y-3">
    <button type="button" id="btn-toggle-subject-form"
            onclick="document.getElementById('subject-post-form-wrap').classList.toggle('hidden')"
            class="theme-primary px-4 py-2.5 rounded-xl text-xs font-extrabold shadow inline-flex items-center gap-2">
        <span class="text-base leading-none font-black">+</span>
        <span>Tambah Pelajaran / Postingan</span>
    </button>
    <div id="subject-post-form-wrap" class="hidden">
        <form id="subject-post-form"
              action="{{ route('subject.items.store', $subject->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
            @csrf
            <input type="hidden" name="type" id="post-type-input" value="{{ $activeTab }}">
            <input type="hidden" name="cropped_image_base64" id="cropped-image-base64">

            <div class="flex items-center justify-between">
                <div class="text-sm font-extrabold">
                    ➕ Tambah <span id="post-type-label" class="uppercase" style="color: var(--primary);">{{ $activeTab }}</span>
                </div>
                @if(!$isHighAuth)
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/40 text-[10px] font-bold">
                        Perlu Verifikasi Admin / Pengurus
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="title" required placeholder="Judul postingan..."
                       class="sm:col-span-2 rounded-xl border theme-border px-3 py-2 text-xs font-semibold">
                <input type="date" name="due_date" id="post-due-date"
                       value="{{ now()->format('Y-m-d') }}"
                       class="rounded-xl border theme-border px-3 py-2 text-xs font-semibold {{ $activeTab === 'catatan' ? 'hidden' : '' }}">
            </div>

            <textarea name="description" rows="2" placeholder="Deskripsi, instruksi tugas, atau isi catatan..."
                      class="w-full rounded-xl border theme-border px-3 py-2 text-xs"></textarea>

            <!-- Pilih Media Foto / Video + Crop Preview (#2, #6) -->
            <div class="p-3 rounded-xl theme-soft border theme-border space-y-2">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <label class="text-xs font-extrabold">📎 Lampiran Foto / Video (Opsional):</label>
                    <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl theme-primary text-xs font-extrabold cursor-pointer shadow hover:opacity-90">
                        <span class="text-base leading-none font-black">+</span>
                        <span id="subject-media-btn-text">Unggah Foto / Video</span>
                        <input type="file" name="media" id="subject-media-input"
                           accept="image/*,video/mp4,video/webm,video/quicktime"
                           onchange="handleMediaSelectForCrop(this)"
                           class="hidden">
                    </label>
                </div>

                <!-- Preview Hasil Crop / Video sebelum Confirm Post -->
                <div id="pre-post-media-preview" class="hidden pt-2 space-y-2">
                    <div class="text-[11px] font-bold text-emerald-400">✓ Media siap diposting (klik foto untuk preview penuh):</div>
                    <img id="pre-post-img-preview" src="" alt="Hasil Crop" class="hidden max-h-48 rounded-xl border theme-border object-contain">
                    <video id="pre-post-video-preview" controls class="hidden max-h-48 rounded-xl border theme-border bg-black"></video>
                    <div class="flex gap-2">
                        <button type="button" id="btn-reopen-crop" onclick="reopenCropModal()" class="hidden px-2.5 py-1 rounded-lg border theme-border text-[11px] font-extrabold">
                            ✂️ Crop Ulang Gambar
                        </button>
                        <button type="button" onclick="clearSelectedMedia()" class="px-2.5 py-1 rounded-lg bg-red-500/20 text-red-400 text-[11px] font-extrabold">
                            ✕ Hapus Lampiran
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="theme-primary px-5 py-2.5 rounded-xl text-xs font-extrabold shadow">
                {{ $isHighAuth ? 'Confirm & Posting Sekarang' : 'Ajukan Postingan (Verifikasi Admin)' }}
            </button>
        </form>
    </div>
</div>

        <!-- Daftar Postingan Per Tab -->
        @foreach($tabs as $tKey => $tMeta)
            @php
                $tabItems = $items->where('type', $tKey);
            @endphp
            <div id="tab-panel-{{ $tKey }}" class="subj-tab-panel space-y-4 {{ $activeTab === $tKey ? '' : 'hidden' }}">
                @forelse($tabItems as $it)
                    @php
                        $doneArr = is_array($it->completed_by ?? null)
                            ? $it->completed_by
                            : (json_decode((string) ($it->completed_by ?? '[]'), true) ?: []);
                        $isDone = in_array($uid, array_map('intval', $doneArr), true);
                        $itemComments = $commentsByItem->get($it->id) ?? collect();
                    @endphp
                    <div class="theme-card border theme-border rounded-2xl p-5 space-y-3 shadow">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md theme-primary text-[10px] font-extrabold uppercase">{{ $it->type }}</span>
                                    @if(($it->status ?? 'approved') === 'pending')
                                        <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/40 text-[10px] font-extrabold">
                                            ⏳ Menunggu Verifikasi Admin
                                        </span>
                                    @endif
                                    @if($it->due_date)
                                        <span class="text-[11px] font-bold opacity-80">📅 Tenggat: {{ \Carbon\Carbon::parse($it->due_date)->format('d M Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="text-base font-extrabold {{ $isDone ? 'line-through opacity-60' : '' }}">{{ $it->title }}</h3>
                            </div>

                            <!-- Aksi: Reaksi Selesai, ACC Pending (Otoritas Tinggi), Edit & Hapus (Otoritas Tinggi) -->
                            <div class="flex flex-wrap items-center gap-1.5">
                                @if(in_array($it->type, ['tugas', 'pr', 'event'], true))
                                    <form action="{{ route('items.toggle-complete', $it->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-xl text-xs font-extrabold border {{ $isDone ? 'bg-emerald-500 text-white border-emerald-500' : 'theme-soft theme-border' }}">
                                            {{ $isDone ? '✅ Selesai' : '⬜ Tandai Selesai' }}
                                        </button>
                                    </form>
                                @endif

                                @if($isHighAuth && ($it->status ?? 'approved') === 'pending')
                                    <form action="{{ route('items.approve', $it->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-sky-500 text-white text-xs font-extrabold">
                                            ✓ ACC Post
                                        </button>
                                    </form>
                                @endif

                                @if($isHighAuth)
                                    <button type="button"
                                            onclick="document.getElementById('edit-box-{{ $it->id }}').classList.toggle('hidden')"
                                            class="px-2.5 py-1.5 rounded-xl border theme-border theme-soft text-xs font-extrabold">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('subject.items.destroy', ['subject' => $subject->id, 'item' => $it->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-red-500/20 text-red-400 border border-red-500/40 text-xs font-extrabold">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if($it->description)
                            <p class="text-xs sm:text-sm opacity-90 whitespace-pre-line">{{ $it->description }}</p>
                        @endif

                        <!-- Attachment Media Foto / Video (#2, #4) -->
                        @if(!empty($it->media_path))
                            <div class="pt-1">
                                @if(($it->media_type ?? 'image') === 'video')
                                    <video controls class="w-full max-h-96 rounded-xl border theme-border bg-black">
                                        <source src="{{ asset($it->media_path) }}">
                                    </video>
                                @else
                                    <img src="{{ asset($it->media_path) }}" alt="{{ $it->title }}"
                                         class="max-h-96 rounded-xl border theme-border object-contain">
                                @endif
                            </div>
                        @endif

                        <!-- Form Edit Inline (Khusus Otoritas Tinggi #3) -->
                        @if($isHighAuth)
                            <form id="edit-box-{{ $it->id }}"
                                  action="{{ route('subject.items.update', ['subject' => $subject->id, 'item' => $it->id]) }}"
                                  method="POST"
                                  class="hidden p-3 rounded-xl theme-soft border theme-border space-y-2">
                                @csrf
                                @method('PATCH')
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <input type="text" name="title" value="{{ $it->title }}" required class="sm:col-span-2 rounded-lg border theme-border px-2.5 py-1.5 text-xs">
                                    <input type="date" name="due_date" value="{{ $it->due_date ? \Carbon\Carbon::parse($it->due_date)->format('Y-m-d') : '' }}" class="rounded-lg border theme-border px-2.5 py-1.5 text-xs">
                                </div>
                                <textarea name="description" rows="2" class="w-full rounded-lg border theme-border px-2.5 py-1.5 text-xs">{{ $it->description }}</textarea>
                                <button type="submit" class="theme-primary px-3 py-1.5 rounded-lg text-xs font-extrabold">Simpan Perubahan</button>
                            </form>
                        @endif

                        <!-- Section Komentar Ala Facebook (#8) -->
                        <div class="pt-3 border-t theme-border space-y-2.5">
                            <div class="text-[11px] font-extrabold opacity-80">💬 Komentar ({{ $itemComments->count() }})</div>

                            @if($itemComments->isNotEmpty())
                                <div class="space-y-2">
                                    @foreach($itemComments as $cmt)
                                        <div class="p-2.5 rounded-2xl theme-soft border theme-border flex items-start justify-between gap-2">
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-extrabold">{{ $cmt->user->name ?? 'Siswa' }}</span>
                                                    <span class="text-[9px] px-1.5 py-0.2 rounded bg-black/20 uppercase font-bold opacity-75">
                                                        {{ $cmt->user->role ?? 'siswa' }}
                                                    </span>
                                                    <span class="text-[10px] opacity-60">{{ \Carbon\Carbon::parse($cmt->created_at)->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-xs mt-1 whitespace-pre-line">{{ $cmt->body }}</p>
                                            </div>
                                            @if((int) $cmt->user_id === $uid || $isHighAuth)
                                                <form action="{{ route('items.comments.destroy', $cmt->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[10px] text-red-400 font-bold hover:underline">Hapus</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('items.comments.store', $it->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="text" name="body" required placeholder="Tulis komentar seperti di Facebook..."
                                       class="flex-1 rounded-full border theme-border px-3.5 py-1.5 text-xs">
                                <button type="submit" class="theme-primary px-3.5 py-1.5 rounded-full text-xs font-extrabold shrink-0">
                                    Kirim
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="theme-card border theme-border rounded-2xl p-8 text-center text-xs opacity-75">
                        Belum ada {{ $tMeta['label'] }} di mata pelajaran ini.
                    </div>
                @endforelse
            </div>
        @endforeach
    </div>

    <!-- Modal Crop Gambar Sebelum Confirm Post (#6) -->
    <div id="image-crop-modal" class="fixed inset-0 z-[99995] hidden items-center justify-center bg-black/85 p-4">
        <div class="theme-card border theme-border rounded-2xl max-w-xl w-full p-4 space-y-3 shadow-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-extrabold">✂️ Sesuaikan & Crop Gambar Sebelum Posting</h3>
                <button type="button" onclick="closeCropModal()" class="px-2 py-1 rounded border theme-border text-xs font-bold">✕</button>
            </div>

            <div class="overflow-hidden rounded-xl border theme-border bg-black flex items-center justify-center max-h-[55vh]">
                <canvas id="crop-preview-canvas" class="max-w-full max-h-[52vh]"></canvas>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                <label class="space-y-1">
                    <span class="text-[10px] font-bold opacity-75">Zoom: <span id="crop-zoom-val">100%</span></span>
                    <input type="range" id="crop-zoom-range" min="100" max="250" value="100" oninput="renderCropCanvas()" class="w-full">
                </label>
                <label class="space-y-1">
                    <span class="text-[10px] font-bold opacity-75">Geser Horizontal</span>
                    <input type="range" id="crop-x-range" min="-200" max="200" value="0" oninput="renderCropCanvas()" class="w-full">
                </label>
                <label class="space-y-1">
                    <span class="text-[10px] font-bold opacity-75">Geser Vertikal</span>
                    <input type="range" id="crop-y-range" min="-200" max="200" value="0" oninput="renderCropCanvas()" class="w-full">
                </label>
                <label class="space-y-1">
                    <span class="text-[10px] font-bold opacity-75">Rasio Potong</span>
                    <select id="crop-aspect-select" onchange="renderCropCanvas()" class="w-full rounded-lg border theme-border px-2 py-1 text-xs">
                        <option value="free">Asli (Full)</option>
                        <option value="16:9">16:9 Landscape</option>
                        <option value="4:3">4:3 Standar</option>
                        <option value="1:1">1:1 Kotak</option>
                    </select>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeCropModal()" class="px-3.5 py-2 rounded-xl border theme-border text-xs font-extrabold">Batal</button>
                <button type="button" onclick="applyCropResult()" class="theme-primary px-4 py-2 rounded-xl text-xs font-extrabold shadow">
                    ✓ Gunakan Gambar Ini
                </button>
            </div>
        </div>
    </div>

    <script>
        let rawCropImage = null;

        function switchSubjectTab(tabKey) {
            document.getElementById('post-type-input').value = tabKey;
            document.getElementById('post-type-label').textContent = tabKey;

            document.querySelectorAll('.subj-tab-btn').forEach(btn => {
                if (btn.dataset.tab === tabKey) {
                    btn.classList.add('theme-primary', 'shadow');
                    btn.classList.remove('theme-card');
                } else {
                    btn.classList.remove('theme-primary', 'shadow');
                    btn.classList.add('theme-card');
                }
            });

            document.querySelectorAll('.subj-tab-panel').forEach(panel => {
                panel.classList.toggle('hidden', panel.id !== 'tab-panel-' + tabKey);
            });
        }

        function handleMediaSelectForCrop(input) {
            const file = input.files && input.files[0];
            if (!file) return;

            const previewWrap = document.getElementById('pre-post-media-preview');
            const imgPrev = document.getElementById('pre-post-img-preview');
            const vidPrev = document.getElementById('pre-post-video-preview');
            const btnReopen = document.getElementById('btn-reopen-crop');

            if (file.type.startsWith('video/')) {
                document.getElementById('cropped-image-base64').value = '';
                imgPrev.classList.add('hidden');
                btnReopen.classList.add('hidden');
                vidPrev.src = URL.createObjectURL(file);
                vidPrev.classList.remove('hidden');
                previewWrap.classList.remove('hidden');
                return;
            }

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    const img = new Image();
                    img.onload = function () {
                        rawCropImage = img;
                        document.getElementById('crop-zoom-range').value = 100;
                        document.getElementById('crop-x-range').value = 0;
                        document.getElementById('crop-y-range').value = 0;
                        reopenCropModal();
                    };
                    img.src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function reopenCropModal() {
            if (!rawCropImage) return;
            const modal = document.getElementById('image-crop-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            renderCropCanvas();
        }

        function closeCropModal() {
            const modal = document.getElementById('image-crop-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function renderCropCanvas() {
            if (!rawCropImage) return;
            const canvas = document.getElementById('crop-preview-canvas');
            const ctx = canvas.getContext('2d');
            const zoom = parseInt(document.getElementById('crop-zoom-range').value, 10) / 100;
            const offX = parseInt(document.getElementById('crop-x-range').value, 10);
            const offY = parseInt(document.getElementById('crop-y-range').value, 10);
            const aspect = document.getElementById('crop-aspect-select').value;

            document.getElementById('crop-zoom-val').textContent = Math.round(zoom * 100) + '%';

            let targetW = Math.min(rawCropImage.width, 900);
            let targetH = Math.round(targetW * (rawCropImage.height / rawCropImage.width));

            if (aspect === '16:9') targetH = Math.round(targetW * 9 / 16);
            else if (aspect === '4:3') targetH = Math.round(targetW * 3 / 4);
            else if (aspect === '1:1') targetH = targetW;

            canvas.width = targetW;
            canvas.height = targetH;

            ctx.fillStyle = '#000';
            ctx.fillRect(0, 0, targetW, targetH);

            const drawW = targetW * zoom;
            const drawH = (rawCropImage.height / rawCropImage.width) * drawW;
            const dx = (targetW - drawW) / 2 + offX;
            const dy = (targetH - drawH) / 2 + offY;

            ctx.drawImage(rawCropImage, dx, dy, drawW, drawH);
        }

        function applyCropResult() {
            const canvas = document.getElementById('crop-preview-canvas');
            const dataUrl = canvas.toDataURL('image/png');
            document.getElementById('cropped-image-base64').value = dataUrl;

            const previewWrap = document.getElementById('pre-post-media-preview');
            const imgPrev = document.getElementById('pre-post-img-preview');
            const vidPrev = document.getElementById('pre-post-video-preview');
            const btnReopen = document.getElementById('btn-reopen-crop');

            vidPrev.classList.add('hidden');
            imgPrev.src = dataUrl;
            imgPrev.classList.remove('hidden');
            btnReopen.classList.remove('hidden');
            previewWrap.classList.remove('hidden');

            closeCropModal();
        }

        function clearSelectedMedia() {
            document.getElementById('subject-media-input').value = '';
            document.getElementById('cropped-image-base64').value = '';
            document.getElementById('pre-post-media-preview').classList.add('hidden');
            rawCropImage = null;
        }
    </script>
</x-app-layout>