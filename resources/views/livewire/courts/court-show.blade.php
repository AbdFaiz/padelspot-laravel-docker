<div class="p-6" x-data="{ activeImage: {{ $court->images->where('is_primary', true)->first()?->id ?? ($court->images->first()?->id ?? 'null')} } }">
    <div class="mb-6">
        <flux:link :href="route('courts.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </flux:link>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                {{-- Image Gallery --}}
                @if ($court->images->count())
                    <div class="aspect-video bg-zinc-100 dark:bg-zinc-700 relative overflow-hidden">
                        @foreach ($court->images as $image)
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $court->name }}"
                                class="w-full h-full object-cover absolute inset-0 transition-opacity duration-300"
                                :class="activeImage === {{ $image->id }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        @endforeach
                    </div>
                    @if ($court->images->count() > 1)
                        <div class="flex gap-2 p-3 overflow-x-auto">
                            @foreach ($court->images as $image)
                                <button type="button" @click="activeImage = {{ $image->id }}"
                                    class="shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                                    :class="activeImage === {{ $image->id }} ? 'border-green-500' : 'border-transparent hover:border-zinc-300'">
                                    <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-video bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center">
                        <span class="text-6xl">🏸</span>
                    </div>
                @endif

                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $court->name }}</h1>
                        @if ($court->status === 'available')
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">Tersedia</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-medium rounded-full">Maintenance</span>
                        @endif
                    </div>

                    @if ($court->description)
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">{{ $court->description }}</p>
                    @endif

                    {{-- Schedules --}}
                    <div class="mb-6">
                        <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Jam Operasional</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            @foreach ($court->schedules as $schedule)
                                <div class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-3 text-center">
                                    <div class="text-xs text-zinc-500 uppercase">{{ substr($schedule->day, 0, 3) }}</div>
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $schedule->open_time }} - {{ $schedule->close_time }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Ulasan ({{ $court->reviews->count() }})</h3>

                        {{-- Review Form --}}
                        @auth
                            @if (!$court->reviews->where('user_id', auth()->id())->first())
                                <div class="bg-zinc-50 dark:bg-zinc-700 rounded-xl p-4 mb-4">
                                    <div class="flex items-center gap-1 mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button wire:click="$set('rating', {{ $i }})" class="text-2xl {{ $i <= $this->rating ? 'text-yellow-400' : 'text-zinc-300' }}">★</button>
                                        @endfor
                                    </div>
                                    <textarea
                                        wire:model="comment"
                                        placeholder="Tulis ulasan Anda (opsional)..."
                                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 text-sm"
                                        rows="3"
                                    ></textarea>
                                    <div class="mt-2">
                                        <flux:button wire:click="submitReview" variant="primary" class="text-sm">
                                            Kirim Ulasan
                                        </flux:button>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @forelse ($court->reviews->sortByDesc('created_at') as $review)
                            <div class="border-b border-zinc-100 dark:border-zinc-700 py-4 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-zinc-900 dark:text-white">{{ $review->user->name }}</span>
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-zinc-300' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    @auth
                                        @if ($review->user_id === auth()->id())
                                            <button wire:click="deleteReview({{ $review->id }})" onclick="return confirm('Hapus ulasan?')" class="text-xs text-red-600 hover:text-red-800">Hapus</button>
                                        @endif
                                    @endauth
                                </div>
                                @if ($review->comment)
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $review->comment }}</p>
                                @endif
                                <p class="text-xs text-zinc-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500">Belum ada ulasan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 sticky top-6">
                <div class="text-center mb-4">
                    <p class="text-3xl font-bold text-green-600">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                    <p class="text-sm text-zinc-500">per jam</p>
                </div>

                <div class="flex items-center justify-center gap-1 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $court->average_rating)
                            <span class="text-yellow-400">★</span>
                        @else
                            <span class="text-zinc-300">★</span>
                        @endif
                    @endfor
                    <span class="text-sm text-zinc-500 ml-1">{{ number_format($court->average_rating, 1) }}</span>
                </div>

                @auth
                    @if ($court->status === 'available')
                        <flux:link :href="route('bookings.create') . '?court=' . $court->id" variant="primary" class="w-full block text-center" wire:navigate>
                            Booking Sekarang
                        </flux:link>
                    @else
                        <div class="text-center text-sm text-zinc-500 py-2">Lapangan sedang maintenance</div>
                    @endif
                @else
                    <flux:link :href="route('login')" variant="primary" class="w-full block text-center" wire:navigate>
                        Masuk untuk Booking
                    </flux:link>
                @endauth
            </div>
        </div>
    </div>
</div>
