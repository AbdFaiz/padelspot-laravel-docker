<div class="p-6">
    <div class="mb-6">
        <flux:link :href="route('bookings.show', $booking->id)" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Detail Booking
        </flux:link>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Bayar Booking</h1>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-700 rounded-lg">
                <p class="text-sm text-zinc-500">Total yang harus dibayar</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $booking->court->name }} - {{ $booking->booking_date->format('d M Y') }} {{ $booking->timeSlot->label }}</p>
            </div>

            <form wire:submit="submit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Metode Pembayaran</label>
                    <div class="space-y-2">
                        @foreach ($paymentMethods as $method)
                            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer transition {{ $paymentMethodId == $method->id ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-zinc-200 dark:border-zinc-600 hover:border-green-300' }}">
                                <input type="radio" wire:model="paymentMethodId" value="{{ $method->id }}" class="text-green-600">
                                <div>
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $method->name }}</p>
                                    @if ($method->description)
                                        <p class="text-xs text-zinc-500">{{ $method->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('paymentMethodId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Bukti Pembayaran</label>
                    <input type="file" wire:model="proof" accept="image/jpeg,image/png" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 text-sm">
                    <p class="text-xs text-zinc-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                    @error('proof') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                    @if ($proof)
                        <div class="mt-2">
                            <img src="{{ $proof->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                </div>

                <div class="flex gap-3 pt-4">
                    <flux:button type="submit" variant="primary">
                        Kirim Bukti Pembayaran
                    </flux:button>
                    <flux:link :href="route('bookings.show', $booking->id)" class="px-4 py-2" wire:navigate>
                        Batal
                    </flux:link>
                </div>
            </form>
        </div>
    </div>
</div>
