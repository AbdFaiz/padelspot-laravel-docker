<div class="p-6">
    <div class="mb-6">
        @if (auth()->user()->isAdmin())
            <flux:link :href="route('admin.payments.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
                ← Kembali ke Kelola Pembayaran
            </flux:link>
        @else
            <flux:link :href="route('bookings.show', $payment->booking->id)" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
                ← Kembali ke Detail Booking
            </flux:link>
        @endif
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Detail Pembayaran</h1>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-zinc-500">Booking</p>
                    <p class="font-medium text-zinc-900 dark:text-white">{{ $payment->booking->court->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Tanggal</p>
                    <p class="font-medium text-zinc-900 dark:text-white">{{ $payment->booking->booking_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Jam</p>
                    <p class="font-medium text-zinc-900 dark:text-white">{{ $payment->booking->timeSlot->label }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Jumlah Bayar</p>
                    <p class="font-medium text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Metode Pembayaran</p>
                    <p class="font-medium text-zinc-900 dark:text-white">{{ $payment->paymentMethod->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Status</p>
                    @if ($payment->status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu Verifikasi</span>
                    @elseif ($payment->status === 'verified')
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Terverifikasi</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Ditolak</span>
                    @endif
                </div>
                @if (auth()->user()->isAdmin())
                    <div>
                        <p class="text-sm text-zinc-500">Pelanggan</p>
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $payment->booking->user->name }}</p>
                    </div>
                @endif
            </div>

            @if ($payment->admin_notes)
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <p class="text-sm font-medium text-red-700 dark:text-red-400">Catatan Admin</p>
                    <p class="text-sm text-red-600 dark:text-red-300">{{ $payment->admin_notes }}</p>
                </div>
            @endif

            @if ($payment->proof_path)
                <div>
                    <p class="text-sm text-zinc-500 mb-2">Bukti Pembayaran</p>
                    <img src="{{ Storage::url($payment->proof_path) }}" class="max-w-md rounded-lg border border-zinc-200 dark:border-zinc-700">
                </div>
            @endif
        </div>
    </div>
</div>
