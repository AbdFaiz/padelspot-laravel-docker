@php use App\Enums\BookingStatus; @endphp

<div class="page-bg p-6 lg:p-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">My Bookings</p>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">Booking Saya</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola dan lihat status seluruh riwayat pemesanan lapangan Anda</p>
    </div>

    {{-- Filter Bar --}}
    <div class="card-flat p-5 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Cari Lapangan</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nama lapangan..."
                    class="input-flat">
            </div>

            <div class="w-44">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select wire:model.live="status" class="input-flat">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>

            <div class="w-40">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom" class="input-flat">
            </div>

            <div class="w-40">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo" class="input-flat">
            </div>

            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <button wire:click="resetFilters"
                    class="px-4 py-2.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border-gray-200 dark:border-slate-dark hover:border-gray-300 dark:hover:border-gray-600 rounded-xl transition-all cursor-pointer">
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    {{-- Booking Table --}}
    @if ($bookings->count())
        <div class="card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="table-header-flat">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="table-row-flat">
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $booking->court->name }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->booking_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $booking->timeSlots->pluck('label')->implode(', ') }}</td>
                                <td class="px-6 py-4 font-bold text-[var(--color-accent)]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
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
                                    <a href="{{ route('bookings.show', $booking->id) }}" wire:navigate
                                        class="text-sm font-bold text-court-blue hover:text-gray-900 dark:hover:text-gray-900 dark:hover:text-white transition-colors">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card-flat p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <p class="text-gray-400 dark:text-gray-500 font-medium mb-4">Tidak ada booking yang cocok dengan pencarian.</p>
                <button wire:click="resetFilters" class="text-sm font-bold text-court-blue hover:text-gray-900 dark:hover:text-gray-900 dark:hover:text-white transition-colors cursor-pointer">Reset Filter</button>
            @else
                <p class="text-gray-400 dark:text-gray-500 font-medium mb-5">Anda belum memiliki riwayat pemesanan lapangan.</p>
                <a href="{{ route('courts.index') }}" wire:navigate
                    class="inline-flex items-center gap-2 bg-court-blue hover:bg-court-blue-dark text-white font-bold px-6 py-3 rounded-xl transition-all font-heading text-sm">
                    Mulai Booking Sekarang
                </a>
            @endif
        </div>
    @endif

</div>
