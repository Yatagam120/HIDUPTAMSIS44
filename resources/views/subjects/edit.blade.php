<x-app-layout>
    <div class="mb-4 max-w-xl mx-auto">
        <a href="{{ route('subject.show', ['subject' => $post->subject_id, 'tab' => $post->kategori]) }}"
           class="text-sm font-semibold hover:underline" style="color: var(--primary);">
            ← Kembali ke {{ $post->subject->nama_mapel }}
        </a>
    </div>

    <div class="theme-card rounded-2xl shadow-lg p-6 sm:p-8 max-w-xl mx-auto border-t-4 theme-border">
        <h1 class="text-xl sm:text-2xl font-bold mb-1">Edit {{ ucfirst($post->kategori) }}</h1>
        <p class="text-xs sm:text-sm opacity-75 mb-6">Perbarui judul, keterangan, atau tanggal tenggat.</p>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $post->judul) }}" required
                       class="w-full rounded-xl border p-2.5 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Deskripsi / Keterangan</label>
                <textarea name="deskripsi" rows="4" class="w-full rounded-xl border p-2.5 text-sm">{{ old('deskripsi', $post->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Tanggal / Deadline (Opsional)</label>
                <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline', $post->tanggal_deadline) }}"
                       min="2020-01-01" max="2099-12-31"
                       oninput="if(this.value.split('-')[0].length > 4) this.value = this.value.slice(0, 10);"
                       class="w-full rounded-xl border p-2.5 text-sm">
            </div>

            <div>
                <label class="block text-xs font-bold mb-1">Tambah Lampiran Baru (Opsional)</label>
                <input type="file" name="media[]" multiple accept="image/*,video/*"
                       class="w-full rounded-xl border p-2 text-xs">
            </div>

            <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</x-app-layout>