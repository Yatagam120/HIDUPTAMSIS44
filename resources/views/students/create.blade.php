<x-app-layout>
    <div class="mb-4 max-w-lg mx-auto">
        <a href="{{ route('students.index') }}" class="text-sm font-semibold hover:underline" style="color: var(--primary);" data-i18n="back_siswa">
            ← Kembali ke Daftar Siswa
        </a>
    </div>

    <div class="theme-card rounded-2xl shadow-lg p-6 sm:p-8 max-w-lg mx-auto border-t-4 theme-border">
        <h1 class="text-xl sm:text-2xl font-bold mb-1">Tambah Siswa / Pengurus Baru</h1>
        <p class="text-xs sm:text-sm opacity-75 mb-6">Masukkan nama lengkap, jabatan di kelas, dan foto profil (opsional).</p>

        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso"
                       class="w-full rounded-xl border p-2.5 text-sm">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Jabatan di Kelas</label>
                <select name="jabatan" required class="w-full rounded-xl border p-2.5 text-sm">
                    <option value="siswa" {{ old('jabatan', $student->jabatan ?? 'siswa') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="ppts" {{ old('jabatan', $student->jabatan ?? '') === 'ppts' ? 'selected' : '' }}>PPTS (Bingkai Biru)</option>
                    <option value="ex_ppts" {{ old('jabatan', $student->jabatan ?? '') === 'ex_ppts' ? 'selected' : '' }}>Ex-PPTS (Bingkai Abu-Biru)</option>
                    <option value="ketua_kelas" {{ old('jabatan', $student->jabatan ?? '') === 'ketua_kelas' ? 'selected' : '' }}>Ketua Kelas</option>
                    <option value="wakil_ketua" {{ old('jabatan', $student->jabatan ?? '') === 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua Kelas</option>
                    <option value="walas" {{ old('jabatan', $student->jabatan ?? '') === 'walas' ? 'selected' : '' }}>Wali Kelas</option>
                </select>
                @error('jabatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Foto Profil (Opsional, Maks 3MB)</label>
                <input type="file" name="foto" accept="image/*" onchange="previewNewPhoto(event)"
                       class="w-full rounded-xl border p-2 text-xs">
                <div class="mt-4 flex justify-center">
                    <img id="photo-preview" 
                         style="width: 112px; height: 112px; max-width: 112px; max-height: 112px; object-fit: cover; border-radius: 50%;"
                         class="hidden border-4 theme-border shadow-md">
                </div>
                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                    Simpan Siswa
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewNewPhoto(e) {
            const img = document.getElementById('photo-preview');
            if (e.target.files && e.target.files[0]) {
                img.src = URL.createObjectURL(e.target.files[0]);
                img.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>