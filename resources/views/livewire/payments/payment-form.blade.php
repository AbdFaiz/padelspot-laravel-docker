<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-6">
        <a href="{{ route('bookings.show', $booking->id) }}" class="text-sm font-semibold text-[#0052CC] hover:underline inline-flex items-center gap-1" wire:navigate>
            ← Kembali ke Detail Booking
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading mb-6">Bayar Booking</h1>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            {{-- Booking Summary --}}
            <div class="p-5 bg-gradient-to-br from-[#0052CC]/8 to-[#FF6600]/5 rounded-2xl border border-[#0052CC]/20">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total yang harus dibayar</p>
                <p class="text-3xl font-extrabold text-[#FF6600] font-heading">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-600 font-medium mt-1.5">
                    {{ $booking->court->name }} — {{ $booking->booking_date->format('d M Y') }} {{ $booking->timeSlot->label }}
                </p>
            </div>

            <form wire:submit="submit" class="space-y-5">
                {{-- Payment Method --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                    <div class="space-y-2">
                        @foreach ($paymentMethods as $method)
                            <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer transition
                                {{ $paymentMethodId == $method->id
                                    ? 'border-[#FF6600] bg-[#FF6600]/8 ring-2 ring-[#FF6600]/30'
                                    : 'border-slate-200 hover:border-[#0052CC] hover:bg-[#0052CC]/5' }}">
                                <input type="radio" wire:model="paymentMethodId" value="{{ $method->id }}" class="text-[#FF6600] focus:ring-[#FF6600]">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $method->name }}</p>
                                    @if ($method->description)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $method->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('paymentMethodId') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                {{-- Proof Upload --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Bukti Pembayaran</label>
                    <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer hover:border-[#FF6600] transition-colors bg-[#F4F6F9]">
                        <svg class="w-7 h-7 text-[#FF6600] mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-bold text-slate-700">Upload Bukti Transfer / Pembayaran</span>
                        <span class="text-xs text-slate-500 mt-0.5">JPG, PNG — Maks. 2MB</span>
                        <input type="file" wire:model="proof" accept="image/jpeg,image/png" class="hidden">
                    </label>
                    @error('proof') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror

                    @if ($proof)
                        <div class="mt-3">
                            <p class="text-xs font-bold text-slate-500 mb-1.5 uppercase">Preview Bukti:</p>
                            <img src="{{ $proof->temporaryUrl() }}" class="w-36 h-36 object-cover rounded-xl border-2 border-[#FF6600]/30 shadow-md">
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                    <button type="submit" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-7 py-3.5 rounded-xl shadow-lg shadow-orange-500/30 transition-all font-heading text-sm cursor-pointer">
                        Kirim Bukti Pembayaran
                    </button>
                    <a href="{{ route('bookings.show', $booking->id) }}" class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl hover:bg-slate-100 transition-all" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
