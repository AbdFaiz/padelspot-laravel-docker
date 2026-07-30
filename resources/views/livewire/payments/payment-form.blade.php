<div class="page-bg p-6 lg:p-8">
    <div class="mb-6">
        <a href="{{ route('bookings.show', $booking->id) }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Detail Booking
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading mb-6">Bayar Booking</h1>

        <div class="card-flat p-6 sm:p-8 space-y-6">
            {{-- Booking Summary --}}
            <div class="p-5 bg-gradient-to-br from-blue-500/10 via-blue-500/5 to-[var(--color-accent)]/5 rounded-2xl border border-blue-500/20">
                <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Total yang harus dibayar</p>
                <p class="text-3xl font-extrabold text-[var(--color-accent)] font-heading">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-1.5">
                    {{ $booking->court->name }} — {{ $booking->booking_date->format('d M Y') }} {{ $booking->timeSlot->label }}
                </p>
            </div>

            <form wire:submit="submit" class="space-y-5">
                {{-- Payment Method --}}
                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                    <div class="space-y-2">
                        @foreach ($paymentMethods as $method)
                            <label class="flex items-center gap-3 p-4 option-flat {{ $paymentMethodId == $method->id ? 'option-flat-active' : '' }}">
                                <input type="radio" wire:model="paymentMethodId" value="{{ $method->id }}" class="text-[var(--color-accent)] focus:ring-[var(--color-accent)] bg-white/10 border-white/20">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $method->name }}</p>
                                    @if ($method->description)
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $method->description }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('paymentMethodId') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                {{-- Proof Upload --}}
                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Bukti Pembayaran</label>
                    <label class="upload-flat flex flex-col items-center justify-center w-full h-28">
                        <svg class="w-7 h-7 text-[var(--color-accent)] mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Upload Bukti Transfer / Pembayaran</span>
                        <span class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">JPG, PNG — Maks. 2MB</span>
                        <input type="file" wire:model="proof" accept="image/jpeg,image/png" class="hidden">
                    </label>
                    @error('proof') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror

                    @if ($proof)
                        <div class="mt-3">
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 mb-1.5 uppercase">Preview Bukti:</p>
                            <img src="{{ $proof->temporaryUrl() }}" class="w-36 h-36 object-cover rounded-xl border-2 border-[var(--color-accent)]/30 ">
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-2 border-t border-gray-200 dark:border-slate-dark">
                    <button type="submit" class="bg-[var(--color-accent)] hover:opacity-90 text-white font-bold px-7 py-3.5 rounded-xl transition-all font-heading text-sm cursor-pointer">
                        Kirim Bukti Pembayaran
                    </button>
                    <a href="{{ route('bookings.show', $booking->id) }}" class="px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-200 dark:border-slate-dark hover:border-gray-300 dark:hover:border-gray-600 rounded-xl transition-all" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
