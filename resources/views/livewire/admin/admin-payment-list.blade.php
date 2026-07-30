@php use App\Enums\PaymentStatus; @endphp

<div class="page-bg p-6 lg:p-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">Admin Panel</p>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">Kelola Pembayaran</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Verifikasi atau tolak pembayaran pelanggan</p>
    </div>

    @if ($payments->count())
        <div class="card-flat overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="table-header-flat">
                        <tr>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lapangan</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Metode</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr class="table-row-flat">
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $payment->booking->user->name }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $payment->booking->court->name }}</td>
                                <td class="px-6 py-4 font-bold text-[var(--color-accent)]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $payment->paymentMethod->name }}</td>
                                <td class="px-6 py-4">
                                    @if ($payment->status === PaymentStatus::Pending)
                                        <span class="badge-pending px-3 py-1 text-xs font-bold rounded-full">Menunggu</span>
                                    @elseif ($payment->status === PaymentStatus::Verified)
                                        <span class="badge-confirmed px-3 py-1 text-xs font-bold rounded-full">Terverifikasi</span>
                                    @else
                                        <span class="badge-cancelled px-3 py-1 text-xs font-bold rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('payments.show', $payment->id) }}" wire:navigate
                                            class="text-xs font-bold text-court-blue hover:text-gray-900 dark:hover:text-white transition-colors">
                                            Detail
                                        </a>
                                        @if ($payment->status === PaymentStatus::Pending)
                                            <button wire:click="verify({{ $payment->id }})" onclick="return confirm('Verifikasi pembayaran ini?')"
                                                class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition-colors cursor-pointer">
                                                Verifikasi
                                            </button>
                                            <button wire:click="showRejectForm({{ $payment->id }})"
                                                class="text-xs font-bold text-red-400 hover:text-red-300 transition-colors cursor-pointer">
                                                Tolak
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($rejectingPaymentId === $payment->id)
                                <tr>
                                    <td colspan="6" class="px-6 py-4 bg-red-950/40 border-t border-b border-red-500/30">
                                        <div class="flex items-end gap-3">
                                            <div class="flex-1">
                                                <label class="block text-xs font-bold text-red-400 mb-1.5 uppercase tracking-wider">Alasan Penolakan</label>
                                                <textarea wire:model="rejectNotes" class="input-flat border-red-500/40 focus:border-red-500 text-sm" rows="2" placeholder="Tuliskan alasan penolakan..."></textarea>
                                            </div>
                                            <div class="flex gap-2">
                                                <button wire:click="reject({{ $payment->id }})"
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-bold text-xs rounded-xl transition cursor-pointer font-heading">
                                                    Tolak Pembayaran
                                                </button>
                                                <button wire:click="cancelReject"
                                                    class="px-4 py-2 border border-gray-200 dark:border-slate-dark text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-xs font-bold rounded-xl transition cursor-pointer">
                                                    Batal
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card-flat p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <p class="text-gray-400 dark:text-gray-500 font-medium">Belum ada pembayaran.</p>
        </div>
    @endif
</div>
