<section>
    <header>
        <h2 class="text-lg font-bold" data-i18n="pass_title">
            Ubah Kata Sandi
        </h2>
        <p class="mt-1 text-sm opacity-75" data-i18n="pass_sub">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold mb-1" data-i18n="pass_current">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full rounded-xl border p-2.5 text-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold mb-1" data-i18n="pass_new">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="w-full rounded-xl border p-2.5 text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold mb-1" data-i18n="pass_confirm">Konfirmasi Kata Sandi</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full rounded-xl border p-2.5 text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold theme-primary shadow-sm hover:opacity-90 transition" data-i18n="btn_save">
                Simpan
            </button>
        </div>
    </form>
</section>