@php use App\Enums\PaymentStatus; @endphp

<div class="page-bg p-6 lg:p-8">
    <div class="mb-6">
        @if (auth()->user()->isAdmin())
            <a href="{{ route('admin.payments.index') }}" wire:navigate
                class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
                ← Kembali ke Kelola Pembayaran
            </a>
        @else
            <a href="{{ route('bookings.show', $payment->booking->id) }}" wire:navigate
                class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
                ← Kembali ke Detail Booking
            </a>
        @endif
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading mb-6">Detail Pembayaran</h1>

        <div class="card-flat p-6 sm:p-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Booking</p>
                    <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $payment->booking->court->name }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</p>
                    <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $payment->booking->booking_date->format('d M Y') }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jam</p>
                    <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $payment->booking->timeSlots->pluck('label')->implode(', ') }}</p>
                </div>
                <div class="bg-emerald-500/10 rounded-xl p-4 border border-emerald-500/25">
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Jumlah Bayar</p>
                    <p class="font-extrabold text-emerald-400 text-lg font-heading mt-1">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Metode Pembayaran</p>
                    <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $payment->paymentMethod->name }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</p>
                    <div class="mt-1">
                        @if ($payment->status === PaymentStatus::Pending)
                            <span class="badge-pending px-2.5 py-1 text-xs font-bold rounded-full inline-block">Menunggu Verifikasi</span>
                        @elseif ($payment->status === PaymentStatus::Verified)
                            <span class="badge-paid px-2.5 py-1 text-xs font-bold rounded-full inline-block">Terverifikasi</span>
                        @else
                            <span class="badge-cancelled px-2.5 py-1 text-xs font-bold rounded-full inline-block">Ditolak</span>
                        @endif
                    </div>
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-4 border border-gray-200 dark:border-slate-dark">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</p>
                        <p class="font-bold text-gray-900 dark:text-white mt-1">{{ $payment->booking->user->name }}</p>
                    </div>
                @endif
            </div>

            @if ($payment->admin_notes)
                <div class="mb-6 p-4 bg-red-500/10 rounded-xl border border-red-500/25">
                    <p class="text-xs font-bold text-red-400 uppercase tracking-wider">Catatan Admin</p>
                    <p class="text-sm text-red-300 mt-1">{{ $payment->admin_notes }}</p>
                </div>
            @endif

            @if ($payment->proof_path)
                <div class="border-t border-gray-200 dark:border-slate-dark pt-6">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Bukti Pembayaran</p>
                    <img src="{{ Storage::url($payment->proof_path) }}" class="max-w-md rounded-xl border border-gray-200 dark:border-slate-dark">
                </div>
            @endif
        </div>
    </div>
</div>
