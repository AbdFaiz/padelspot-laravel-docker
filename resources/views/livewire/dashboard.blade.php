<div>
    <div class="p-6 lg:p-8 bg-[#F4F6F9] min-h-screen">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-1">
                <div class="h-8 w-1.5 bg-[#FF6600] rounded-full"></div>
                <div>
                    <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading">
                        {{ auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya' }}
                    </h1>
                    <p class="text-sm text-slate-600">
                        Selamat datang kembali, <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span>!
                    </p>
                </div>
            </div>
        </div>

        {{-- Admin Dashboard --}}
        @if (auth()->user()->isAdmin())
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Booking</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0052CC]/10 text-[#0052CC]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-slate-900 font-heading">{{ $stats['totalBookings'] }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Bayar</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-amber-600 font-heading">{{ $stats['pendingPayments'] }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Revenue</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#FF6600]/10 text-[#FF6600]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-[#FF6600] font-heading">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Lapangan</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0052CC]/10 text-[#0052CC]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-slate-900 font-heading">{{ $stats['totalCourts'] }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-100 text-purple-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-slate-900 font-heading">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>

            {{-- Recent Bookings Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-[#F4F6F9]">
                    <h2 class="font-bold text-slate-900 font-heading text-lg">Booking Terbaru</h2>
                    <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-[#FF6600] hover:text-[#E55C00]" wire:navigate>
                        Lihat Semua →
                    </a>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-500 font-bold uppercase text-xs">
                                    <th class="text-left px-6 py-3">Pelanggan</th>
                                    <th class="text-left px-6 py-3">Lapangan</th>
                                    <th class="text-left px-6 py-3">Tanggal</th>
                                    <th class="text-left px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($recentBookings as $booking)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-3.5 font-bold text-slate-900">{{ $booking->user->name }}</td>
                                        <td class="px-6 py-3.5 text-slate-600">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3.5 text-slate-600">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3.5">
                                            @if ($booking->status === 'pending')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Menunggu</span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Dikonfirmasi</span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Dibatalkan</span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="px-3 py-1 bg-[#0052CC]/15 text-[#0052CC] text-xs font-bold rounded-full">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center text-slate-500">
                        Belum ada booking terbaru.
                    </div>
                @endif
            </div>

        {{-- Customer Dashboard --}}
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Booking</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0052CC]/10 text-[#0052CC]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-slate-900 font-heading">{{ $stats['totalBookings'] }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Booking Aktif</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#FF6600]/10 text-[#FF6600]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-[#FF6600] font-heading">{{ $stats['activeBookings'] }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Selesai</span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0052CC]/10 text-[#0052CC]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-3xl font-extrabold text-[#0052CC] font-heading">{{ $stats['completedBookings'] }}</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('bookings.create') }}" wire:navigate class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#FF6600] to-[#E55C00] p-6 block shadow-lg shadow-orange-500/30 hover:scale-[1.01] transition-transform">
                    <div class="relative z-10">
                        <p class="text-xl font-extrabold text-white font-heading">Booking Lapangan Sekarang</p>
                        <p class="text-sm text-amber-100 mt-1">Pilih lapangan favorit dan waktu bermain Anda</p>
                    </div>
                    <div class="absolute -bottom-4 -right-4 opacity-15">
                        <svg class="w-28 h-28 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('bookings.index') }}" wire:navigate class="group relative overflow-hidden rounded-2xl bg-white border border-slate-200 p-6 block shadow-sm hover:border-[#0052CC] transition">
                    <div class="relative z-10">
                        <p class="text-xl font-extrabold text-slate-900 font-heading">Riwayat Booking Saya</p>
                        <p class="text-sm text-slate-500 mt-1">Lihat status dan detail seluruh pemesanan</p>
                    </div>
                    <div class="absolute -bottom-4 -right-4 opacity-5">
                        <svg class="w-28 h-28 text-[#0052CC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </a>
            </div>

            {{-- Recent Bookings --}}
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-[#F4F6F9]">
                    <h2 class="font-bold text-slate-900 font-heading text-lg">Booking Terbaru</h2>
                    <a href="{{ route('bookings.index') }}" class="text-sm font-bold text-[#FF6600] hover:text-[#E55C00]" wire:navigate>
                        Lihat Semua →
                    </a>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-500 font-bold uppercase text-xs">
                                    <th class="text-left px-6 py-3">Lapangan</th>
                                    <th class="text-left px-6 py-3">Tanggal</th>
                                    <th class="text-left px-6 py-3">Jam</th>
                                    <th class="text-left px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($recentBookings as $booking)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-3.5 font-bold text-slate-900">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3.5 text-slate-600 font-medium">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3.5 text-slate-600 font-medium">{{ $booking->timeSlot->label }}</td>
                                        <td class="px-6 py-3.5">
                                            @if ($booking->status === 'pending')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Menunggu</span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">Dikonfirmasi</span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Dibatalkan</span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="px-3 py-1 bg-[#0052CC]/15 text-[#0052CC] text-xs font-bold rounded-full">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <p class="text-slate-500 mb-4 font-medium">Belum ada pemesanan terbaru.</p>
                        <a href="{{ route('bookings.create') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-6 py-3 rounded-xl shadow-md transition-all inline-block font-heading" wire:navigate>
                            Mulai Booking Sekarang!
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>