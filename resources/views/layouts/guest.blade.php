<!DOCTYPE html>
<html lang="id" data-theme="academic" data-font="sans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>XI RPL 1 - Tamsis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #0D47A1 0%, #0D47A1 68%, #2196F3 100%);
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, sans-serif;
        }
        .auth-card {
            background: rgba(10, 25, 52, 0.92);
            color: #f8fafc;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.35);
        }
        .auth-btn {
            background: linear-gradient(135deg, #0D47A1 0%, #0D47A1 65%, #2196F3 100%);
            color: #ffffff;
        }
        input {
            background-color: #07142b !important;
            color: #f8fafc !important;
            border-color: #2196F3 !important;
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center p-4">
    <div class="w-full max-w-md auth-card rounded-2xl shadow-2xl p-7 sm:p-8">
        <div class="text-center mb-6">
            <div class="inline-block px-3.5 py-1 rounded-full text-xs font-extrabold tracking-wider uppercase auth-btn mb-2">
                XI RPL 1 — Tamsis
            </div>
        </div>
        {{ $slot }}
    </div>
</body>
</html>