<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6 px-2">
        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="p-3.5 rounded-xl bg-green-100 text-green-800 text-sm font-semibold text-center shadow-sm" data-i18n="profile_updated">
                Pengaturan akun berhasil diperbarui!
            </div>
        @endif

        <!-- Kartu Profil dengan Banner Gradien -->
        <div class="theme-card rounded-2xl shadow-lg overflow-hidden border theme-border">
            <div class="h-16 theme-primary opacity-90"></div>

            <div class="px-6 pb-6 -mt-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <!-- Kiri: Avatar Bulat & Identitas -->
                <div class="flex items-end gap-4 min-w-0">
                    <div style="width: 80px; height: 80px; min-width: 80px;" 
                         class="rounded-full theme-primary border-4 border-white dark:border-slate-800 flex items-center justify-center text-3xl font-extrabold shadow-md select-none">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="text-left min-w-0 pb-1">
                        <span class="inline-block text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full theme-soft border theme-border" style="color: var(--primary);">
                            {{ str_replace('_', ' ', Auth::user()->role) }}
                        </span>
                        <h1 class="text-xl sm:text-2xl font-bold mt-1 truncate">{{ Auth::user()->name }}</h1>
                        <p class="text-xs sm:text-sm opacity-75 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Pojok Kanan: 2 Tombol Bulat Berjarak -->
                <div class="flex items-center gap-3 shrink-0 self-end sm:pb-1">
                    <button type="button" onclick="toggleAccountSettings()" title="Edit Nama & Password"
                            style="width: 42px; height: 42px; min-width: 42px; color: var(--primary);"
                            class="rounded-full theme-soft border theme-border flex items-center justify-center hover:scale-105 transition shadow-sm">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar dari akun?')" class="m-0">
                        @csrf
                        <button type="submit" title="Keluar"
                                style="width: 42px; height: 42px; min-width: 42px;"
                                class="rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 hover:scale-105 transition shadow-sm">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Form Pengaturan Akun -->
        <div id="account-settings-panel" class="hidden space-y-6">
            <div class="theme-card rounded-2xl shadow-md p-6 border theme-border">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="theme-card rounded-2xl shadow-md p-6 border theme-border">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <script>
        function toggleAccountSettings() {
            const panel = document.getElementById('account-settings-panel');
            panel.classList.toggle('hidden');
        }

        @if($errors->any() || $errors->updatePassword->any())
            document.getElementById('account-settings-panel').classList.remove('hidden');
        @endif
    </script>
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
</x-app-layout>