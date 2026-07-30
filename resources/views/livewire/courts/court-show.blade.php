@php $initialImage = $court->images->where('is_primary', true)->first()?->id ?? ($court->images->first()?->id ?? 'null'); @endphp
<div class="page-bg p-6 lg:p-8" x-data="{ activeImage: {{ $initialImage }} }">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="card-flat overflow-hidden">
                {{-- Image Gallery --}}
                @if ($court->images->count())
                    <div class="aspect-video relative overflow-hidden bg-court-blue-dark">
                        @foreach ($court->images as $image)
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $court->name }}"
                                class="w-full h-full object-cover absolute inset-0 transition-opacity duration-300"
                                :class="activeImage === {{ $image->id }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        @endforeach
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                    </div>
                    @if ($court->images->count() > 1)
                        <div class="flex gap-2 p-3 bg-gray-50 dark:bg-slate-dark/50 border-t border-gray-200 dark:border-slate-dark">
                            @foreach ($court->images as $image)
                                <button type="button" @click="activeImage = {{ $image->id }}"
                                    class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition cursor-pointer"
                                    :class="activeImage === {{ $image->id }} ? 'border-[var(--color-accent)]' : 'border-transparent hover:border-white/30'">
                                    <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-video flex items-center justify-center bg-gradient-to-br from-court-blue-dark to-court-blue">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                @endif

                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">{{ $court->name }}</h1>
                        @if ($court->status === 'available')
                            <span class="badge-available px-3.5 py-1.5 text-xs font-bold rounded-full">Tersedia</span>
                        @else
                            <span class="badge-maintenance px-3.5 py-1.5 text-xs font-bold rounded-full">Maintenance</span>
                        @endif
                    </div>

                    @if ($court->description)
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-base leading-relaxed">{{ $court->description }}</p>
                    @endif

                    {{-- Schedules --}}
                    <div class="mb-8 p-5 bg-gray-50 dark:bg-slate-dark/50 rounded-2xl border border-gray-200 dark:border-slate-dark">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4 font-heading text-lg">Jam Operasional</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ($court->schedules as $schedule)
                                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-xl p-3 text-center border border-gray-200 dark:border-slate-dark">
                                    <div class="text-xs font-bold text-court-blue uppercase tracking-wider">{{ substr($schedule->day, 0, 3) }}</div>
                                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 mt-1">{{ $schedule->open_time }} - {{ $schedule->close_time }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4 font-heading text-lg">Ulasan Pelanggan ({{ $court->reviews->count() }})</h3>

                        {{-- Review Form --}}
                        @auth
                            @if (!$court->reviews->where('user_id', auth()->id())->first())
                                <div class="bg-gray-50 dark:bg-slate-dark/50 rounded-2xl p-5 mb-6 border border-gray-200 dark:border-slate-dark">
                                    <div class="flex items-center gap-1 mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button wire:click="$set('rating', {{ $i }})" class="text-2xl cursor-pointer transition {{ $i <= $this->rating ? 'text-[var(--color-accent)]' : 'text-gray-200 dark:text-gray-600 hover:text-gray-400 dark:hover:text-gray-500' }}">★</button>
                                        @endfor
                                    </div>
                                    <textarea
                                        wire:model="comment"
                                        placeholder="Tulis ulasan Anda tentang pengalaman bermain di lapangan ini..."
                                        class="input-flat"
                                        rows="3"
                                    ></textarea>
                                    <div class="mt-3 text-right">
                                        <button wire:click="submitReview" class="bg-[var(--color-accent)] hover:opacity-90 text-white font-bold px-5 py-2.5 rounded-xl transition-all text-sm font-heading cursor-pointer">
                                            Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @forelse ($court->reviews->sortByDesc('created_at') as $review)
                            <div class="border-b border-gray-200 dark:border-slate-dark py-4 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</span>
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-[var(--color-accent)]' : 'text-gray-200 dark:text-gray-600' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    @auth
                                        @if ($review->user_id === auth()->id())
                                            <button wire:click="deleteReview({{ $review->id }})" onclick="return confirm('Hapus ulasan?')" class="text-xs font-semibold text-red-400 hover:text-red-300 cursor-pointer">Hapus</button>
                                        @endif
                                    @endauth
                                </div>
                                @if ($review->comment)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $review->comment }}</p>
                                @endif
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 italic">Belum ada ulasan untuk lapangan ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Booking Card --}}
        <div>
            <div class="card-flat p-6 sm:p-8 sticky top-6">
                <div class="text-center mb-6">
                    <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Tarif Sewa</span>
                    <p class="text-3xl font-extrabold text-[var(--color-accent)] font-heading">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">per jam</p>
                </div>

                <div class="flex items-center justify-center gap-1 mb-6 py-2 bg-gray-50 dark:bg-slate-dark/50 rounded-xl border border-gray-200 dark:border-slate-dark">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $court->average_rating)
                            <span class="text-[var(--color-accent)] text-lg">★</span>
                        @else
                            <span class="text-gray-200 dark:text-gray-600 text-lg">★</span>
                        @endif
                    @endfor
                    <span class="text-sm font-bold text-gray-500 dark:text-gray-400 ml-1.5">{{ number_format($court->average_rating, 1) }} / 5.0</span>
                </div>

                @auth
                    @if ($court->status === 'available')
                        <a href="{{ route('bookings.create') . '?court=' . $court->id }}" class="w-full bg-[var(--color-accent)] hover:opacity-90 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center block font-heading text-base" wire:navigate>
                            Booking Sekarang
                        </a>
                    @else
                        <div class="text-center text-sm font-semibold text-amber-400 bg-amber-500/10 py-3 rounded-xl border border-amber-500/20">
                            Lapangan sedang maintenance
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full bg-[var(--color-accent)] hover:opacity-90 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center block font-heading text-base" wire:navigate>
                        Masuk untuk Booking
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
