<x-guest-layout>
    <h1 class="text-xl font-bold text-center mb-1">Masuk ke Ruang Kelas</h1>
    <p class="text-xs text-center opacity-75 mb-6">Gunakan akun Gmail atau email yang terdaftar.</p>

    @if (session('status'))
        <div class="mb-4 p-3 rounded-xl bg-emerald-900/60 border border-emerald-400 text-emerald-200 text-xs font-semibold">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold mb-1">Alamat Gmail / Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="contoh@gmail.com" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required
                   placeholder="••••••••" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded">
                <span>Ingat saya</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sky-400 hover:underline font-semibold">
                Lupa kata sandi?
            </a>
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm auth-btn shadow-md hover:opacity-90 transition">
            Masuk
        </button>

        <p class="text-center text-xs opacity-80 pt-2">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-sky-400 font-bold hover:underline">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>