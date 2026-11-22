<x-app-layout>
    <div class="mb-4 max-w-lg mx-auto">
        <a href="{{ route('students.show', $student->id) }}" class="text-sm font-semibold hover:underline" style="color: var(--primary);">
            ← Kembali ke Profil Siswa
        </a>
    </div>

    <div class="theme-card rounded-2xl shadow-lg p-6 sm:p-8 max-w-lg mx-auto border-t-4 theme-border">
        <h1 class="text-xl sm:text-2xl font-bold mb-1">Edit Data Siswa</h1>
        <p class="text-xs sm:text-sm opacity-75 mb-6">Perbarui nama, jabatan kelas, atau ganti foto profil.</p>

        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $student->nama) }}" required
                       class="w-full rounded-xl border p-2.5 text-sm">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Jabatan di Kelas</label>
                @php $currentJabatan = $student->jabatan ?? 'siswa'; @endphp
                <select name="jabatan" required class="w-full rounded-xl border p-2.5 text-sm">
                    <option value="siswa" {{ old('jabatan', $student->jabatan ?? 'siswa') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="ppts" {{ old('jabatan', $student->jabatan ?? '') === 'ppts' ? 'selected' : '' }}>PPTS</option>
                    <option value="ex_ppts" {{ old('jabatan', $student->jabatan ?? '') === 'ex_ppts' ? 'selected' : '' }}>Ex-PPTS</option>
                    <option value="ketua_kelas" {{ old('jabatan', $student->jabatan ?? '') === 'ketua_kelas' ? 'selected' : '' }}>Ketua Kelas</option>
                    <option value="wakil_ketua" {{ old('jabatan', $student->jabatan ?? '') === 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua Kelas</option>
                    <option value="walas" {{ old('jabatan', $student->jabatan ?? '') === 'walas' ? 'selected' : '' }}>Wali Kelas</option>
                </select>
                @error('jabatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Ganti Foto Profil (Opsional)</label>
                <input type="file" name="foto" accept="image/*" onchange="previewEditPhoto(event)"
                       class="w-full rounded-xl border p-2 text-xs">

                <div class="mt-4 flex flex-col items-center">
                    <img id="edit-photo-preview" 
                         src="{{ $student->foto ? asset('storage/' . $student->foto) : '' }}" 
                         style="width: 112px; height: 112px; max-width: 112px; max-height: 112px; object-fit: cover; border-radius: 50%;"
                         class="{{ $student->foto ? '' : 'hidden' }} border-4 theme-border shadow-md">

                    @if($student->foto)
                        <label class="inline-flex items-center gap-2 mt-2.5 text-xs text-red-500 font-semibold cursor-pointer">
                            <input type="checkbox" name="hapus_foto" value="1" class="rounded">
                            <span>Hapus foto saat ini</span>
                        </label>
                    @endif
                </div>
                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-3 flex items-center gap-3">
                <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm theme-primary shadow-md hover:opacity-90 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewEditPhoto(e) {
            const img = document.getElementById('edit-photo-preview');
            if (e.target.files && e.target.files[0]) {
                img.src = URL.createObjectURL(e.target.files[0]);
                img.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>