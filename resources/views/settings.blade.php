<x-app-layout>
    @php
        $user = auth()->user();
        $rawRole = strtolower(trim((string) ($user->role ?? $user->jabatan ?? 'siswa')));
        $isAdminRole = $rawRole === 'admin';

        $approvedMusics = \Illuminate\Support\Facades\Schema::hasTable('app_musics')
            ? \Illuminate\Support\Facades\DB::table('app_musics')->where('status', 'approved')->orderByDesc('id')->get()
            : collect();

        $darkThemes = [
            ['id' => 'academic-trust',   'name' => 'Academic Trust',   'swatch' => 'linear-gradient(135deg, #0a192f, #3b82f6)'],
            ['id' => 'deep-ocean',       'name' => 'Deep Ocean',       'swatch' => 'linear-gradient(135deg, #041c32, #06b6d4)'],
            ['id' => 'midnight-scholar', 'name' => 'Midnight Scholar', 'swatch' => 'linear-gradient(135deg, #0f0c29, #8b5cf6)'],
            ['id' => 'forest-academy',   'name' => 'Forest Academy',   'swatch' => 'linear-gradient(135deg, #052e16, #10b981)'],
            ['id' => 'mode-gelap',       'name' => 'Mode Gelap',       'swatch' => 'linear-gradient(135deg, #09090b, #6366f1)'],
        ];

        $lightThemes = [
            ['id' => 'teal-growth',      'name' => 'Teal Growth',      'swatch' => 'linear-gradient(135deg, #ccfbf1, #0d9488)'],
            ['id' => 'creative-spark',   'name' => 'Creative Spark',   'swatch' => 'linear-gradient(135deg, #fae8ff, #c026d3)'],
            ['id' => 'lavender-dream',   'name' => 'Lavender Dream',   'swatch' => 'linear-gradient(135deg, #e0e7ff, #4f46e5)'],
            ['id' => 'soft-berry',       'name' => 'Soft Berry',       'swatch' => 'linear-gradient(135deg, #ffe4e6, #e11d48)'],
            ['id' => 'morning-assembly', 'name' => 'Morning Assembly', 'swatch' => 'linear-gradient(135deg, #fef3c7, #d97706)'],
        ];
    @endphp

    <!-- [REMOVED] LIVE PREVIEW TAMPILAN -->
    <div class="text-lg font-extrabold"></div>
    <p class="text-sm opacity-85"></p>
    <div class="pt-1 flex flex-wrap items-center gap-2">
        <span class="theme-primary px-3 py-1.5 rounded-lg text-xs font-bold inline-block"></span>
        <span class="badge-success px-2.5 py-1 rounded-full text-xs font-bold border inline-block">Selesai</span>
        <span class="badge-warning px-2.5 py-1 rounded-full text-xs font-bold border inline-block">Tenggat</span>
    </div>
</div>
<!-- MODULE-POLISH-V6-END -->



<!-- SETTINGS-UNHIDE-ALL-START -->
<style id="settings-unhide-all">
    main, main > div, main .max-w-5xl, main .max-w-6xl, main .max-w-4xl, main section, main .theme-card {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        max-height: none !important;
        overflow: visible !important;
    }
    main .grid { display: grid !important; }
    main .flex { display: flex !important; }
</style>
<!-- SETTINGS-UNHIDE-ALL-END -->
</x-app-layout>
