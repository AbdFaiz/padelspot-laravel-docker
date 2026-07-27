<div class="p-6">
    <div class="mb-6">
        <flux:link :href="route('courts.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </flux:link>
    </div>

    @if ($court)
        <div class="max-w-2xl">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-2">Buat Booking</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mb-6">Lapangan: <strong>{{ $court->name }}</strong> - Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</p>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                <form wire:submit="store" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tanggal Booking</label>
                        <input type="date" wire:model="bookingDate" min="{{ now()->toDateString() }}" max="{{ $maxDate }}" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
                        @error('bookingDate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Pilih Jam</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach ($timeSlots as $slot)
                                @php
                                    $isBooked = in_array($slot->id, $bookedSlotIds);
                                @endphp
                                <label class="flex items-center justify-center p-3 rounded-lg border cursor-pointer transition {{ $isBooked ? 'border-zinc-200 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-700 opacity-50 cursor-not-allowed' : ($timeSlotId == $slot->id ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-zinc-200 dark:border-zinc-600 hover:border-green-300') }}">
                                    <input type="radio" wire:model="timeSlotId" value="{{ $slot->id }}" {{ $isBooked ? 'disabled' : '' }} class="hidden">
                                    <span class="text-sm {{ $isBooked ? 'line-through text-zinc-400' : 'text-zinc-900 dark:text-white' }}">{{ $slot->label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('timeSlotId') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Catatan (opsional)</label>
                        <textarea wire:model="notes" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700" rows="3" placeholder="Catatan untuk booking..."></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <flux:button type="submit" variant="primary">
                            Buat Booking
                        </flux:button>
                        <flux:link :href="route('courts.show', $court->id)" class="px-4 py-2" wire:navigate>
                            Batal
                        </flux:link>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-zinc-500 mb-4">Pilih lapangan terlebih dahulu.</p>
            <flux:link :href="route('courts.index')" variant="primary" wire:navigate>
                Pilih Lapangan
            </flux:link>
        </div>
    @endif
</div>
