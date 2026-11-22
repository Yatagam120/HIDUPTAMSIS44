<x-guest-layout>
    <h1 class="text-xl font-bold text-center mb-1">Verifikasi Kode OTP</h1>
    <p class="text-xs text-center opacity-75 mb-5">Cek kotak masuk atau folder spam Gmail kamu.</p>

    @if (session('status'))
        <div class="mb-4 p-3 rounded-xl bg-sky-900/60 border border-sky-400 text-sky-200 text-xs font-semibold">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.otp.update') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold mb-1">Alamat Gmail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required readonly
                   class="w-full rounded-xl border p-2.5 text-sm opacity-80">
        </div>

        <div>
            <label for="code" class="block text-xs font-semibold mb-1">Kode Verifikasi (6 Digit)</label>
            <input id="code" type="text" name="code" maxlength="6" required autofocus
                   placeholder="123456" class="w-full rounded-xl border p-2.5 text-center text-lg font-bold tracking-[0.4em]">
            <x-input-error :messages="$errors->get('code')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold mb-1">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required
                   placeholder="Minimal 8 karakter" class="w-full rounded-xl border p-2.5 text-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold mb-1">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   placeholder="Ulangi kata sandi baru" class="w-full rounded-xl border p-2.5 text-sm">
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-sm auth-btn shadow-md hover:opacity-90 transition">
            Simpan Kata Sandi Baru
        </button>
    </form>
</x-guest-layout>