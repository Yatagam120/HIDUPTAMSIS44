<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AntiHackingGuard
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip() ?? 'unknown';
        $rateKey = 'anti_hack_hits:' . $ip;

        // Batasi request ekstrem per menit per IP (misal > 240 req/menit)
        $hits = Cache::get($rateKey, 0) + 1;
        Cache::put($rateKey, $hits, now()->addMinute());
        if ($hits > 240) {
            abort(429, 'Terlalu banyak permintaan dalam waktu singkat.');
        }

        // Periksa pola payload berbahaya pada query & input non-konten-rich
        $rawPayload = json_encode($request->except(['_token', 'deskripsi', 'keterangan', 'isi', 'body', 'content']));
        $suspiciousPatterns = [
            '/union\s+select/i',
            '/information_schema/i',
            '/<\s*script\b/i',
            '/javascript\s*:/i',
            '/on(error|onload|onclick|mouseover)\s*=/i',
            '/\.\.\/|\.\.\\\\/i',
            '/\/etc\/passwd|cmd\.exe|powershell\.exe/i',
        ];

        if (is_string($rawPayload)) {
            foreach ($suspiciousPatterns as $pattern) {
                if (preg_match($pattern, $rawPayload)) {
                    abort(403, 'Aktivitas tidak diizinkan terdeteksi oleh sistem keamanan.');
                }
            }
        }

        /** @var Response $response */
        $response = $next($request);

        if (method_exists($response, 'headers')) {
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
        }

        return $response;
    }
}