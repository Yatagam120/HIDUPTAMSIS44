<x-guest-layout>
    <h1 class="text-xl font-bold text-center mb-1">Daftar Akun Baru</h1>
    <p class="text-xs text-center opacity-75 mb-6">Daftarkan nama lengkap dan alamat Gmail aktif kamu.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   placeholder="Nama lengkap siswa" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold mb-1">Alamat Gmail Asli</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   placeholder="nama@gmail.com" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required
                   placeholder="Minimal 8 karakter" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold mb-1">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   placeholder="Ulangi kata sandi" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm auth-btn shadow-md hover:opacity-90 transition">
            Daftar Akun
        </button>

        <p class="text-center text-xs opacity-80 pt-2">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-sky-400 font-bold hover:underline">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>