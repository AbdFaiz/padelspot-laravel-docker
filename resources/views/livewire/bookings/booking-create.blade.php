<div class="p-6">
    <div class="mb-6">
        <flux:link :href="route('courts.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </flux:link>
    </div>

    @if ($court)
        <div class="max-w-4xl">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Buat Booking</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1">Lapangan: <strong>{{ $court->name }}</strong> - Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</p>
                </div>
                <div class="flex items-center gap-2 bg-zinc-100 dark:bg-zinc-700 rounded-lg p-1">
                    <button wire:click="$set('viewMode', 'grid')" class="px-3 py-1.5 text-sm rounded-md transition {{ $viewMode === 'grid' ? 'bg-white dark:bg-zinc-600 shadow-sm font-medium text-zinc-900 dark:text-white' : 'text-zinc-500 hover:text-zinc-700' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Grid
                    </button>
                    <button wire:click="$set('viewMode', 'calendar')" class="px-3 py-1.5 text-sm rounded-md transition {{ $viewMode === 'calendar' ? 'bg-white dark:bg-zinc-600 shadow-sm font-medium text-zinc-900 dark:text-white' : 'text-zinc-500 hover:text-zinc-700' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kalender
                    </button>
                </div>
            </div>

            @if ($viewMode === 'grid')
                {{-- Grid View --}}
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 mt-4">
                    <form wire:submit="store" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tanggal Booking</label>
                            <input type="date" wire:model="bookingDate" min="{{ now()->toDateString() }}" max="{{ $maxDate }}" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
                            @error('bookingDate') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if ($courtSchedule)
                            <div class="flex items-center gap-2 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm text-green-700 dark:text-green-300">Jam operasional: <strong>{{ $courtSchedule['open_time'] }} - {{ $courtSchedule['close_time'] }}</strong></span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                <span class="text-sm text-yellow-700 dark:text-yellow-300">Lapangan tidak beroperasi pada hari ini</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Pilih Jam (bisa lebih dari satu, harus berurutan)</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                @foreach ($timeSlots as $slot)
                                    @php
                                        $isBooked = in_array($slot->id, $bookedSlotIds);
                                        $isUnavailable = in_array($slot->id, $unavailableSlotIds);
                                        $isSelected = in_array($slot->id, $selectedSlots);
                                        $isDisabled = $isBooked || $isUnavailable;
                                    @endphp
                                    <label class="flex items-center justify-center p-3 rounded-lg border cursor-pointer transition
                                        {{ $isDisabled
                                            ? 'border-zinc-200 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-700 opacity-50 cursor-not-allowed'
                                            : ($isSelected
                                                ? 'border-green-500 bg-green-50 dark:bg-green-900/20 ring-1 ring-green-500'
                                                : 'border-zinc-200 dark:border-zinc-600 hover:border-green-300 hover:bg-green-50/50 dark:hover:bg-green-900/10')
                                        }}">
                                        <input type="checkbox" wire:click="toggleSlot({{ $slot->id }})" value="{{ $slot->id }}" {{ $isDisabled ? 'disabled' : '' }}
                                            {{ $isSelected ? 'checked' : '' }} class="hidden">
                                        <div class="text-center">
                                            <span class="text-sm {{ $isDisabled ? 'text-zinc-400' : 'text-zinc-900 dark:text-white' }}">{{ $slot->label }}</span>
                                            @if ($isBooked)
                                                <span class="block text-xs text-red-500 mt-0.5">Terpesan</span>
                                            @elseif ($isUnavailable)
                                                <span class="block text-xs text-zinc-400 mt-0.5">Di luar jam</span>
                                            @elseif ($isSelected)
                                                <span class="block text-xs text-green-600 mt-0.5">✓ Dipilih</span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedSlots') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        @if (count($selectedSlots) > 0 && !$slotOrderValid)
                            <div class="flex items-center gap-2 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span class="text-sm text-red-600 dark:text-red-400">Slot yang dipilih harus berurutan tanpa jeda.</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Catatan (opsional)</label>
                            <textarea wire:model="notes" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700" rows="3" placeholder="Catatan untuk booking..."></textarea>
                        </div>

                        @if (count($selectedSlots) > 0)
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ count($selectedSlots) }} jam x Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                                        <p class="text-xl font-bold text-green-700 dark:text-green-300">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </div>
                                    @if (!$slotOrderValid)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">Urutan tidak valid</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Siap dipesan</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3 pt-4">
                            <flux:button type="submit" variant="primary" :disabled="count($selectedSlots) === 0 || !$slotOrderValid">
                                Buat Booking
                            </flux:button>
                            <flux:link :href="route('courts.show', $court->id)" class="px-4 py-2" wire:navigate>
                                Batal
                            </flux:link>
                        </div>
                    </form>
                </div>

            @else
                {{-- Calendar View --}}
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 mt-4">
                    {{-- Week Navigation --}}
                    <div class="flex items-center justify-between mb-4">
                        <button wire:click="prevWeek" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <div class="text-center">
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $calendarWeekLabel }}</span>
                            <button wire:click="goToToday" class="ml-2 px-2 py-0.5 text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full hover:bg-green-200 dark:hover:bg-green-900/50 transition">Hari Ini</button>
                        </div>
                        <button wire:click="nextWeek" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>

                    {{-- Calendar Grid --}}
                    @if (count($calendarData) > 0)
                        <div class="overflow-x-auto">
                            <div class="min-w-[700px]">
                                {{-- Day Headers --}}
                                <div class="grid gap-1 mb-1" style="grid-template-columns: 60px repeat({{ count($calendarData) }}, 1fr);">
                                    <div></div>
                                    @foreach ($calendarData as $day)
                                        <div class="text-center p-2 rounded-lg {{ $day['is_today'] ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : '' }} {{ $day['is_selected'] ? 'ring-2 ring-green-500' : '' }}">
                                            <div class="text-xs text-zinc-500 uppercase">{{ $day['day_name'] }}</div>
                                            <div class="text-lg font-bold text-zinc-900 dark:text-white {{ $day['is_today'] ? 'text-green-600 dark:text-green-400' : '' }}">{{ $day['day_number'] }}</div>
                                            <div class="text-xs text-zinc-400">{{ $day['month'] }}</div>
                                            @if ($day['schedule'])
                                                <div class="text-[10px] text-zinc-400 mt-0.5">{{ $day['schedule']['open'] }}-{{ $day['schedule']['close'] }}</div>
                                            @else
                                                <div class="text-[10px] text-yellow-500 mt-0.5">Tutup</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Slot Rows --}}
                                @php $firstDaySlots = $calendarData[0]['slots'] ?? []; @endphp
                                @foreach ($firstDaySlots as $slotIndex => $slotInfo)
                                    <div class="grid gap-1" style="grid-template-columns: 60px repeat({{ count($calendarData) }}, 1fr);">
                                        <div class="flex items-center justify-end pr-2 text-xs text-zinc-500">
                                            {{ $slotInfo['start_time'] }}
                                        </div>
                                        @foreach ($calendarData as $day)
                                            @php $daySlot = $day['slots'][$slotIndex] ?? null; @endphp
                                            @if ($daySlot)
                                                @php
                                                    $isDisabled = $daySlot['is_disabled'];
                                                    $isBooked = $daySlot['is_booked'];
                                                    $isSelected = in_array($daySlot['id'], $selectedSlots) && $day['date'] === $bookingDate;
                                                @endphp
                                                <button
                                                    type="button"
                                                    wire:click="selectCalendarSlot('{{ $day['date'] }}', {{ $daySlot['id'] }})"
                                                    {{ $isDisabled || $day['is_past'] ? 'disabled' : '' }}
                                                    class="p-1.5 rounded text-xs text-center transition border
                                                    {{ $isDisabled || $day['is_past']
                                                        ? 'border-zinc-100 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-300 dark:text-zinc-600 cursor-not-allowed'
                                                        : ($isSelected
                                                            ? 'border-green-500 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 ring-1 ring-green-500 font-medium'
                                                            : ($isBooked
                                                                ? 'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 text-red-400 cursor-not-allowed'
                                                                : 'border-zinc-200 dark:border-zinc-600 hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/10 text-zinc-700 dark:text-zinc-300 cursor-pointer'))
                                                    }}"
                                                >
                                                    @if ($isBooked)
                                                        <span class="text-red-400">✕</span>
                                                    @elseif ($isSelected)
                                                        <span class="text-green-600">✓</span>
                                                    @elseif ($isDisabled || $day['is_past'])
                                                        <span class="text-zinc-300">—</span>
                                                    @else
                                                        <span class="text-green-500">○</span>
                                                    @endif
                                                </button>
                                            @else
                                                <div class="p-1.5 rounded border border-zinc-100 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                                    <span class="text-zinc-300">—</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="flex items-center justify-center gap-4 mt-4 text-xs text-zinc-500">
                            <div class="flex items-center gap-1"><span class="text-green-500">○</span> Tersedia</div>
                            <div class="flex items-center gap-1"><span class="text-green-600 font-bold">✓</span> Dipilih</div>
                            <div class="flex items-center gap-1"><span class="text-red-400">✕</span> Terpesan</div>
                            <div class="flex items-center gap-1"><span class="text-zinc-300">—</span> Tidak tersedia</div>
                        </div>
                    @else
                        <div class="text-center py-8 text-zinc-500">Tidak ada data jadwal untuk minggu ini.</div>
                    @endif

                    {{-- Calendar Selection Summary --}}
                    @if (count($selectedSlots) > 0)
                        <div class="mt-4 bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-700 dark:text-green-300">{{ count($selectedSlots) }} jam x Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                                    <p class="text-xl font-bold text-green-700 dark:text-green-300">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">Tanggal: {{ \Carbon\Carbon::parse($bookingDate)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                </div>
                                <div class="text-right">
                                    @if (!$slotOrderValid)
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full block mb-2">Urutan tidak valid</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full block mb-2">Siap dipesan</span>
                                    @endif
                                    <form wire:submit="store">
                                        <input type="hidden" wire:model="bookingDate">
                                        <flux:button type="submit" variant="primary" class="text-sm" :disabled="count($selectedSlots) === 0 || !$slotOrderValid">
                                            Buat Booking
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
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
