@php use App\Enums\BookingStatus; use App\Enums\PaymentStatus; @endphp

<div class="page-bg p-6 lg:p-8">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('bookings.index') }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Booking Saya
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Detail Card --}}
        <div class="lg:col-span-2">
            <div class="card-flat p-6 sm:p-8">
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200 dark:border-slate-dark">
                    <div>
                        <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">Kode Booking #{{ $booking->id }}</p>
                        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading">Detail Pemesanan</h1>
                    </div>

                    @if ($booking->status === BookingStatus::Pending)
                        <span class="badge-pending px-3.5 py-1.5 text-xs font-bold rounded-full">Menunggu Pembayaran</span>
                    @elseif ($booking->status === BookingStatus::Confirmed)
                        <span class="badge-confirmed px-3.5 py-1.5 text-xs font-bold rounded-full">✓ Dikonfirmasi</span>
                    @elseif ($booking->status === BookingStatus::Cancelled)
                        <span class="badge-cancelled px-3.5 py-1.5 text-xs font-bold rounded-full">Dibatalkan</span>
                    @elseif ($booking->status === BookingStatus::Completed)
                        <span class="badge-completed px-3.5 py-1.5 text-xs font-bold rounded-full">Selesai</span>
                    @endif
                </div>

                {{-- Detail Grid --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Lapangan</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">{{ $booking->court->name }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Tanggal</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">{{ $booking->booking_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Jam</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">{{ $booking->timeSlots->pluck('label')->implode(', ') }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $booking->timeSlots->count() }} jam</p>
                    </div>
                    <div class="bg-[var(--color-accent)]/10 rounded-xl p-4 border border-[var(--color-accent)]/25">
                        <p class="text-[10px] font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">Total Harga</p>
                        <p class="font-extrabold text-[var(--color-accent)] text-lg font-heading">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($booking->notes)
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-slate-dark/50 rounded-xl border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Catatan</p>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $booking->notes }}</p>
                    </div>
                @endif

                {{-- Payment Info --}}
                @if ($booking->payment)
                    <div class="border-t border-gray-200 dark:border-slate-dark pt-6 mb-6">
                        <h3 class="font-bold text-gray-900 dark:text-white font-heading text-base mb-4">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Metode</p>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $booking->payment->paymentMethod->name }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Status Pembayaran</p>
                                <span class="badge-confirmed px-2.5 py-1 text-xs font-bold rounded-full inline-block mt-0.5">Lunas</span>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div>
            <div class="card-flat p-6 sticky top-6 space-y-3">
                <h3 class="font-bold text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wider mb-3">Aksi Booking</h3>

                @if ($booking->status === BookingStatus::Pending && !$booking->payment)
                    <a href="{{ route('payments.create', $booking->id) }}" wire:navigate
                        class="w-full bg-[var(--color-accent)] hover:opacity-90 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center block font-heading text-sm">
                        <svg class="w-4 h-4 inline mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Bayar Sekarang
                    </a>
                @endif

                @if (in_array($booking->status, [BookingStatus::Pending, BookingStatus::Confirmed]))
                    <button wire:click="cancel" onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                        class="w-full px-4 py-3 border border-red-500/40 text-red-400 hover:bg-red-500/10 rounded-xl text-center text-sm font-semibold transition-all cursor-pointer flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batalkan Booking
                    </button>
                @endif

                <div class="pt-2 border-t border-gray-200 dark:border-slate-dark">
                    <a href="{{ route('courts.show', $booking->court->id) }}" wire:navigate
                        class="w-full flex items-center justify-center gap-1.5 text-center text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white py-2 transition-colors">
                        Lihat Detail Lapangan
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Booking ID Reference --}}
                <div class="pt-3 text-center">
                    <span class="text-[10px] text-gray-300 dark:text-gray-600 font-mono">#{{ $booking->id }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
