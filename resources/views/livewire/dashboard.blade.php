@php use App\Enums\BookingStatus; use App\Enums\PaymentStatus; @endphp

<div class="page-bg p-6 lg:p-8">

    {{-- ══════════════════════════════════════
         WELCOME BANNER
    ══════════════════════════════════════ --}}
    @php
        $hour = now()->hour;
        if ($hour < 12) $greeting = 'Selamat Pagi';
        elseif ($hour < 16) $greeting = 'Selamat Siang';
        elseif ($hour < 19) $greeting = 'Selamat Sore';
        else $greeting = 'Selamat Malam';
    @endphp

    <div class="mb-8 rounded-2xl bg-gradient-to-br from-court-blue to-[#003d80] p-6 lg:p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/3 pointer-events-none"></div>
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1.5px, transparent 0); background-size: 24px 24px;"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="text-court-blue/20 dark:text-white/20 font-bold text-xs uppercase tracking-widest mb-1">
                        {{ auth()->user()->isAdmin() ? 'Admin Panel' : 'My Account' }}
                    </p>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-white font-heading leading-tight">
                        {{ $greeting }}, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-white/70 mt-1.5 text-sm">
                        @if (auth()->user()->isAdmin())
                            Kelola lapangan, booking, dan pantau aktivitas seluruh pemain dengan mudah.
                        @else
                            @if ($stats['activeBookings'] > 0)
                                Kamu memiliki <span class="font-bold text-white">{{ $stats['activeBookings'] }} booking aktif</span> — jangan sampai terlewat!
                            @else
                                Belum ada jadwal hari ini. Yuk, booking lapangan sekarang!
                            @endif
                        @endif
                    </p>
                </div>
                @if (!auth()->user()->isAdmin())
                    <a href="{{ route('courts.index') }}" wire:navigate
                        class="inline-flex items-center gap-2 bg-ball-yellow text-midnight hover:bg-ball-yellow-dark font-bold px-6 py-3 rounded-xl transition-all text-sm font-heading shrink-0 shadow-lg shadow-black/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Booking Sekarang
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         ADMIN DASHBOARD
    ══════════════════════════════════════ --}}
    @if (auth()->user()->isAdmin())

        {{-- ── DECORATIVE DIVIDER ── --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Ringkasan</span>
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            @php
                $adminStats = [
                    ['label' => 'Total Booking', 'value' => $stats['totalBookings'], 'color' => 'text-court-blue', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'bg' => 'bg-court-blue/10'],
                    ['label' => 'Menunggu Bayar', 'value' => $stats['pendingPayments'], 'color' => 'text-amber-500', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-amber-500/10'],
                    ['label' => 'Total Revenue', 'value' => 'Rp ' . number_format($stats['totalRevenue'], 0, ',', '.'), 'color' => 'text-court-green', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-court-green/10'],
                    ['label' => 'Lapangan', 'value' => $stats['totalCourts'], 'color' => 'text-sky-500', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'bg' => 'bg-sky-500/10'],
                    ['label' => 'Pelanggan', 'value' => $stats['totalUsers'], 'color' => 'text-purple-500', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'bg' => 'bg-purple-500/10'],
                ];
            @endphp

            @foreach ($adminStats as $stat)
                <div class="card-flat p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg {{ $stat['bg'] }} {{ $stat['color'] }}">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Recent Bookings Table --}}
        <div class="card-flat overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-dark flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-court-blue"></span>
                    <h2 class="font-bold text-gray-900 dark:text-white font-heading">Booking Terbaru</h2>
                </div>
                <a href="{{ route('admin.bookings.index') }}" wire:navigate class="text-sm font-bold text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow transition-colors">
                    Lihat Semua →
                </a>
            </div>

            @if ($recentBookings->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="table-header-flat">
                            <tr>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentBookings as $booking)
                                <tr class="table-row-flat">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-8 h-8 rounded-lg bg-court-blue/10 text-court-blue font-bold text-xs flex items-center justify-center font-heading">
                                                {{ strtoupper(substr($booking->user->name, 0, 2)) }}
                                            </span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $booking->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->court->name }}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if ($booking->status === BookingStatus::Pending)
                                            <span class="badge-pending px-3 py-1 text-xs font-bold rounded-full">Menunggu</span>
                                        @elseif ($booking->status === BookingStatus::Confirmed)
                                            <span class="badge-confirmed px-3 py-1 text-xs font-bold rounded-full">Dikonfirmasi</span>
                                        @elseif ($booking->status === BookingStatus::Cancelled)
                                            <span class="badge-cancelled px-3 py-1 text-xs font-bold rounded-full">Dibatalkan</span>
                                        @elseif ($booking->status === BookingStatus::Completed)
                                            <span class="badge-completed px-3 py-1 text-xs font-bold rounded-full">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-gray-400 dark:text-gray-500">Belum ada booking terbaru.</p>
                </div>
            @endif
        </div>

    {{-- ══════════════════════════════════════
         CUSTOMER DASHBOARD
    ══════════════════════════════════════ --}}
    @else
        {{-- ── DECORATIVE DIVIDER ── --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Ringkasan</span>
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="card-flat p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Booking</span>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading mt-1">{{ $stats['totalBookings'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-court-blue/10 text-court-blue">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> {{ $stats['completedBookings'] }} selesai</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-court-blue"></span> {{ $stats['activeBookings'] }} aktif</span>
                </div>
            </div>

            <div class="card-flat p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Aktif / Menunggu</span>
                        <p class="text-3xl font-extrabold text-court-blue font-heading mt-1">{{ $stats['activeBookings'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-court-blue/10 text-court-blue">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                    @if ($stats['pendingBookings'] > 0)
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> {{ $stats['pendingBookings'] }} menunggu bayar</span>
                    @endif
                    @if ($stats['confirmedBookings'] > 0)
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> {{ $stats['confirmedBookings'] }} dikonfirmasi</span>
                    @endif
                </div>
            </div>

            <div class="card-flat p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Selesai</span>
                        <p class="text-3xl font-extrabold text-court-green font-heading mt-1">{{ $stats['completedBookings'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-court-green/10 text-court-green">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-500">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-court-green"></span> Permainan selesai</span>
                </div>
            </div>
        </div>

        {{-- ── DECORATIVE DIVIDER ── --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Aksi Cepat</span>
            <div class="h-px flex-1 bg-gray-200 dark:bg-slate-dark"></div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('bookings.create') }}" wire:navigate
                class="card-flat p-6 block transition-all hover:border-court-blue/40 hover:bg-white dark:hover:bg-slate-dark/60">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-court-blue text-white flex items-center justify-center shrink-0 shadow-sm shadow-court-blue/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white font-heading">Booking Lapangan</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Pilih lapangan favorit dan waktu bermain kamu</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 shrink-0 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>

            <a href="{{ route('bookings.index') }}" wire:navigate
                class="card-flat p-6 block transition-all hover:border-gray-400/40 hover:bg-white dark:hover:bg-slate-dark/60">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-slate-dark text-gray-400 dark:text-gray-500 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white font-heading">Riwayat Booking</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Lihat status dan detail seluruh pemesanan kamu</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-600 shrink-0 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>

        {{-- Recent Bookings --}}
        <div class="card-flat overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-dark flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-court-blue"></span>
                    <h2 class="font-bold text-gray-900 dark:text-white font-heading">Booking Terbaru</h2>
                </div>
                <a href="{{ route('bookings.index') }}" wire:navigate class="text-sm font-bold text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow transition-colors">
                    Lihat Semua →
                </a>
            </div>

            @if ($recentBookings->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="table-header-flat">
                            <tr>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jam</th>
                                <th class="text-left px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="text-right px-6 py-3.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentBookings as $booking)
                                <tr class="table-row-flat">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-2 h-2 rounded-full @if($booking->status === BookingStatus::Pending) bg-amber-400 @elseif($booking->status === BookingStatus::Confirmed) bg-emerald-400 @elseif($booking->status === BookingStatus::Cancelled) bg-red-400 @else bg-gray-400 @endif shrink-0"></span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $booking->court->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->timeSlots->pluck('label')->implode(', ') }}</td>
                                    <td class="px-6 py-4">
                                        @if ($booking->status === BookingStatus::Pending)
                                            <span class="badge-pending px-3 py-1 text-xs font-bold rounded-full">Menunggu</span>
                                        @elseif ($booking->status === BookingStatus::Confirmed)
                                            <span class="badge-confirmed px-3 py-1 text-xs font-bold rounded-full">Dikonfirmasi</span>
                                        @elseif ($booking->status === BookingStatus::Cancelled)
                                            <span class="badge-cancelled px-3 py-1 text-xs font-bold rounded-full">Dibatalkan</span>
                                        @elseif ($booking->status === BookingStatus::Completed)
                                            <span class="badge-completed px-3 py-1 text-xs font-bold rounded-full">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-900 dark:text-white font-heading">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium mb-5">Belum ada pemesanan terbaru.</p>
                    <a href="{{ route('courts.index') }}" wire:navigate
                        class="inline-flex items-center gap-2 bg-court-blue hover:bg-court-blue-dark text-white font-bold px-6 py-3 rounded-xl transition-all font-heading text-sm shadow-sm shadow-court-blue/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Mulai Booking Sekarang!
                    </a>
                </div>
            @endif
        </div>
    @endif

</div>
