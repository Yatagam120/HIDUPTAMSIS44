<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>XI RPL 1 - Tamsis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #09090b 0%, #18181b 55%, #09090b 100%);
            --bg-card: rgba(24, 24, 27, 0.94);
            --text-main: #fafafa;
            --primary: #6366f1;
            --border-color: rgba(161, 161, 170, 0.25);
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            margin: 0;
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }

        .guest-card {
            background-color: var(--bg-card);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(14px);
        }

        .guest-card input {
            background-color: rgba(15, 23, 42, 0.72) !important;
            color: #ffffff !important;
            border-color: var(--border-color) !important;
        }

        .guest-card label,
        .guest-card span,
        .guest-card a {
            color: #e4e4e7;
        }
    </style>
</head>
<body class="antialiased flex flex-col items-center justify-center min-h-screen px-4 py-8">
    <div class="w-full max-w-md space-y-5">
        <!-- Header Logo Tamansiswa -->
        <div class="flex flex-col items-center text-center space-y-2">
            <a href="{{ url('/') }}" class="flex flex-col items-center gap-2">
                <img src="{{ asset('images/tamsis.jpeg') }}"
                     onerror="this.src='{{ asset('images/logo-tamsis.png') }}'; this.onerror=function(){this.style.display='none';};"
                     alt="Logo Perguruan Tamansiswa"
                     class="w-16 h-16 rounded-full object-cover border-2 border-indigo-400/50 shadow-lg">
                <div>
                    <div class="text-base font-extrabold tracking-wide text-indigo-400">
                        PELAJAR TAMAN SISWA HEBAT!
                    </div>
                    <div class="text-[11px] text-zinc-400">
                        Ruang Kelas & Jadwal Pelajaran XI RPL 1
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Form Login / Register -->
        <div class="guest-card rounded-2xl p-6 sm:p-7 shadow-2xl">
            {{ $slot }}
        </div>
    </div>

    <script>
        // 1. Paksa reload jika halaman Login/Register dibuka dari cache browser (Back/Forward atau setelah Register)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        // 2. Auto-refresh token CSRF tepat sebelum form Login/Register disubmit agar tidak pernah 419 Page Expired
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form').forEach(function (form) {
                form.addEventListener('submit', async function (e) {
                    if (form.dataset.csrfRefreshed === '1') return;
                    e.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.7';
                    }

                    try {
                        const res = await fetch(window.location.href, {
                            method: 'GET',
                            credentials: 'same-origin',
                            cache: 'no-store'
                        });
                        const html = await res.text();
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const freshToken = doc.querySelector('input[name="_token"]')?.value;
                        const tokenInput = form.querySelector('input[name="_token"]');

                        if (freshToken && tokenInput) {
                            tokenInput.value = freshToken;
                        }
                    } catch (err) {
                        // Tetap lanjut submit menggunakan token yang ada jika offline
                    }

                    form.dataset.csrfRefreshed = '1';
                    form.submit();
                });
            });
        });
    </script>
</body>
</html>