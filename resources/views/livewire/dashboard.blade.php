<div>
    <div class="p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">
                {{ auth()->user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard' }}
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">
                Selamat datang, {{ auth()->user()->name }}.
            </p>
        </div>

        {{-- Admin Dashboard --}}
        @if (auth()->user()->isAdmin())
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Total Booking</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['totalBookings'] }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Menunggu Bayar</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pendingPayments'] }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Lapangan</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['totalCourts'] }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Pelanggan</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>

            {{-- Recent Bookings --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-700 flex items-center justify-between">
                    <h2 class="font-bold text-lg text-zinc-900 dark:text-white">Booking Terbaru</h2>
                    <flux:link :href="route('admin.bookings.index')" class="text-sm text-green-600 hover:text-green-700 font-medium" wire:navigate>
                        Lihat Semua
                    </flux:link>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                <tr>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Pelanggan</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Lapangan</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Tanggal</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach ($recentBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-3 font-medium text-zinc-900 dark:text-white">{{ $booking->user->name }}</td>
                                        <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3">
                                            @if ($booking->status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu</span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Dikonfirmasi</span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Dibatalkan</span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 text-center text-zinc-500">Belum ada booking.</div>
                @endif
            </div>

        {{-- Customer Dashboard --}}
        @else
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Total Booking</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['totalBookings'] }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Booking Aktif</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['activeBookings'] }}</p>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
                    <p class="text-sm text-zinc-500">Selesai</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['completedBookings'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                <flux:link :href="route('courts.index')" variant="primary" class="rounded-xl p-6 hover:bg-green-700 transition text-center" wire:navigate>
                    <p class="text-lg font-bold">Booking Lapangan</p>
                    <p class="text-sm opacity-80 mt-1">Pilih lapangan dan pesan sekarang</p>
                </flux:link>
                <flux:link :href="route('bookings.index')" class="rounded-xl p-6 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition text-center" wire:navigate>
                    <p class="text-lg font-bold">Riwayat Booking</p>
                    <p class="text-sm text-zinc-500 mt-1">Lihat semua pemesanan Anda</p>
                </flux:link>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-700 flex items-center justify-between">
                    <h2 class="font-bold text-lg text-zinc-900 dark:text-white">Booking Terbaru</h2>
                    <flux:link :href="route('bookings.index')" class="text-sm text-green-600 hover:text-green-700 font-medium" wire:navigate>
                        Lihat Semua
                    </flux:link>
                </div>
                @if ($recentBookings->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                <tr>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Lapangan</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Tanggal</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Jam</th>
                                    <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                                @foreach ($recentBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-3 font-medium text-zinc-900 dark:text-white">{{ $booking->court->name }}</td>
                                        <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                        <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->timeSlot->label }}</td>
                                        <td class="px-6 py-3">
                                            @if ($booking->status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu</span>
                                            @elseif ($booking->status === 'confirmed')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Dikonfirmasi</span>
                                            @elseif ($booking->status === 'cancelled')
                                                <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Dibatalkan</span>
                                            @elseif ($booking->status === 'completed')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 text-center text-zinc-500">Belum ada booking.
                        <flux:link :href="route('courts.index')" class="text-green-600 hover:text-green-700" wire:navigate>Booking sekarang!</flux:link>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
