<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Kelola Pembayaran</h1>
        <p class="text-zinc-600 dark:text-zinc-400 mt-1">Verifikasi atau tolak pembayaran pelanggan</p>
    </div>

    @if ($payments->count())
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Pelanggan</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Lapangan</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Jumlah</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Metode</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-zinc-600 dark:text-zinc-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="px-6 py-3 font-medium text-zinc-900 dark:text-white">{{ $payment->booking->user->name }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $payment->booking->court->name }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-zinc-600 dark:text-zinc-400">{{ $payment->paymentMethod->name }}</td>
                                <td class="px-6 py-3">
                                    @if ($payment->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Menunggu</span>
                                    @elseif ($payment->status === 'verified')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Terverifikasi</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex gap-2">
                                        <flux:link :href="route('payments.show', $payment->id)" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
                                            Detail
                                        </flux:link>
                                        @if ($payment->status === 'pending')
                                            <button wire:click="verify({{ $payment->id }})" onclick="return confirm('Verifikasi pembayaran ini?')" class="text-sm text-green-600 hover:text-green-800">
                                                Verifikasi
                                            </button>
                                            <button wire:click="showRejectForm({{ $payment->id }})" class="text-sm text-red-600 hover:text-red-800">
                                                Tolak
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            @if ($rejectingPaymentId === $payment->id)
                                <tr>
                                    <td colspan="6" class="px-6 py-4 bg-red-50 dark:bg-red-900/20">
                                        <div class="flex items-end gap-3">
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-red-700 mb-1">Alasan Penolakan</label>
                                                <textarea wire:model="rejectNotes" class="w-full rounded-lg border-red-300 dark:border-red-600 dark:bg-zinc-800 text-sm" rows="2" placeholder="Tuliskan alasan penolakan..."></textarea>
                                            </div>
                                            <div class="flex gap-2">
                                                <flux:button wire:click="reject({{ $payment->id }})" variant="danger" class="text-sm">
                                                    Tolak
                                                </flux:button>
                                                <button wire:click="cancelReject" class="px-3 py-2 text-sm text-zinc-600 hover:text-zinc-900">
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
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-12 text-center">
            <p class="text-zinc-500">Belum ada pembayaran.</p>
        </div>
    @endif
</div>
