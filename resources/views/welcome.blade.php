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
    @fluxAppearance
</head>
<body class="bg-white dark:bg-neutral-950">
    @if (Route::has('login'))
        <nav class="fixed top-0 inset-x-0 z-50 flex items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2" wire:navigate>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-600">
                    <span class="text-white font-bold text-sm">PS</span>
                </span>
                <span class="font-semibold text-neutral-900 dark:text-white">PadelSpot</span>
            </a>
            <div class="flex items-center gap-3">
                @auth
                    <flux:button :href="route('dashboard')" variant="primary" wire:navigate>
                        Dashboard
                    </flux:button>
                @else
                    <flux:button :href="route('login')" variant="ghost" wire:navigate>
                        Masuk
                    </flux:button>
                    <flux:button :href="route('register')" variant="primary" wire:navigate>
                        Daftar
                    </flux:button>
                @endauth
            </div>
        </nav>
    @endif

    {{-- Hero --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-neutral-900 to-neutral-950"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full blur-[128px]"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-400 rounded-full blur-[128px]"></div>
        </div>
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <div class="flex items-center justify-center mb-8">
                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-600 shadow-lg shadow-emerald-500/25">
                    <span class="text-white font-bold text-3xl">PS</span>
                </span>
            </div>
            <h1 class="text-5xl sm:text-7xl font-bold text-white mb-6 tracking-tight">
                Main Padel, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-emerald-300">Mudah Bookingnya</span>
            </h1>
            <p class="text-lg sm:text-xl text-neutral-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Sistem booking lapangan padel modern dan terpercaya. Pesan lapangan, atur jadwal, 
                dan kelola pembayaran dalam satu platform.
            </p>
            <div class="flex items-center justify-center gap-4">
                @guest
                    <flux:button :href="route('register')" variant="primary" size="xl" class="px-8 py-4 text-base" wire:navigate>
                        Mulai Booking
                    </flux:button>
                    <flux:button :href="route('courts.index')" variant="ghost" size="xl" class="px-8 py-4 text-base text-white border border-neutral-700 hover:bg-white/10" wire:navigate>
                        Lihat Lapangan
                    </flux:button>
                @else
                    <flux:button :href="route('dashboard')" variant="primary" size="xl" class="px-8 py-4 text-base" wire:navigate>
                        Buka Dashboard
                    </flux:button>
                @endguest
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Stats --}}
    <section class="relative -mt-20 z-20 px-6 pb-20">
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl p-8 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                <div class="text-4xl font-bold text-emerald-600 mb-1">3</div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">Lapangan Tersedia</div>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl p-8 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                <div class="text-4xl font-bold text-emerald-600 mb-1">14</div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">Jam Operasional</div>
            </div>
            <div class="bg-white dark:bg-neutral-900 rounded-2xl p-8 border border-neutral-200 dark:border-neutral-800 shadow-sm">
                <div class="text-4xl font-bold text-emerald-600 mb-1">24/7</div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">Online Booking</div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-24 px-6 bg-neutral-50 dark:bg-neutral-900/50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white mb-4">
                    Kenapa PadelSpot?
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 max-w-xl mx-auto">
                    Platform booking lapangan padel paling mudah dan lengkap untuk kamu
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Booking Mudah</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Pilih lapangan dan jam dengan sistem kalender interaktif</p>
                </div>
                <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Pembayaran Aman</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Transfer atau upload bukti bayar dengan mudah</p>
                </div>
                <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Fleksibel</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Atur jadwal sesuai kebutuhan, batalkan kapan saja</p>
                </div>
                <div class="bg-white dark:bg-neutral-900 rounded-2xl p-6 border border-neutral-200 dark:border-neutral-800">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-neutral-900 dark:text-white mb-2">Tim Support</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Tim kami siap membantu 24/7 jika ada kendala</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Courts Preview --}}
    <section class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white mb-4">
                    Lapangan Tersedia
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 max-w-xl mx-auto">
                    Berbagai pilihan lapangan dengan kualitas terbaik untuk permainan maksimal
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="group relative rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                    <div class="aspect-[4/3] bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-emerald-600/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Lapangan A</h3>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">Tersedia</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Lapangan indoor dengan pencahayaan penuh</p>
                    </div>
                </div>
                <div class="group relative rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                    <div class="aspect-[4/3] bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-emerald-600/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Lapangan B</h3>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">Tersedia</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Lapangan outdoor dengan view taman</p>
                    </div>
                </div>
                <div class="group relative rounded-2xl overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900">
                    <div class="aspect-[4/3] bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/20 flex items-center justify-center">
                        <svg class="w-16 h-16 text-emerald-600/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-neutral-900 dark:text-white">Lapangan C</h3>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">Tersedia</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Lapangan VIP dengan fasilitas premium</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-10">
                <flux:button :href="route('courts.index')" variant="primary" size="xl" class="px-8" wire:navigate>
                    Lihat Semua Lapangan
                </flux:button>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-24 px-6 bg-neutral-900 dark:bg-neutral-950 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 rounded-full blur-[100px]"></div>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Siap Main Padel?
            </h2>
            <p class="text-neutral-400 mb-10 max-w-xl mx-auto">
                Daftar sekarang dan nikmati kemudahan booking lapangan padel favoritmu
            </p>
            @guest
                <flux:button :href="route('register')" variant="primary" size="xl" class="px-10 py-4 text-base" wire:navigate>
                    Daftar Gratis
                </flux:button>
            @else
                <flux:button :href="route('bookings.create')" variant="primary" size="xl" class="px-10 py-4 text-base" wire:navigate>
                    Booking Sekarang
                </flux:button>
            @endguest
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-neutral-950 border-t border-neutral-800 py-12 px-6">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-neutral-500">
                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-emerald-600">
                    <span class="text-white font-bold text-xs">PS</span>
                </span>
                PadelSpot &copy; {{ date('Y') }}
            </div>
            <div class="flex items-center gap-6 text-sm text-neutral-500">
                <a href="{{ route('courts.index') }}" class="hover:text-neutral-300 transition" wire:navigate>Lapangan</a>
                <a href="{{ route('login') }}" class="hover:text-neutral-300 transition" wire:navigate>Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-neutral-300 transition" wire:navigate>Daftar</a>
            </div>
        </div>
    </footer>
</body>
</html>