<div class="p-6">
    <div class="mb-6">
        <flux:link :href="route('bookings.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Booking Saya
        </flux:link>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Detail Booking</h1>
                    @if ($booking->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-full">Menunggu</span>
                    @elseif ($booking->status === 'confirmed')
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">Dikonfirmasi</span>
                    @elseif ($booking->status === 'cancelled')
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-sm font-medium rounded-full">Dibatalkan</span>
                    @elseif ($booking->status === 'completed')
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">Selesai</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-zinc-500">Lapangan</p>
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $booking->court->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-500">Tanggal</p>
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $booking->booking_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-500">Jam</p>
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $booking->timeSlot->label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-500">Total Harga</p>
                        <p class="font-medium text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($booking->notes)
                    <div class="mb-6">
                        <p class="text-sm text-zinc-500">Catatan</p>
                        <p class="text-zinc-700 dark:text-zinc-300">{{ $booking->notes }}</p>
                    </div>
                @endif

                {{-- Payment Info --}}
                @if ($booking->payment)
                    <div class="border-t border-zinc-100 dark:border-zinc-700 pt-4 mb-6">
                        <h3 class="font-semibold text-zinc-900 dark:text-white mb-2">Pembayaran</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-zinc-500">Metode</p>
                                <p class="text-zinc-900 dark:text-white">{{ $booking->payment->paymentMethod->name }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500">Status</p>
                                @if ($booking->payment->status === 'pending')
                                    <span class="text-yellow-600">Menunggu Verifikasi</span>
                                @elseif ($booking->payment->status === 'verified')
                                    <span class="text-green-600">Terverifikasi</span>
                                @else
                                    <span class="text-red-600">Ditolak</span>
                                @endif
                            </div>
                            @if ($booking->payment->admin_notes)
                                <div class="col-span-2">
                                    <p class="text-zinc-500">Catatan Admin</p>
                                    <p class="text-zinc-700 dark:text-zinc-300">{{ $booking->payment->admin_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Status Log --}}
                <div class="border-t border-zinc-100 dark:border-zinc-700 pt-4">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Riwayat Status</h3>
                    <div class="space-y-3">
                        @foreach ($booking->statusLogs->sortByDesc('created_at') as $log)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 mt-2"></div>
                                <div>
                                    <p class="text-sm text-zinc-900 dark:text-white">
                                        <span class="font-medium">{{ $log->old_status }}</span>
                                        → <span class="font-medium">{{ $log->new_status }}</span>
                                    </p>
                                    @if ($log->notes)
                                        <p class="text-xs text-zinc-500">{{ $log->notes }}</p>
                                    @endif
                                    <p class="text-xs text-zinc-400">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 sticky top-6 space-y-4">
                @if ($booking->status === 'pending' && !$booking->payment)
                    <flux:link :href="route('payments.create', $booking->id)" variant="primary" class="w-full block text-center" wire:navigate>
                        Bayar Sekarang
                    </flux:link>
                @endif

                @if (in_array($booking->status, ['pending', 'confirmed']))
                    <button wire:click="cancel" onclick="return confirm('Yakin ingin membatalkan booking ini?')" class="w-full px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-center text-sm font-medium">
                        Batalkan Booking
                    </button>
                @endif

                <flux:link :href="route('courts.show', $booking->court->id)" class="w-full block text-center text-sm" wire:navigate>
                    Lihat Lapangan
                </flux:link>
            </div>
        </div>
    </div>
</div>
