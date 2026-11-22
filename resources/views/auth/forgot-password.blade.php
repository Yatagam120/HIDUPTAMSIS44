<x-guest-layout>
    <h1 class="text-xl font-bold text-center mb-1">Lupa Kata Sandi</h1>
    <p class="text-xs text-center opacity-75 mb-6">Masukkan Gmail kamu untuk menerima kode verifikasi 6 digit.</p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold mb-1">Alamat Gmail Terdaftar</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="nama@gmail.com" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm auth-btn shadow-md hover:opacity-90 transition">
            Kirim Kode Verifikasi
        </button>

        <p class="text-center text-xs opacity-80 pt-2">
            <a href="{{ route('login') }}" class="text-sky-400 font-semibold hover:underline">← Kembali ke halaman Masuk</a>
        </p>
    </form>
</x-guest-layout>