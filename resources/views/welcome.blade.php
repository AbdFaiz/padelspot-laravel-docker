<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PadelSpot - Sistem Booking Lapangan Padel</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="relative flex flex-col items-center justify-center min-h-screen px-6">
        @if (Route::has('login'))
            <header class="absolute top-0 right-0 p-6">
                <nav class="flex items-center gap-4">
                    @auth
                        <flux:link :href="route('dashboard')" variant="primary" wire:navigate>
                            Dashboard
                        </flux:link>
                    @else
                        <flux:link :href="route('login')" wire:navigate>
                            Masuk
                        </flux:link>
                        <flux:link :href="route('register')" variant="primary" wire:navigate>
                            Daftar
                        </flux:link>
                    @endauth
                </nav>
            </header>
        @endif

        <main class="text-center max-w-2xl">
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">PS</span>
                </div>
            </div>

            <h1 class="text-5xl font-bold text-zinc-900 dark:text-white mb-4">
                PadelSpot
            </h1>

            <p class="text-xl text-zinc-600 dark:text-zinc-400 mb-8">
                Sistem Booking Lapangan Padel
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-3xl font-bold text-green-600 mb-2">3</div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Lapangan Tersedia</div>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-3xl font-bold text-green-600 mb-2">14</div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Jam Operasional</div>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                    <div class="text-3xl font-bold text-green-600 mb-2">24/7</div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400">Online Booking</div>
                </div>
            </div>

            @guest
                <div class="flex items-center justify-center gap-4">
                    <flux:link :href="route('register')" variant="primary" class="px-8 py-3" wire:navigate>
                        Mulai Booking Sekarang
                    </flux:link>
                    <flux:link :href="route('login')" class="px-8 py-3" wire:navigate>
                        Masuk
                    </flux:link>
                </div>
            @else
                <flux:link :href="route('dashboard')" variant="primary" class="px-8 py-3" wire:navigate>
                    Buka Dashboard
                </flux:link>
            @endguest
        </main>

        <footer class="absolute bottom-0 p-6 text-sm text-zinc-500">
            PadelSpot &copy; {{ date('Y') }} - Sistem Booking Lapangan Padel
        </footer>
    </div>
</body>
</html>
