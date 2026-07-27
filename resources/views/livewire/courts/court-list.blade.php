<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Lapangan Padel</h1>
        <p class="text-zinc-600 dark:text-zinc-400 mt-1">Pilih lapangan untuk dipesan</p>
    </div>

    @if (auth()->check() && auth()->user()->isAdmin())
        <div class="mb-6">
            <flux:link :href="route('courts.create')" variant="primary" wire:navigate>
                + Tambah Lapangan
            </flux:link>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($courts as $court)
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="aspect-video bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center">
                    <span class="text-4xl">🏸</span>
                </div>

                <div class="p-5">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-lg text-zinc-900 dark:text-white">{{ $court->name }}</h3>
                        @if ($court->status === 'available')
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Tersedia</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Maintenance</span>
                        @endif
                    </div>

                    @if ($court->description)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">{{ $court->description }}</p>
                    @endif

                    <div class="flex items-center gap-1 mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $court->average_rating)
                                <span class="text-yellow-400">★</span>
                            @else
                                <span class="text-zinc-300">★</span>
                            @endif
                        @endfor
                        <span class="text-sm text-zinc-500 ml-1">({{ $court->reviews_count ?? $court->reviews->count() }})</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}/jam</span>
                        <flux:link :href="route('courts.show', $court->id)" variant="primary" class="text-sm" wire:navigate>
                            Lihat Detail
                        </flux:link>
                    </div>

                    @if (auth()->check() && auth()->user()->isAdmin())
                        <div class="flex gap-2 mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-700">
                            <flux:link :href="route('courts.edit', $court->id)" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
                                Edit
                            </flux:link>
                            <form method="POST" action="{{ route('courts.destroy', $court->id) }}" onsubmit="return confirm('Yakin hapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
