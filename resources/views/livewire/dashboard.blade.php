<div>
    <div class="p-6 lg:p-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-1">
                <div class="h-8 w-1 bg-emerald-500 rounded-full"></div>
                <div>
                    <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard' }}
                    </h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        Selamat datang kembali, {{ auth()->user()->name }}!
                    </p>
                </div>
            </div>
        </div>

        {{-- Admin Dashboard --}}
        @if (auth()->user()->isAdmin())
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Total Booking</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['totalBookings'] }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Menunggu Bayar</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pendingPayments'] }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Total Revenue</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Lapangan</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['totalCourts'] }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Pelanggan</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>

            {{-- Recent Bookings Table --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                    <h2 class="font-semibold text-neutral-900 dark:text-white">Booking Terbaru</h2>
                    <flux:link :href="route('admin.bookings.index')" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" wire:navigate>
                        Lihat Semua
                    </flux:link>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-100 dark:border-neutral-800">
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Pelanggan</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Lapangan</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Tanggal</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                                @foreach ($recentBookings as $booking)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                                        <td class="px-6 py-3.5 font-medium text-neutral-900 dark:text-white">{{ $booking->user->name }}</td>
                                        <td class="px-6 py-3.5 text-neutral-600 dark:text-neutral-400">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3.5 text-neutral-600 dark:text-neutral-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3.5">
                                            @if ($booking->status === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                                    Menunggu
                                                </span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Dikonfirmasi
                                                </span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Dibatalkan
                                                </span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <div class="flex justify-center mb-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-neutral-100 dark:bg-neutral-800">
                                <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Belum ada booking.</p>
                    </div>
                @endif
            </div>

        {{-- Customer Dashboard --}}
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Total Booking</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $stats['totalBookings'] }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Booking Aktif</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['activeBookings'] }}</p>
                </div>

                <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-neutral-500 uppercase tracking-wide">Selesai</span>
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['completedBookings'] }}</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('bookings.create') }}" wire:navigate class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-700 p-6 block">
                    <div class="relative z-10">
                        <p class="text-lg font-bold text-white">Booking Lapangan</p>
                        <p class="text-sm text-emerald-100 mt-1">Pilih lapangan dan pesan sekarang</p>
                    </div>
                    <div class="absolute -bottom-4 -right-4 opacity-10">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('bookings.index') }}" wire:navigate class="group relative overflow-hidden rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-6 block hover:border-neutral-300 dark:hover:border-neutral-700 transition">
                    <div class="relative z-10">
                        <p class="text-lg font-bold text-neutral-900 dark:text-white">Riwayat Booking</p>
                        <p class="text-sm text-neutral-500 mt-1">Lihat semua pemesanan Anda</p>
                    </div>
                    <div class="absolute -bottom-4 -right-4 opacity-[0.04]">
                        <svg class="w-24 h-24 text-neutral-900 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- Recent Bookings --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                    <h2 class="font-semibold text-neutral-900 dark:text-white">Booking Terbaru</h2>
                    <flux:link :href="route('bookings.index')" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium" wire:navigate>
                        Lihat Semua
                    </flux:link>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-neutral-100 dark:border-neutral-800">
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Lapangan</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Tanggal</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Jam</th>
                                    <th class="text-left px-6 py-3 font-medium text-neutral-500 dark:text-neutral-400">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                                @foreach ($recentBookings as $booking)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition">
                                        <td class="px-6 py-3.5 font-medium text-neutral-900 dark:text-white">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3.5 text-neutral-600 dark:text-neutral-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3.5 text-neutral-600 dark:text-neutral-400">{{ $booking->timeSlot->label }}</td>
                                        <td class="px-6 py-3.5">
                                            @if ($booking->status === 'pending')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                                    Menunggu
                                                </span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Dikonfirmasi
                                                </span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Dibatalkan
                                                </span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-full">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <div class="flex justify-center mb-3">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-neutral-100 dark:bg-neutral-800">
                                <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                        </div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                            Belum ada booking.
                            <flux:link :href="route('bookings.create')" class="text-emerald-600 hover:text-emerald-700 font-medium" wire:navigate>Booking sekarang!</flux:link>
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>