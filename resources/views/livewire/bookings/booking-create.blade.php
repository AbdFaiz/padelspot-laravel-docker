<div class="page-bg p-6 lg:p-8">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    @if ($court)
        <div class="max-w-2xl">
            <div class="mb-6">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">Buat Booking</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm font-medium">
                    Lapangan: <strong class="text-gray-900 dark:text-white">{{ $court->name }}</strong>
                    – <span class="text-court-blue font-bold">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</span>
                </p>
            </div>

            <div class="card-flat p-6 sm:p-8">
                <form wire:submit="store" class="space-y-6">

                    {{-- Date --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Booking</label>
                        <input type="date" wire:model="bookingDate" min="{{ now()->toDateString() }}" max="{{ $maxDate }}" class="input-flat">
                        @error('bookingDate') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Schedule Info --}}
                    @if ($courtSchedule)
                        <div class="flex items-center gap-2 p-3.5 bg-emerald-500/10 rounded-xl border border-emerald-500/25">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm text-emerald-300 font-medium">Jam operasional: <strong>{{ $courtSchedule['open_time'] }} - {{ $courtSchedule['close_time'] }}</strong></span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 p-3.5 bg-amber-500/10 rounded-xl border border-amber-500/25">
                            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            <span class="text-sm text-amber-300 font-medium">Lapangan tidak beroperasi pada hari ini</span>
                        </div>
                    @endif

                    {{-- Time Slots --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">
                            Pilih Jam
                            <span class="text-gray-400 dark:text-gray-500 normal-case font-normal">(bisa lebih dari satu, harus berurutan)</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach ($timeSlots as $slot)
                                @php
                                    $isBooked = in_array($slot->id, $bookedSlotIds);
                                    $isUnavailable = in_array($slot->id, $unavailableSlotIds);
                                    $isSelected = in_array($slot->id, $selectedSlots);
                                    $isDisabled = $isBooked || $isUnavailable;
                                @endphp
                                <label class="slot-btn text-center {{ $isDisabled ? 'slot-btn-booked' : ($isSelected ? 'slot-btn-selected' : '') }}">
                                    <input type="checkbox" wire:click="toggleSlot({{ $slot->id }})" value="{{ $slot->id }}" {{ $isDisabled ? 'disabled' : '' }}
                                        {{ $isSelected ? 'checked' : '' }} class="hidden">
                                    <div>
                                        <span class="font-semibold">{{ $slot->label }}</span>
                                        @if ($isBooked)
                                            <span class="block text-xs text-red-400 mt-0.5 font-bold">Terpesan</span>
                                        @elseif ($isUnavailable)
                                            <span class="block text-xs text-gray-400 dark:text-gray-500 mt-0.5">Di luar jam</span>
                                        @elseif ($isSelected)
                                            <span class="block text-xs text-court-blue mt-0.5 font-bold">✓ Dipilih</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedSlots') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Consecutive Error --}}
                    @if (count($selectedSlots) > 0 && !$this->slotOrderValid)
                        <div class="flex items-center gap-2 p-3.5 bg-red-500/10 rounded-xl border border-red-500/25">
                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-sm text-red-300 font-medium">Slot yang dipilih harus berurutan tanpa jeda.</span>
                        </div>
                    @endif

                    {{-- Notes --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Catatan (opsional)</label>
                        <textarea wire:model="notes" class="input-flat" rows="3" placeholder="Catatan untuk booking..."></textarea>
                    </div>

                    {{-- Summary & Submit --}}
                    @if (count($selectedSlots) > 0)
                        <div class="bg-court-blue/10 rounded-xl p-5 border border-court-blue/20">
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ count($selectedSlots) }} jam &times; Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading mt-1">Total: Rp {{ number_format($this->totalPrice, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 font-semibold mt-1">{{ \Carbon\Carbon::parse($bookingDate)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                </div>
                                <div class="text-right">
                                    @if (!$this->slotOrderValid)
                                        <span class="px-3 py-1 bg-red-500/20 text-red-300 text-xs font-bold rounded-full block mb-2">Urutan tidak valid</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 text-xs font-bold rounded-full block mb-2">✓ Siap dipesan</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 pt-2 border-t border-gray-200 dark:border-slate-dark">
                        <button type="submit" {{ count($selectedSlots) === 0 || !$this->slotOrderValid ? 'disabled' : '' }}
                            class="bg-court-blue hover:bg-court-blue-dark disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold px-7 py-3.5 rounded-xl transition-all font-heading text-sm cursor-pointer">
                            Buat Booking Sekarang
                        </button>
                        <a href="{{ route('courts.show', $court->id) }}" class="px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-200 dark:border-slate-dark hover:border-gray-300 dark:hover:border-gray-600 rounded-xl transition-all" wire:navigate>
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-court-blue/15 text-court-blue flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-gray-500 dark:text-gray-400 mb-5 font-medium">Pilih lapangan terlebih dahulu untuk melanjutkan booking.</p>
            <a href="{{ route('courts.index') }}" class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-7 py-3 rounded-xl transition-all inline-block font-heading" wire:navigate>
                Pilih Lapangan
            </a>
        </div>
    @endif
</div>
