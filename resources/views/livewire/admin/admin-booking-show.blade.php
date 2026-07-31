@php
    use App\Enums\BookingStatus;
    use App\Enums\PaymentStatus;

    $statusLabels = [
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
@endphp

<div class="page-bg p-6 lg:p-8">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.bookings.index') }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Kelola Booking
        </a>
    </div>

    {{-- Page Header --}}
    <div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
        <div>
            <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">Admin Panel — Kode Booking
                #{{ $booking->id }}</p>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading">Detail Pemesanan</h1>
        </div>

        @if ($booking->status === BookingStatus::Pending)
            <span class="badge-pending px-3.5 py-1.5 text-xs font-bold rounded-full">Menunggu</span>
        @elseif ($booking->status === BookingStatus::Confirmed)
            <span class="badge-confirmed px-3.5 py-1.5 text-xs font-bold rounded-full">Dikonfirmasi</span>
        @elseif ($booking->status === BookingStatus::Cancelled)
            <span class="badge-cancelled px-3.5 py-1.5 text-xs font-bold rounded-full">Dibatalkan</span>
        @elseif ($booking->status === BookingStatus::Completed)
            <span class="badge-completed px-3.5 py-1.5 text-xs font-bold rounded-full">Selesai</span>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Customer Info --}}
            <div class="card-flat p-6">
                <h3 class="font-bold text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wider mb-4">Pelanggan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Nama</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            No. HP</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Email</p>
                        <p class="font-bold text-gray-900 dark:text-white break-all">{{ $booking->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Booking Detail --}}
            <div class="card-flat p-6">
                <h3 class="font-bold text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wider mb-4">Detail
                    Booking</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Lapangan</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">{{ $booking->court->name }}</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Tanggal</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">
                            {{ $booking->booking_date->format('d M Y') }}</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Jam</p>
                        <p class="font-bold text-gray-900 dark:text-white text-base">
                            {{ $booking->timeSlots->pluck('label')->implode(', ') }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $booking->timeSlots->count() }}
                            jam</p>
                    </div>
                    <div class="bg-[var(--color-accent)]/10 rounded-xl p-4 border border-[var(--color-accent)]/25">
                        <p class="text-[10px] font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">Total
                            Harga</p>
                        <p class="font-extrabold text-[var(--color-accent)] text-lg font-heading">Rp
                            {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($booking->notes)
                    <div
                        class="mt-4 p-4 bg-gray-50 dark:bg-slate-dark/50 rounded-xl border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                            Catatan Pelanggan</p>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $booking->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Payment Info --}}
            <div class="card-flat p-6">
                <h3 class="font-bold text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wider mb-4">Informasi
                    Pembayaran</h3>

                @if ($booking->payment)
                    @php $payment = $booking->payment; @endphp
                    <div class="grid grid-cols-3 gap-3 text-sm mb-4">
                        <div
                            class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                            <p
                                class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                                Metode</p>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $payment->paymentMethod->name }}</p>
                        </div>
                        <div class="bg-emerald-500/10 rounded-xl p-4 border border-emerald-500/25">
                            <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider mb-1">Jumlah
                                Dibayar</p>
                            <p class="font-extrabold text-emerald-400 text-lg font-heading">Rp
                                {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <div
                            class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                            <p
                                class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                                Tanggal Bayar</p>
                            <p class="font-bold text-gray-900 dark:text-white">
                                {{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($payment->admin_notes)
                        <div class="mb-4 p-4 bg-red-500/10 rounded-xl border border-red-500/25">
                            <p class="text-xs font-bold text-red-400 uppercase tracking-wider mb-1">Catatan Admin</p>
                            <p class="text-sm text-red-300">{{ $payment->admin_notes }}</p>
                        </div>
                    @endif

                    @if ($payment->proof_path)
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">
                                Bukti Pembayaran</p>
                            <a href="{{ Storage::url($payment->proof_path) }}" target="_blank">
                                <img src="{{ Storage::url($payment->proof_path) }}" alt="Bukti Pembayaran"
                                    class="max-w-md rounded-xl border border-gray-200 dark:border-slate-dark">
                            </a>
                        </div>
                    @endif
                @else
                    <div
                        class="p-4 bg-gray-50 dark:bg-slate-dark/50 rounded-xl border border-gray-200 dark:border-slate-dark">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pembayaran untuk booking ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <div class="card-flat p-6 sticky top-6 space-y-3">
                <h3 class="font-bold text-gray-400 dark:text-gray-500 text-xs uppercase tracking-wider mb-2">Aksi Admin
                </h3>

                <div class="p-4 bg-[var(--color-accent)]/10 rounded-xl border border-[var(--color-accent)]/25 mb-2">
                    <p class="text-[10px] font-bold text-[var(--color-accent)] uppercase tracking-wider mb-1">Total
                        Pembayaran</p>
                    <p class="font-extrabold text-[var(--color-accent)] text-xl font-heading">Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>

                @if ($booking->status === BookingStatus::Pending)
                    <button wire:click="confirm" onclick="return confirm('Konfirmasi booking ini?')"
                        class="w-full bg-emerald-500 hover:bg-emerald-400 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center block font-heading text-sm cursor-pointer">
                        Konfirmasi Booking
                    </button>
                @endif

                @if ($booking->status === BookingStatus::Confirmed)
                    <button wire:click="complete" onclick="return confirm('Tandai booking ini selesai?')"
                        class="w-full bg-[var(--color-accent)] hover:opacity-90 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center block font-heading text-sm cursor-pointer">
                        Tandai Selesai
                    </button>
                @endif

                @if (in_array($booking->status, [BookingStatus::Pending, BookingStatus::Confirmed]))
                    <button wire:click="reject" onclick="return confirm('Tolak / batalkan booking ini?')"
                        class="w-full px-4 py-3 border border-red-500/40 text-red-400 hover:bg-red-500/10 rounded-xl text-center text-sm font-semibold transition-all cursor-pointer flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak Booking
                    </button>
                @endif

                <div class="pt-2 border-t border-gray-200 dark:border-slate-dark">
                    <a href="{{ route('courts.show', $booking->court->id) }}" wire:navigate
                        class="w-full flex items-center justify-center gap-1.5 text-center text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white py-2 transition-colors">
                        Lihat Detail Lapangan
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="pt-3 text-center">
                    <span class="text-[10px] text-gray-300 dark:text-gray-600 font-mono">#{{ $booking->id }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
