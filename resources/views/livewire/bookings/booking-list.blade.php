<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Booking Saya</h1>
        <p class="text-zinc-600 dark:text-zinc-400 mt-1">Kelola semua pemesanan Anda</p>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-zinc-500 mb-1">Cari Lapangan</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nama lapangan..."
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 text-sm">
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-zinc-500 mb-1">Status</label>
                <select wire:model.live="status" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 text-sm">
                    <option value="">Semua</option>
                    <option value="pending">Menunggu</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-zinc-500 mb-1">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 text-sm">
            </div>
            <div class="w-40">
                <label class="block text-xs font-medium text-zinc-500 mb-1">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 text-sm">
            </div>
            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <button wire:click="resetFilters" class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white border border-zinc-200 dark:border-zinc-600 rounded-lg">
                    Reset
                </button>
            @endif
        </div>
    </div>

    @if ($bookings->count())
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Lapangan</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Tanggal</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Jam</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Total</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($bookings as $booking)
                            <tr>
                                <td class="px-6 py-3 font-medium text-zinc-900 dark:text-white">{{ $booking->court->name }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->timeSlot->label }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
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
                                <td class="px-6 py-3">
                                    <flux:link :href="route('bookings.show', $booking->id)" class="text-sm text-green-600 hover:text-green-700" wire:navigate>
                                        Detail
                                    </flux:link>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-12 text-center">
            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <p class="text-zinc-500 mb-4">Tidak ada booking ditemukan.</p>
                <button wire:click="resetFilters" class="text-sm text-green-600 hover:text-green-700">Reset Filter</button>
            @else
                <p class="text-zinc-500 mb-4">Belum ada booking.</p>
                <flux:link :href="route('courts.index')" variant="primary" wire:navigate>
                    Booking Sekarang
                </flux:link>
            @endif
        </div>
    @endif
</div>
