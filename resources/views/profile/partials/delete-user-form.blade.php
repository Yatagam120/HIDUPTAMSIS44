<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
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