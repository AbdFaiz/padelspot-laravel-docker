<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Kelola Booking</h1>
        <p class="text-zinc-600 dark:text-zinc-400 mt-1">Kelola semua pemesanan pelanggan</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
        <button wire:click="$set('status', '')" class="bg-white dark:bg-zinc-800 rounded-xl border {{ $status === '' ? 'border-green-500' : 'border-zinc-200 dark:border-zinc-700' }} p-4 text-left">
            <p class="text-sm text-zinc-500">Total</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['total'] }}</p>
        </button>
        <button wire:click="$set('status', 'pending')" class="bg-white dark:bg-zinc-800 rounded-xl border {{ $status === 'pending' ? 'border-yellow-500' : 'border-zinc-200 dark:border-zinc-700' }} p-4 text-left">
            <p class="text-sm text-zinc-500">Menunggu</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </button>
        <button wire:click="$set('status', 'confirmed')" class="bg-white dark:bg-zinc-800 rounded-xl border {{ $status === 'confirmed' ? 'border-green-500' : 'border-zinc-200 dark:border-zinc-700' }} p-4 text-left">
            <p class="text-sm text-zinc-500">Dikonfirmasi</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['confirmed'] }}</p>
        </button>
        <button wire:click="$set('status', 'completed')" class="bg-white dark:bg-zinc-800 rounded-xl border {{ $status === 'completed' ? 'border-blue-500' : 'border-zinc-200 dark:border-zinc-700' }} p-4 text-left">
            <p class="text-sm text-zinc-500">Selesai</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['completed'] }}</p>
        </button>
        <button wire:click="$set('status', 'cancelled')" class="bg-white dark:bg-zinc-800 rounded-xl border {{ $status === 'cancelled' ? 'border-red-500' : 'border-zinc-200 dark:border-zinc-700' }} p-4 text-left">
            <p class="text-sm text-zinc-500">Dibatalkan</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
        </button>
    </div>

    <div class="mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama pelanggan atau lapangan..." class="w-full sm:w-96 rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-700">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Pelanggan</th>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Lapangan</th>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Tanggal</th>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Jam</th>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                        <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="px-6 py-3 font-medium text-zinc-900 dark:text-white">{{ $booking->user->name }}</td>
                            <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $booking->court->name }}</td>
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
                            <td class="px-6 py-3">
                                <div class="flex gap-2">
                                    @if ($booking->status === 'pending')
                                        <button wire:click="confirm({{ $booking->id }})" onclick="return confirm('Konfirmasi booking ini?')" class="text-sm text-green-600 hover:text-green-800">
                                            Konfirmasi
                                        </button>
                                    @endif
                                    @if ($booking->status === 'confirmed')
                                        <button wire:click="complete({{ $booking->id }})" onclick="return confirm('Tandai selesai?')" class="text-sm text-blue-600 hover:text-blue-800">
                                            Selesai
                                        </button>
                                    @endif
                                    @if (in_array($booking->status, ['pending', 'confirmed']))
                                        <button wire:click="reject({{ $booking->id }})" onclick="return confirm('Tolak booking ini?')" class="text-sm text-red-600 hover:text-red-800">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                Tidak ada booking ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
