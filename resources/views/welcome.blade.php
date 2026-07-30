<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PadelSpot — Platform booking lapangan padel terbaik. Pilih lapangan, tentukan jadwal, dan bermain dengan mudah.">
    <title>PadelSpot — Game On. Padel Your Way.</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @fluxAppearance
</head>
<body class="bg-sand text-gray-900 dark:bg-midnight dark:text-slate-100 font-sans antialiased selection:bg-court-blue selection:text-white overflow-x-hidden">
    <header class="fixed top-0 inset-x-0 z-50 bg-midnight/70 backdrop-blur-md border-b border-white/10">
        <nav class="max-w-7xl mx-auto py-3.5 px-4 sm:px-8 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0" wire:navigate>
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-court-blue text-white shadow-lg shadow-court-blue/30">
                    <x-app-logo-icon class="w-5 h-5" />
                </span>
                <span class="font-bold text-lg tracking-tight text-white font-heading">PadelSpot</span>
            </a>

            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="text-white font-semibold px-4 py-1.5 rounded-lg text-sm bg-white/10">Home</a>
                <a href="#courts" class="text-white/70 hover:text-white hover:bg-white/10 px-4 py-1.5 rounded-lg text-sm font-medium transition-all">Courts</a>
                <a href="#membership" class="text-white/70 hover:text-white hover:bg-white/10 px-4 py-1.5 rounded-lg text-sm font-medium transition-all">Membership</a>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-5 py-2 rounded-xl text-sm font-heading transition-all" wire:navigate>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-white/60 hover:text-white border border-white/20 hover:border-white/40 px-4 py-2 rounded-xl text-sm font-semibold transition-all hidden sm:inline-block" wire:navigate>
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-5 py-2 rounded-xl text-sm font-heading transition-all" wire:navigate>
                        Daftar Gratis
                    </a>
                @endauth
                <button class="md:hidden text-white/70 hover:text-white p-2 rounded-lg hover:bg-white/10 transition" id="mobile-menu-btn" aria-label="Open menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </nav>

        <div class="md:hidden hidden max-w-7xl mx-auto px-4 pb-4" id="mobile-menu">
            <div class="bg-midnight/95 border border-white/10 rounded-xl p-3 flex flex-col gap-1">
                <a href="{{ route('home') }}" class="text-white font-semibold px-4 py-2.5 rounded-lg bg-white/10 text-sm">Home</a>
                <a href="#courts" class="text-white/70 hover:text-white hover:bg-white/10 px-4 py-2.5 rounded-lg text-sm transition-all">Courts</a>
                <a href="#membership" class="text-white/70 hover:text-white hover:bg-white/10 px-4 py-2.5 rounded-lg text-sm transition-all">Membership</a>
                @guest
                    <div class="flex gap-2 pt-2 border-t border-white/10 mt-1">
                        <a href="{{ route('login') }}" class="flex-1 text-center text-white/70 border border-white/20 px-4 py-2.5 rounded-lg text-sm font-semibold" wire:navigate>Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-court-blue text-white px-4 py-2.5 rounded-lg text-sm font-bold" wire:navigate>Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="/images/padel_hero_bg.jpg" alt="Lapangan Padel" class="w-full h-full object-cover object-center" style="filter: brightness(0.65) saturate(1.05);">
            <div class="absolute inset-0 bg-gradient-to-r from-midnight/80 via-midnight/50 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-midnight/60 via-transparent to-midnight/20"></div>
            <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-court-blue/20 rounded-full blur-[160px] pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-8 pt-28 pb-20">
            <div class="max-w-2xl animate-float-up">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-court-blue/25 border border-court-blue/40 text-blue-200 font-semibold text-xs uppercase tracking-wider mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-ball-yellow animate-pulse"></span>
                    Platform Booking Padel No.1
                </span>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.04] font-heading mb-6">
                    Game On.<br>
                    <span class="text-ball-yellow">Padel Your Way.</span>
                </h1>

                <p class="text-base sm:text-lg text-white/70 max-w-lg leading-relaxed mb-8">
                    Modern courts, panoramic glass walls, and premium turf — book your favorite court in seconds and play at your best.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('courts.index') }}" wire:navigate
                        class="inline-flex items-center gap-2.5 bg-court-blue hover:bg-court-blue-dark text-white font-bold px-7 py-3.5 rounded-xl text-base font-heading transition-all shadow-xl shadow-court-blue/30">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Booking Sekarang
                    </a>

                    <a href="#courts"
                        class="inline-flex items-center gap-2 text-white/70 hover:text-white border border-white/20 hover:border-white/40 px-6 py-3.5 rounded-xl text-sm font-semibold transition-all">
                        Lihat Lapangan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                </div>

                <div class="flex items-center gap-6 mt-10 pt-8 border-t border-white/10">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-extrabold text-white font-heading">12+</span>
                        <span class="text-xs text-white/50">Lapangan<br>Premium</span>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-extrabold text-white font-heading">367+</span>
                        <span class="text-xs text-white/50">Member<br>Aktif</span>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-extrabold text-white font-heading">4.8</span>
                        <span class="text-xs text-white/50">Rating<br>Ulasan</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2">
            <span class="text-xs text-white/40 uppercase tracking-widest">Scroll</span>
            <div class="w-px h-8 bg-gradient-to-b from-white/30 to-transparent"></div>
        </div>
    </section>

    <section id="courts" class="py-24 bg-white dark:bg-midnight">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-court-blue-light dark:bg-court-blue/20 text-court-blue dark:text-ball-yellow font-bold text-xs uppercase tracking-wider border border-court-blue/20 dark:border-ball-yellow/30 mb-4">
                        Our Courts
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white font-heading">Pilih Lapangan Favoritmu</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-base">Dari indoor premium hingga outdoor panoramic, semua siap untuk permainanmu.</p>
                </div>
                <a href="{{ route('courts.index') }}" wire:navigate class="hidden sm:flex items-center gap-2 text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow font-bold text-sm transition-colors">
                    Lihat Semua Lapangan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $courtPhotos = [
                        ['name' => 'Indoor Pro', 'price' => 'Rp 200K', 'desc' => 'Karpet WPT, LED, AC', 'img' => '/images/indoor.avif', 'available' => true],
                        ['name' => 'Panoramic Glass', 'price' => 'Rp 250K', 'desc' => 'Dinding kaca, rooftop view', 'img' => '/images/panoramic.avif', 'available' => true],
                        ['name' => 'Twilight Outdoor', 'price' => 'Rp 180K', 'desc' => 'Bermain di bawah lampu', 'img' => '/images/outdoor.avif', 'available' => true],
                        ['name' => 'Premium Glass', 'price' => 'Rp 300K', 'desc' => 'VIP court, 360° kaca', 'img' => '/images/vip.avif', 'available' => false],
                    ];
                @endphp
                @foreach ($courtPhotos as $i => $court)
                    <a href="{{ route('courts.index') }}" wire:navigate class="group relative rounded-2xl overflow-hidden bg-gray-100 dark:bg-slate-dark aspect-[4/5] block">
                        <img src="{{ $court['img'] }}" alt="{{ $court['name'] }}" class="w-full h-full object-cover transition-all duration-700 {{ $court['available'] ? 'group-hover:scale-105' : 'blur-md grayscale group-hover:blur-sm group-hover:grayscale-[50%]' }}" loading="{{ $i < 2 ? 'eager' : 'lazy' }}">
                        @if (!$court['available'])
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                            <div class="w-16 h-16 rounded-2xl bg-black/30 backdrop-blur-md border border-white/20 text-white/70 flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-white text-lg font-heading">{{ $court['name'] }}</h3>
                                @if ($court['available'])
                                    <span class="text-xs font-bold text-emerald-400 bg-emerald-500/20 px-2.5 py-0.5 rounded-full">Tersedia</span>
                                @else
                                    <span class="text-xs font-bold text-amber-400 bg-amber-500/20 px-2.5 py-0.5 rounded-full">Coming Soon</span>
                                @endif
                            </div>
                            <p class="text-sm text-white/60">{{ $court['desc'] }}</p>
                            <p class="text-xl font-extrabold text-white mt-2 font-heading">{{ $court['price'] }} <span class="text-sm font-normal text-white/40">/jam</span></p>
                        </div>
                        <div class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-white/20 backdrop-blur-sm text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('courts.index') }}" wire:navigate class="inline-flex items-center gap-2 text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow font-bold text-sm transition-colors">
                    Lihat Semua Lapangan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <section class="py-24 bg-sand dark:bg-midnight border-t border-gray-200 dark:border-slate-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-court-blue-light dark:bg-court-blue/20 text-court-blue dark:text-ball-yellow font-bold text-xs uppercase tracking-wider border border-court-blue/20 dark:border-ball-yellow/30 mb-4">
                    Cara Booking
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white font-heading">3 Langkah Mudah Main Padel</h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto mt-2 text-base">Tanpa ribet, langsung bermain.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Pilih Lapangan', 'desc' => 'Lihat galeri lapangan, bandingkan harga, dan pilih yang paling cocok untuk gaya bermainmu.', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
                        ['num' => '02', 'title' => 'Pilih Jadwal', 'desc' => 'Tentukan tanggal dan jam main. Bisa booking 1-3 jam berturut-turut sesuai kebutuhan.', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['num' => '03', 'title' => 'Bayar & Main', 'desc' => 'Upload bukti pembayaran, dapatkan konfirmasi instan, dan datang untuk bermain!', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl bg-court-blue text-white flex items-center justify-center mx-auto mb-5">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                        </div>
                        <div class="text-5xl font-black text-court-blue/15 dark:text-court-blue/30 font-heading -mt-12 mb-4">{{ $step['num'] }}</div>
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white font-heading mb-2">{{ $step['title'] }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-xs mx-auto">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="membership" class="relative py-24 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1800&q=80" alt="" class="w-full h-full object-cover" style="filter: brightness(0.35) saturate(1.1);">
            <div class="absolute inset-0 bg-gradient-to-r from-midnight/85 via-midnight/70 to-midnight/85"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-court-blue/15 rounded-full blur-[180px] pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-ball-yellow/20 border border-ball-yellow/30 text-ball-yellow font-bold text-xs uppercase tracking-wider mb-5">
                Bergabung Sekarang
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white font-heading mb-4">Siap untuk Main?</h2>
            <p class="text-white/60 max-w-lg mx-auto text-base mb-8">Daftar gratis dan mulai booking lapangan padel favoritmu dalam hitungan detik.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" wire:navigate class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-8 py-4 rounded-xl text-base font-heading transition-all shadow-xl shadow-court-blue/30">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('courts.index') }}" wire:navigate class="text-white/70 hover:text-white border border-white/20 hover:border-white/40 px-8 py-4 rounded-xl text-base font-semibold transition-all">
                        Lihat Lapangan
                    </a>
                @else
                    <a href="{{ route('bookings.create') }}" wire:navigate class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-8 py-4 rounded-xl text-base font-heading transition-all">
                        Booking Sekarang
                    </a>
                @endguest
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FOOTER
    ══════════════════════════════════════ --}}
    <footer class="border-t border-gray-200 dark:border-slate-dark bg-white dark:bg-midnight">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mb-10">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-court-blue text-white">
                            <x-app-logo-icon class="w-5 h-5" />
                        </span>
                        <span class="font-bold text-lg text-gray-900 dark:text-white font-heading">PadelSpot</span>
                    </div>
                    <p class="text-sm text-gray-400 dark:text-gray-500 leading-relaxed max-w-xs">Platform booking lapangan padel terbaik dengan sistem pemesanan online yang cepat, aman, dan terpercaya.</p>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Navigasi</h4>
                    <nav class="flex flex-col gap-2.5">
                        <a href="{{ route('home') }}" class="text-sm text-gray-400 dark:text-gray-500 hover:text-court-blue dark:hover:text-ball-yellow transition-colors">Beranda</a>
                        <a href="{{ route('courts.index') }}" wire:navigate class="text-sm text-gray-400 dark:text-gray-500 hover:text-court-blue dark:hover:text-ball-yellow transition-colors">Lapangan</a>
                        <a href="#membership" class="text-sm text-gray-400 dark:text-gray-500 hover:text-court-blue dark:hover:text-ball-yellow transition-colors">Membership</a>
                    </nav>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Kontak</h4>
                    <nav class="flex flex-col gap-2.5">
                        <a href="tel:+6281234567890" class="text-sm text-gray-400 dark:text-gray-500 hover:text-court-blue dark:hover:text-ball-yellow transition-colors flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +62 812-3456-7890
                        </a>
                        <a href="mailto:info@padelspot.com" class="text-sm text-gray-400 dark:text-gray-500 hover:text-court-blue dark:hover:text-ball-yellow transition-colors flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@padelspot.com
                        </a>
                    </nav>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-slate-dark pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-400 dark:text-gray-500">&copy; {{ date('Y') }} PadelSpot. All rights reserved.</div>
                <div class="flex items-center gap-4 text-sm text-gray-400 dark:text-gray-500">
                    <span class="hover:text-gray-600 dark:hover:text-gray-300 transition-colors cursor-default">Privacy Policy</span>
                    <span class="hover:text-gray-600 dark:hover:text-gray-300 transition-colors cursor-default">Terms of Service</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn  = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', () => menu.classList.toggle('hidden'));
            }
        });
    </script>

</body>
</html>
