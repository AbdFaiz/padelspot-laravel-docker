<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" class="text-sm font-semibold text-[#0052CC] hover:underline inline-flex items-center gap-1" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    @if ($court)
        <div class="max-w-4xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading">Buat Booking</h1>
                    <p class="text-slate-600 mt-1 text-sm font-medium">Lapangan: <strong class="text-slate-900">{{ $court->name }}</strong> – <span class="text-[#FF6600] font-bold">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</span></p>
                </div>
                <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl p-1 shadow-sm">
                    <button wire:click="$set('viewMode', 'grid')" class="px-4 py-2 text-sm rounded-lg transition font-semibold {{ $viewMode === 'grid' ? 'bg-[#0052CC] text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Grid
                    </button>
                    <button wire:click="$set('viewMode', 'calendar')" class="px-4 py-2 text-sm rounded-lg transition font-semibold {{ $viewMode === 'calendar' ? 'bg-[#0052CC] text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kalender
                    </button>
                </div>
            </div>

            @if ($viewMode === 'grid')
                {{-- Grid View --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mt-4">
                    <form wire:submit="store" class="space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal Booking</label>
                            <input type="date" wire:model="bookingDate" min="{{ now()->toDateString() }}" max="{{ $maxDate }}" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                            @error('bookingDate') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        @if ($courtSchedule)
                            <div class="flex items-center gap-2 p-3.5 bg-emerald-50 rounded-xl border border-emerald-200">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm text-emerald-700 font-medium">Jam operasional: <strong>{{ $courtSchedule['open_time'] }} - {{ $courtSchedule['close_time'] }}</strong></span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 p-3.5 bg-amber-50 rounded-xl border border-amber-200">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                <span class="text-sm text-amber-700 font-medium">Lapangan tidak beroperasi pada hari ini</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Jam <span class="text-slate-400 normal-case font-normal">(bisa lebih dari satu, harus berurutan)</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                @foreach ($timeSlots as $slot)
                                    @php
                                        $isBooked = in_array($slot->id, $bookedSlotIds);
                                        $isUnavailable = in_array($slot->id, $unavailableSlotIds);
                                        $isSelected = in_array($slot->id, $selectedSlots);
                                        $isDisabled = $isBooked || $isUnavailable;
                                    @endphp
                                    <label class="flex items-center justify-center p-3 rounded-xl border cursor-pointer transition
                                        {{ $isDisabled
                                            ? 'border-slate-200 bg-slate-50 opacity-50 cursor-not-allowed'
                                            : ($isSelected
                                                ? 'border-[#FF6600] bg-[#FF6600]/10 ring-2 ring-[#FF6600]'
                                                : 'border-slate-200 hover:border-[#0052CC] hover:bg-[#0052CC]/5')
                                        }}">
                                        <input type="checkbox" wire:click="toggleSlot({{ $slot->id }})" value="{{ $slot->id }}" {{ $isDisabled ? 'disabled' : '' }}
                                            {{ $isSelected ? 'checked' : '' }} class="hidden">
                                        <div class="text-center">
                                            <span class="text-sm font-semibold {{ $isDisabled ? 'text-slate-400' : ($isSelected ? 'text-[#FF6600]' : 'text-slate-900') }}">{{ $slot->label }}</span>
                                            @if ($isBooked)
                                                <span class="block text-xs text-red-500 mt-0.5 font-bold">Terpesan</span>
                                            @elseif ($isUnavailable)
                                                <span class="block text-xs text-slate-400 mt-0.5">Di luar jam</span>
                                            @elseif ($isSelected)
                                                <span class="block text-xs text-[#FF6600] mt-0.5 font-bold">✓ Dipilih</span>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedSlots') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        @if (count($selectedSlots) > 0 && !$slotOrderValid)
                            <div class="flex items-center gap-2 p-3.5 bg-red-50 rounded-xl border border-red-200">
                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span class="text-sm text-red-600 font-medium">Slot yang dipilih harus berurutan tanpa jeda.</span>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Catatan (opsional)</label>
                            <textarea wire:model="notes" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm p-3" rows="3" placeholder="Catatan untuk booking..."></textarea>
                        </div>

                        @if (count($selectedSlots) > 0)
                            <div class="bg-[#0052CC]/8 rounded-xl p-5 border border-[#0052CC]/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-slate-600 font-medium">{{ count($selectedSlots) }} jam × Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                                        <p class="text-2xl font-extrabold text-[#0052CC] font-heading mt-1">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    </div>
                                    @if (!$slotOrderValid)
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Urutan tidak valid</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">✓ Siap dipesan</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                            <button type="submit" {{ count($selectedSlots) === 0 || !$slotOrderValid ? 'disabled' : '' }}
                                class="bg-[#FF6600] hover:bg-[#E55C00] disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold px-7 py-3.5 rounded-xl shadow-lg shadow-orange-500/30 transition-all font-heading text-sm cursor-pointer">
                                Buat Booking Sekarang
                            </button>
                            <a href="{{ route('courts.show', $court->id) }}" class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl hover:bg-slate-100 transition-all" wire:navigate>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>

            @else
                {{-- Calendar View --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mt-4">
                    {{-- Week Navigation --}}
                    <div class="flex items-center justify-between mb-5">
                        <button wire:click="prevWeek" class="p-2.5 rounded-xl border border-slate-200 hover:bg-[#F4F6F9] hover:border-[#0052CC] transition">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <div class="text-center">
                            <span class="font-bold text-slate-900 font-heading">{{ $calendarWeekLabel }}</span>
                            <button wire:click="goToToday" class="ml-2 px-2.5 py-0.5 text-xs font-bold bg-[#0052CC]/10 text-[#0052CC] rounded-full hover:bg-[#0052CC]/20 transition">Hari Ini</button>
                        </div>
                        <button wire:click="nextWeek" class="p-2.5 rounded-xl border border-slate-200 hover:bg-[#F4F6F9] hover:border-[#0052CC] transition">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
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
                                        <div class="text-center p-2 rounded-xl {{ $day['is_today'] ? 'bg-[#0052CC]/10 border border-[#0052CC]/25' : '' }} {{ $day['is_selected'] ? 'ring-2 ring-[#FF6600]' : '' }}">
                                            <div class="text-xs text-slate-500 font-bold uppercase">{{ $day['day_name'] }}</div>
                                            <div class="text-lg font-extrabold {{ $day['is_today'] ? 'text-[#0052CC]' : 'text-slate-900' }} font-heading">{{ $day['day_number'] }}</div>
                                            <div class="text-xs text-slate-400">{{ $day['month'] }}</div>
                                            @if ($day['schedule'])
                                                <div class="text-[10px] text-emerald-600 font-semibold mt-0.5">{{ $day['schedule']['open'] }}-{{ $day['schedule']['close'] }}</div>
                                            @else
                                                <div class="text-[10px] text-amber-500 font-bold mt-0.5">Tutup</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Slot Rows --}}
                                @php $firstDaySlots = $calendarData[0]['slots'] ?? []; @endphp
                                @foreach ($firstDaySlots as $slotIndex => $slotInfo)
                                    <div class="grid gap-1" style="grid-template-columns: 60px repeat({{ count($calendarData) }}, 1fr);">
                                        <div class="flex items-center justify-end pr-2 text-xs text-slate-500 font-semibold">
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
                                                    class="p-1.5 rounded-lg text-xs text-center transition border
                                                    {{ $isDisabled || $day['is_past']
                                                        ? 'border-slate-100 bg-slate-50 text-slate-300 cursor-not-allowed'
                                                        : ($isSelected
                                                            ? 'border-[#FF6600] bg-[#FF6600]/15 text-[#FF6600] ring-1 ring-[#FF6600] font-bold'
                                                            : ($isBooked
                                                                ? 'border-red-200 bg-red-50 text-red-400 cursor-not-allowed'
                                                                : 'border-slate-200 hover:border-[#0052CC] hover:bg-[#0052CC]/8 text-slate-700 cursor-pointer'))
                                                    }}"
                                                >
                                                    @if ($isBooked)
                                                        <span class="text-red-400">✕</span>
                                                    @elseif ($isSelected)
                                                        <span class="text-[#FF6600]">✓</span>
                                                    @elseif ($isDisabled || $day['is_past'])
                                                        <span class="text-slate-300">—</span>
                                                    @else
                                                        <span class="text-[#0052CC]">○</span>
                                                    @endif
                                                </button>
                                            @else
                                                <div class="p-1.5 rounded-lg border border-slate-100 bg-slate-50">
                                                    <span class="text-slate-300">—</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="flex items-center justify-center gap-5 mt-5 text-xs text-slate-500 font-semibold">
                            <div class="flex items-center gap-1"><span class="text-[#0052CC] font-bold">○</span> Tersedia</div>
                            <div class="flex items-center gap-1"><span class="text-[#FF6600] font-bold">✓</span> Dipilih</div>
                            <div class="flex items-center gap-1"><span class="text-red-400 font-bold">✕</span> Terpesan</div>
                            <div class="flex items-center gap-1"><span class="text-slate-300">—</span> Tidak tersedia</div>
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500 font-medium">Tidak ada data jadwal untuk minggu ini.</div>
                    @endif

                    {{-- Calendar Selection Summary --}}
                    @if (count($selectedSlots) > 0)
                        <div class="mt-5 bg-[#0052CC]/8 rounded-xl p-5 border border-[#0052CC]/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-slate-600 font-medium">{{ count($selectedSlots) }} jam × Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                                    <p class="text-2xl font-extrabold text-[#0052CC] font-heading mt-1">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-500 font-semibold mt-1">Tanggal: {{ \Carbon\Carbon::parse($bookingDate)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                </div>
                                <div class="text-right">
                                    @if (!$slotOrderValid)
                                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full block mb-2">Urutan tidak valid</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full block mb-2">✓ Siap dipesan</span>
                                    @endif
                                    <form wire:submit="store">
                                        <input type="hidden" wire:model="bookingDate">
                                        <button type="submit" {{ count($selectedSlots) === 0 || !$slotOrderValid ? 'disabled' : '' }}
                                            class="bg-[#FF6600] hover:bg-[#E55C00] disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold px-6 py-3 rounded-xl shadow-md shadow-orange-500/25 transition-all text-sm font-heading cursor-pointer">
                                            Buat Booking
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#0052CC]/10 text-[#0052CC] flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-slate-600 mb-5 font-medium">Pilih lapangan terlebih dahulu untuk melanjutkan booking.</p>
            <a href="{{ route('courts.index') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-7 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all inline-block font-heading" wire:navigate>
                Pilih Lapangan
            </a>
        </div>
    @endif
</div>
