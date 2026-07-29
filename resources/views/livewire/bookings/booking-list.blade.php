<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading">Booking Saya</h1>
        <p class="text-slate-600 mt-1">Kelola dan lihat status seluruh riwayat pemesanan lapangan Anda</p>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-8">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Cari Lapangan</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nama lapangan..."
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                <select wire:model.live="status" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <button wire:click="resetFilters" class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl hover:bg-slate-100 transition-all cursor-pointer">
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    @if ($bookings->count())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#F4F6F9] border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Lapangan</th>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Jam</th>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Total</th>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 font-bold text-[#0052CC] uppercase text-xs tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($bookings as $booking)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $booking->court->name }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $booking->booking_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $booking->timeSlot->label }}</td>
                                <td class="px-6 py-4 text-[#FF6600] font-extrabold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
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
                                <td class="px-6 py-4">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center text-sm font-bold text-[#FF6600] hover:text-[#E55C00] transition-colors" wire:navigate>
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
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            @if ($status !== '' || $search !== '' || $dateFrom !== '' || $dateTo !== '')
                <p class="text-slate-600 font-medium mb-4">Tidak ada booking yang cocok dengan pencarian.</p>
                <button wire:click="resetFilters" class="text-sm font-bold text-[#FF6600] hover:underline cursor-pointer">Reset Filter</button>
            @else
                <p class="text-slate-600 font-medium mb-4">Anda belum memiliki riwayat pemesanan lapangan.</p>
                <a href="{{ route('courts.index') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all inline-block font-heading" wire:navigate>
                    Mulai Booking Sekarang
                </a>
            @endif
        </div>
    @endif
</div>

