<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-6">
        <a href="{{ route('bookings.index') }}" class="text-sm font-semibold text-[#0052CC] hover:underline inline-flex items-center gap-1" wire:navigate>
            ← Kembali ke Booking Saya
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Detail Card --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <div class="flex items-start justify-between mb-6">
                    <h1 class="text-2xl font-extrabold text-[#0052CC] font-heading">Detail Booking</h1>
                    @if ($booking->status === 'pending')
                        <span class="px-4 py-1.5 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Menunggu Pembayaran</span>
                    @elseif ($booking->status === 'confirmed')
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">✓ Dikonfirmasi</span>
                    @elseif ($booking->status === 'cancelled')
                        <span class="px-4 py-1.5 bg-red-100 text-red-800 text-xs font-bold rounded-full">Dibatalkan</span>
                    @elseif ($booking->status === 'completed')
                        <span class="px-4 py-1.5 bg-[#0052CC]/15 text-[#0052CC] text-xs font-bold rounded-full">Selesai</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-5 mb-6">
                    <div class="bg-[#F4F6F9] rounded-xl p-4">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Lapangan</p>
                        <p class="font-bold text-slate-900">{{ $booking->court->name }}</p>
                    </div>
                    <div class="bg-[#F4F6F9] rounded-xl p-4">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal</p>
                        <p class="font-bold text-slate-900">{{ $booking->booking_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-[#F4F6F9] rounded-xl p-4">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Jam</p>
                        <p class="font-bold text-slate-900">{{ $booking->timeSlot->label }}</p>
                    </div>
                    <div class="bg-[#FF6600]/8 rounded-xl p-4 border border-[#FF6600]/20">
                        <p class="text-xs font-bold text-[#FF6600] uppercase tracking-wider mb-1">Total Harga</p>
                        <p class="font-extrabold text-[#FF6600] text-lg font-heading">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($booking->notes)
                    <div class="mb-6 p-4 bg-[#F4F6F9] rounded-xl border border-slate-200">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Catatan</p>
                        <p class="text-slate-700 text-sm">{{ $booking->notes }}</p>
                    </div>
                @endif

                {{-- Payment Info --}}
                @if ($booking->payment)
                    <div class="border-t border-slate-100 pt-6 mb-6">
                        <h3 class="font-bold text-slate-900 font-heading mb-4">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Metode</p>
                                <p class="font-bold text-slate-900">{{ $booking->payment->paymentMethod->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Status Pembayaran</p>
                                @if ($booking->payment->status === 'pending')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Menunggu Verifikasi</span>
                                @elseif ($booking->payment->status === 'verified')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">✓ Terverifikasi</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">Ditolak</span>
                                @endif
                            </div>
                            @if ($booking->payment->admin_notes)
                                <div class="col-span-2">
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Catatan Admin</p>
                                    <p class="text-slate-700">{{ $booking->payment->admin_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Status Log --}}
                <div class="border-t border-slate-100 pt-6">
                    <h3 class="font-bold text-slate-900 font-heading mb-4">Riwayat Status</h3>
                    <div class="space-y-4">
                        @foreach ($booking->statusLogs->sortByDesc('created_at') as $log)
                            <div class="flex items-start gap-3">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#FF6600] mt-1.5 shrink-0"></div>
                                <div>
                                    <p class="text-sm text-slate-900 font-semibold">
                                        <span>{{ $log->old_status }}</span>
                                        <span class="text-slate-400 mx-1">→</span>
                                        <span class="text-[#0052CC]">{{ $log->new_status }}</span>
                                    </p>
                                    @if ($log->notes)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $log->notes }}</p>
                                    @endif
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-6 space-y-3">
                <h3 class="font-bold text-slate-900 font-heading text-sm uppercase tracking-wide text-slate-500 mb-2">Aksi Booking</h3>

                @if ($booking->status === 'pending' && !$booking->payment)
                    <a href="{{ route('payments.create', $booking->id) }}" class="w-full bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-orange-500/30 text-center block text-sm font-heading transition-all" wire:navigate>
                        Bayar Sekarang
                    </a>
                @endif

                @if (in_array($booking->status, ['pending', 'confirmed']))
                    <button wire:click="cancel" onclick="return confirm('Yakin ingin membatalkan booking ini?')"
                        class="w-full px-4 py-3 border border-red-300 text-red-600 rounded-xl hover:bg-red-50 text-center text-sm font-semibold transition-all cursor-pointer">
                        Batalkan Booking
                    </button>
                @endif

                <a href="{{ route('courts.show', $booking->court->id) }}" class="w-full block text-center text-sm font-semibold text-[#0052CC] hover:underline py-2" wire:navigate>
                    Lihat Detail Lapangan →
                </a>
            </div>
        </div>
    </div>
</div>
