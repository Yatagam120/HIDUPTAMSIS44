<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Paksa HTTPS jika berjalan di Railway / production
        if ($this->app->environment('production') || str_contains((string) request()->getHost(), 'railway.app')) {
            URL::forceScheme('https');
        }

        // 2. Pastikan session cookie selalu valid & tidak terkunci domain salah
        config([
            'session.domain' => null,
            'session.same_site' => 'lax',
            'session.secure' => request()->isSecure() || $this->app->environment('production'),
            'session.lifetime' => 43200,
        ]);

        // 3. Jika SESSION_DRIVER=database tapi tabel sessions belum ada, fallback aman ke file
        if (config('session.driver') === 'database') {
            try {
                if (!Schema::hasTable('sessions')) {
                    config(['session.driver' => 'file']);
                }
            } catch (\Throwable $e) {
                config(['session.driver' => 'file']);
            }
        }
    }
}