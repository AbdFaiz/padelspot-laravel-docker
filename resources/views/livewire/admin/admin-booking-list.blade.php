@php use App\Enums\BookingStatus; @endphp

<div class="page-bg p-6 lg:p-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">Kelola Booking</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola semua pemesanan pelanggan</p>
    </div>

    {{-- Quick Stats / Filter Tabs --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-8">
        <button wire:click="$set('status', '')"
            class="card-flat p-4 text-left transition-all {{ $status === '' ? 'border-blue-500/50 bg-blue-500/10' : '' }} cursor-pointer">
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total</p>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading mt-1">{{ $stats['total'] }}</p>
        </button>
        <button wire:click="$set('status', 'pending')"
            class="card-flat p-4 text-left transition-all {{ $status === 'pending' ? 'border-amber-500/50 bg-amber-500/10' : '' }} cursor-pointer">
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Menunggu</p>
            <p class="text-2xl font-extrabold text-amber-400 font-heading mt-1">{{ $stats['pending'] }}</p>
        </button>
        <button wire:click="$set('status', 'confirmed')"
            class="card-flat p-4 text-left transition-all {{ $status === 'confirmed' ? 'border-emerald-500/50 bg-emerald-500/10' : '' }} cursor-pointer">
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Dikonfirmasi</p>
            <p class="text-2xl font-extrabold text-emerald-400 font-heading mt-1">{{ $stats['confirmed'] }}</p>
        </button>
        <button wire:click="$set('status', 'completed')"
            class="card-flat p-4 text-left transition-all {{ $status === 'completed' ? 'border-blue-500/50 bg-blue-500/10' : '' }} cursor-pointer">
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Selesai</p>
            <p class="text-2xl font-extrabold text-court-blue font-heading mt-1">{{ $stats['completed'] }}</p>
        </button>
        <button wire:click="$set('status', 'cancelled')"
            class="card-flat p-4 text-left transition-all {{ $status === 'cancelled' ? 'border-red-500/50 bg-red-500/10' : '' }} cursor-pointer">
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Dibatalkan</p>
            <p class="text-2xl font-extrabold text-red-400 font-heading mt-1">{{ $stats['cancelled'] }}</p>
        </button>
    </div>

    {{-- Search --}}
    <div class="mb-5">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Cari nama pelanggan atau lapangan..."
            class="input-flat w-full sm:w-96">
    </div>

    {{-- Booking Table --}}
    <div class="card-flat overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="table-header-flat">
                    <tr>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jam</th>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="table-row-flat">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->court->name }}</td>
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
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" wire:navigate
                                        class="text-sm font-bold text-court-blue hover:text-gray-900 dark:hover:text-gray-900 dark:hover:text-white transition-colors">
                                        Detail
                                    </a>
                                    @if ($booking->status === BookingStatus::Pending)
                                        <button wire:click="confirm({{ $booking->id }})" onclick="return confirm('Konfirmasi booking ini?')"
                                            class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition-colors cursor-pointer">
                                            Konfirmasi
                                        </button>
                                    @endif
                                    @if ($booking->status === BookingStatus::Confirmed)
                                        <button wire:click="complete({{ $booking->id }})" onclick="return confirm('Tandai selesai?')"
                                            class="text-xs font-bold text-court-blue hover:text-blue-300 transition-colors cursor-pointer">
                                            Selesai
                                        </button>
                                    @endif
                                    @if (in_array($booking->status, [BookingStatus::Pending, BookingStatus::Confirmed]))
                                        <button wire:click="reject({{ $booking->id }})" onclick="return confirm('Tolak booking ini?')"
                                            class="text-xs font-bold text-red-400 hover:text-red-300 transition-colors cursor-pointer">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                Tidak ada booking ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
