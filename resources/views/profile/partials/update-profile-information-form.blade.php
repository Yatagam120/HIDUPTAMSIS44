<section>
    <header>
        <h2 class="text-lg font-bold" data-i18n="prof_info_title">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm opacity-75" data-i18n="prof_info_sub">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-5 space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold mb-1" data-i18n="prof_name">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="w-full rounded-xl border p-2.5 text-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold mb-1" data-i18n="prof_email">Alamat Email</label>
            <input id="email" name="email" type="email" class="w-full rounded-xl border p-2.5 text-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold theme-primary shadow-sm hover:opacity-90 transition" data-i18n="btn_save">
                Simpan
            </button>
        </div>
    </form>
</section>
<!-- MODULE-POLISH-V6-START -->
<style id="module-polish-v6">
    /* Tugas & Materi: spacing card lebih lega & empty state lebih jelas */
    main .task-card,
    main .material-card {
        padding: 1rem 1.15rem;
        border-radius: 14px;
    }

    main .empty-state-box {
        padding: 2rem 1.25rem;
        border-radius: 16px;
        line-height: 1.6;
    }

    /* Admin users: jarak antar kontrol lebih rapi */
    main table th,
    main table td {
        padding: 0.65rem 0.75rem;
        vertical-align: middle;
    }

    /* Live preview box untuk Pengaturan */
    #settings-live-preview {
        border-radius: 14px;
        padding: 1rem 1.25rem;
    }
</style>
<!-- MODULE-POLISH-V6-END -->