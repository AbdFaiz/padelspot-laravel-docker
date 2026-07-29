<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PadelSpot — Main Padel, Mudah Bookingnya</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @fluxAppearance
</head>
<body class="bg-[#F4F6F9] text-slate-900 font-sans antialiased selection:bg-[#FF6600] selection:text-white">

    {{-- Floating Glass Header Navigation --}}
    <header class="fixed top-4 sm:top-6 inset-x-0 z-50 px-4 sm:px-8 max-w-7xl mx-auto">
        <nav class="glass-header rounded-full py-2.5 px-4 sm:px-6 flex items-center justify-between w-full shadow-2xl transition-all">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FF6600] text-white shadow-lg shadow-orange-500/40 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="7" cy="7" r="3" fill="currentColor"/>
                        <circle cx="17" cy="7" r="3" fill="currentColor"/>
                        <circle cx="7" cy="17" r="3" fill="currentColor"/>
                        <circle cx="17" cy="17" r="3" fill="currentColor"/>
                        <path d="M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="font-bold text-xl tracking-tight text-white font-heading">PadelSpot</span>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-1 bg-white/10 p-1 rounded-full border border-white/15">
                <a href="{{ route('home') }}" class="bg-[#FF6600] text-white font-semibold px-5 py-2 rounded-full text-sm shadow-md transition-all">Home</a>
                <a href="#features" class="text-white/90 hover:text-white hover:bg-white/15 px-4 py-2 rounded-full text-sm font-medium transition-all">Features</a>
                <a href="{{ route('courts.index') }}" class="text-white/90 hover:text-white hover:bg-white/15 px-4 py-2 rounded-full text-sm font-medium transition-all" wire:navigate>Courts</a>
                <a href="#about" class="text-white/90 hover:text-white hover:bg-white/15 px-4 py-2 rounded-full text-sm font-medium transition-all">About Us</a>
            </div>

            {{-- Right CTA / Auth --}}
            <div class="flex items-center gap-3">
                <a href="tel:+18005557233" class="hidden sm:flex glass-pill text-white/90 hover:text-white hover:bg-white/20 px-4 py-2 rounded-full text-sm font-medium items-center gap-2 transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-[#FF6600]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 001.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>Contact Us</span>
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-semibold px-5 py-2 rounded-full text-sm shadow-lg shadow-orange-500/30 transition-all" wire:navigate>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="glass-pill text-white hover:bg-white/20 px-4 py-2 rounded-full text-sm font-medium transition-all" wire:navigate>
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-semibold px-5 py-2 rounded-full text-sm shadow-lg shadow-orange-500/30 transition-all" wire:navigate>
                        Daftar
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- Main Hero Section (Electric Court Blue Base) --}}
    <section class="relative min-h-screen pt-28 sm:pt-32 pb-20 px-4 sm:px-8 flex items-center justify-center overflow-hidden bg-[#0052CC]">
        {{-- Background Image & Overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="/images/padel_hero_bg.jpg" alt="Padel Court Background" class="w-full h-full object-cover object-center filter brightness-[0.82] contrast-[1.1] scale-105 transform">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0052CC]/90 via-[#0052CC]/65 to-[#003B99]/85"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#003B99] via-transparent to-[#0052CC]/50"></div>
            <div class="absolute top-1/4 left-10 w-96 h-96 bg-[#FF6600]/25 rounded-full blur-[140px] pointer-events-none"></div>
            <div class="absolute bottom-10 right-10 w-80 h-80 bg-blue-400/20 rounded-full blur-[120px] pointer-events-none"></div>
        </div>

        {{-- Hero Grid Content --}}
        <div class="relative z-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            {{-- Left Column: Visual Storytelling & Copy --}}
            <div class="lg:col-span-7 text-left space-y-8">
                <div class="space-y-4">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#FF6600]/20 border border-[#FF6600]/40 text-[#FF6600] font-semibold text-xs uppercase tracking-wider backdrop-blur-md">
                        🏓 Platform Booking Padel No. 1
                    </span>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.05] drop-shadow-lg font-heading">
                        Game On.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-amber-100 to-[#FF6600]">Padel Your Way.</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-white/90 max-w-xl leading-relaxed drop-shadow-sm font-normal">
                        Lapangan modern, desain dinamis, dan sistem pemesanan tercepat yang dibangun khusus untuk pecinta olahraga padel.
                    </p>
                </div>

                {{-- Action Bar: Explore Facilities CTA + Active Members Badge --}}
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 pt-2">
                    <a href="{{ route('courts.index') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white rounded-full px-7 py-4 font-bold flex items-center gap-3 shadow-xl shadow-orange-600/40 group hover:scale-105 transition-all text-base font-heading" wire:navigate>
                        <span class="w-8 h-8 rounded-full bg-white text-[#FF6600] flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </span>
                        <span>Mulai Booking Lapangan</span>
                    </a>

                    {{-- Members Avatar Stack Badge --}}
                    <div class="glass-pill rounded-full py-2.5 px-4 flex items-center gap-3 shadow-lg">
                        <div class="flex -space-x-2 overflow-hidden">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white/40 object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Member 1">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white/40 object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Member 2">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white/40 object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80" alt="Member 3">
                            <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white/40 object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80" alt="Member 4">
                        </div>
                        <span class="text-sm font-semibold text-white/95">367+ Pemain Aktif</span>
                    </div>
                </div>
            </div>

            {{-- Right Column: Interactive Glassmorphism Booking Card --}}
            <div class="lg:col-span-5 w-full flex justify-center lg:justify-end">
                <div class="glass-card rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden backdrop-blur-2xl shadow-2xl border border-white/25 max-w-md w-full transition-all hover:border-[#FF6600]/50">
                    <h2 class="text-2xl font-bold tracking-tight text-white mb-6 font-heading">
                        Cari Lapangan Padel
                    </h2>

                    <form action="{{ route('courts.index') }}" method="GET" class="space-y-4" id="heroBookingForm">
                        {{-- Location Field --}}
                        <div>
                            <label class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-1.5 block">Lokasi Padel</label>
                            <div class="relative">
                                <select name="location" class="glass-input rounded-xl px-4 py-3 text-sm w-full font-medium appearance-none cursor-pointer pr-10">
                                    <option value="central">PadelSpot Central Arena</option>
                                    <option value="west-club">PadelSpot West Club</option>
                                    <option value="south-park">PadelSpot South Park</option>
                                </select>
                                <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-white/70">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Court Type Field --}}
                        <div>
                            <label class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-1.5 block">Tipe Lapangan</label>
                            <div class="relative">
                                <select name="type" id="courtTypeSelect" class="glass-input rounded-xl px-4 py-3 text-sm w-full font-medium appearance-none cursor-pointer pr-10">
                                    <option value="all">Semua Tipe (Indoor, Outdoor, Pro)</option>
                                    <option value="indoor">Indoor Panoramic Glass Court</option>
                                    <option value="outdoor">Outdoor Sunset Court</option>
                                    <option value="pro">Pro Championship Hard Court</option>
                                </select>
                                <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-white/70">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Date & Time Fields (2-Columns) --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-1.5 block">Tanggal</label>
                                <div class="relative">
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="glass-input rounded-xl px-3 py-3 text-sm w-full font-medium cursor-pointer pr-9 text-white">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/70">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-1.5 block">Jam</label>
                                <div class="relative">
                                    <select name="time" class="glass-input rounded-xl px-3 py-3 text-sm w-full font-medium appearance-none cursor-pointer pr-8">
                                        <option value="16:00">16:00 WIB</option>
                                        <option value="17:00">17:00 WIB</option>
                                        <option value="18:00" selected>18:00 WIB</option>
                                        <option value="19:00">19:00 WIB</option>
                                        <option value="20:00">20:00 WIB</option>
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-white/70">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Duration Field --}}
                        <div>
                            <label class="text-xs font-semibold text-white/90 uppercase tracking-wider mb-1.5 block">Durasi</label>
                            <div class="relative">
                                <select name="duration" id="durationSelect" class="glass-input rounded-xl px-4 py-3 text-sm w-full font-medium appearance-none cursor-pointer pr-10">
                                    <option value="60">60 Menit (1 Jam)</option>
                                    <option value="90">90 Menit (1.5 Jam)</option>
                                    <option value="120">120 Menit (2 Jam)</option>
                                </select>
                                <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-white/70">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Dynamic Rate Preview Badge --}}
                        <div class="pt-1 pb-1 flex items-center justify-between text-xs text-white/90 font-medium">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span id="availabilityBadge">4 Lapangan Tersedia</span>
                            </span>
                            <span id="priceBadge" class="font-bold text-[#FF6600] text-sm">Rp 150.000 / jam</span>
                        </div>

                        {{-- Submit Button (Neon Orange CTA) --}}
                        <button type="submit" class="w-full bg-[#FF6600] hover:bg-[#E55C00] active:scale-[0.98] text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-orange-600/40 hover:shadow-orange-500/60 transition-all text-center cursor-pointer flex items-center justify-center gap-2 font-heading text-base">
                            <span>Pilih Lapangan & Lanjut</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    {{-- Stats Section (Light Gray Section Divider) --}}
    <section class="relative -mt-16 z-20 px-6 pb-16">
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-lg flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center font-bold text-2xl">
                    3+
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 font-heading">Lapangan Premium</div>
                    <div class="text-sm text-slate-600">Indoor & Outdoor View</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-lg flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#FF6600]/10 text-[#FF6600] flex items-center justify-center font-bold text-2xl">
                    14
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 font-heading">Jam Operasional</div>
                    <div class="text-sm text-slate-600">08:00 - 22:00 WIB</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-lg flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center font-bold text-2xl">
                    24/7
                </div>
                <div>
                    <div class="text-2xl font-bold text-slate-900 font-heading">Instant Booking</div>
                    <div class="text-sm text-slate-600">Sistem Otomatis & Aman</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section (Light Gray Background) --}}
    <section id="features" class="py-20 px-6 bg-[#F4F6F9]">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 space-y-3">
                <span class="text-xs font-bold text-[#FF6600] uppercase tracking-wider">Keunggulan Platform</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading">
                    Kenapa Memilih PadelSpot?
                </h2>
                <p class="text-slate-600 max-w-xl mx-auto text-base">
                    Kemudahan booking, fleksibilitas jadwal, dan kenyamanan bermain dalam satu platform.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center mb-4 group-hover:bg-[#FF6600] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2 font-heading">Booking Cepat</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Pilih jadwal dan waktu bermain secara gratis & transparan dalam beberapa klik.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center mb-4 group-hover:bg-[#FF6600] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2 font-heading">Pembayaran Praktis</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Dukungan upload bukti bayar atau konfirmasi langsung dengan verifikasi instant.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center mb-4 group-hover:bg-[#FF6600] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2 font-heading">Standar Internasional</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Karpet rumput sintetis resmi World Padel Tour dan pencahayaan LED anti-glare.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center mb-4 group-hover:bg-[#FF6600] group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2 font-heading">Komunitas Ramah</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Bergabung bersama ribuan pemain dari pemula hingga profesional di kota Anda.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#003B99] text-white py-12 px-6 border-t border-[#0052CC]">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 text-center sm:text-left">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#FF6600] text-white font-bold">PS</span>
                <span class="font-bold text-xl tracking-tight text-white font-heading">PadelSpot</span>
            </div>
            <div class="text-sm text-white/80">
                © {{ date('Y') }} PadelSpot. Electric Court Blue & Neon Orange Identity.
            </div>
        </div>
    </footer>

    {{-- Interactive Form Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const durationSelect = document.getElementById('durationSelect');
            const courtTypeSelect = document.getElementById('courtTypeSelect');
            const priceBadge = document.getElementById('priceBadge');
            const availabilityBadge = document.getElementById('availabilityBadge');

            function updatePricing() {
                const duration = parseInt(durationSelect.value) || 60;
                const baseRate = courtTypeSelect.value === 'pro' ? 200000 : 150000;
                const totalPrice = (baseRate * (duration / 60)).toLocaleString('id-ID');
                priceBadge.textContent = `Rp ${totalPrice}`;

                if (courtTypeSelect.value === 'indoor') {
                    availabilityBadge.textContent = '2 Lapangan Tersedia';
                } else if (courtTypeSelect.value === 'outdoor') {
                    availabilityBadge.textContent = '3 Lapangan Tersedia';
                } else {
                    availabilityBadge.textContent = '4 Lapangan Tersedia';
                }
            }

            durationSelect.addEventListener('change', updatePricing);
            courtTypeSelect.addEventListener('change', updatePricing);
        });
    </script>
</body>
</html>