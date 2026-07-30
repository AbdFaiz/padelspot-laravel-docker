<div class="page-bg p-6 lg:p-8">

    {{-- Page Header --}}
    <div class="mb-8 flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-bold text-court-blue uppercase tracking-widest mb-1">Fasilitas</p>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading">Daftar Lapangan Padel</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pilih lapangan favorit Anda dan langsung lakukan reservasi online</p>
        </div>

        @if (auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('courts.create') }}" wire:navigate
                class="shrink-0 flex items-center gap-2 bg-court-blue hover:bg-court-blue-dark text-white font-bold px-5 py-2.5 rounded-xl transition-all text-sm font-heading">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Lapangan
            </a>
        @endif
    </div>

    {{-- Filter Bar --}}
    <div class="card-flat p-5 mb-8">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Cari Lapangan</label>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Nama atau deskripsi lapangan..."
                    class="input-flat">
            </div>
            <div class="w-36">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Harga Min</label>
                <input type="number" wire:model.live.debounce.500ms="minPrice" placeholder="0" min="0" class="input-flat">
            </div>
            <div class="w-36">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Harga Max</label>
                <input type="number" wire:model.live.debounce.500ms="maxPrice" placeholder="∞" min="0" class="input-flat">
            </div>
            <div class="w-44">
                <label class="block text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select wire:model.live="statusFilter" class="input-flat">
                    <option value="">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            @if ($search !== '' || $minPrice !== null || $maxPrice !== null || $statusFilter !== '')
                <button wire:click="resetFilters"
                    class="px-4 py-2.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border-gray-200 dark:border-slate-dark hover:border-gray-300 dark:hover:border-gray-600 rounded-xl transition-all cursor-pointer">
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    {{-- Courts Grid --}}
    @if ($courts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courts as $court)
                <div class="card-flat overflow-hidden flex flex-col group">
                    {{-- Court Image --}}
                    @php $primaryImage = $court->images->where('is_primary', true)->first() ?? $court->images->first(); @endphp
                    <div class="aspect-video relative overflow-hidden">
                        @if ($primaryImage)
                            <img src="{{ Storage::url($primaryImage->image_path) }}"
                                alt="{{ $court->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center"
                                class="bg-gradient-to-br from-court-blue-dark to-court-blue">
                                <svg class="w-12 h-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif

                        {{-- Overlay gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                        {{-- Status badge --}}
                        <div class="absolute top-3 right-3">
                            @if ($court->status === 'available')
                                <span class="badge-available px-2.5 py-1 text-xs font-bold rounded-full">Tersedia</span>
                            @else
                                <span class="badge-maintenance px-2.5 py-1 text-xs font-bold rounded-full">Maintenance</span>
                            @endif
                        </div>
                    </div>

                    {{-- Court Info --}}
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 font-heading group-hover:text-court-blue transition-colors">{{ $court->name }}</h3>

                        @if ($court->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-2 flex-1">{{ $court->description }}</p>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        {{-- Rating --}}
                        <div class="flex items-center gap-1 mb-5">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $court->average_rating ? 'text-[var(--color-accent)]' : 'text-gray-200 dark:text-gray-600' }} text-base">★</span>
                            @endfor
                            <span class="text-xs text-gray-400 dark:text-gray-500 ml-1.5">({{ $court->reviews_count ?? $court->reviews->count() }} ulasan)</span>
                        </div>

                        {{-- Price & CTA --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-slate-dark">
                            <div>
                                <span class="text-xs text-gray-400 dark:text-gray-500 block">Tarif per jam</span>
                                <span class="text-xl font-extrabold text-[var(--color-accent)] font-heading">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('courts.show', $court->id) }}" wire:navigate
                                class="bg-court-blue hover:bg-court-blue-dark text-white font-bold px-4 py-2.5 rounded-xl text-sm font-heading">
                                Lihat Detail
                            </a>
                        </div>

                        @if (auth()->check() && auth()->user()->isAdmin())
                            <div class="flex items-center gap-4 mt-4 pt-3 border-t border-gray-200 dark:border-slate-dark">
                                <a href="{{ route('courts.edit', $court->id) }}" wire:navigate class="text-xs font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white transition-colors">Edit Lapangan</a>
                                <form method="POST" action="{{ route('courts.destroy', $court->id) }}" onsubmit="return confirm('Yakin hapus lapangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-300 transition-colors cursor-pointer">Hapus</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-flat p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <p class="text-gray-400 dark:text-gray-500 font-medium mb-4">Tidak ada lapangan yang sesuai dengan filter Anda.</p>
            @if ($search !== '' || $minPrice !== null || $maxPrice !== null || $statusFilter !== '')
                <button wire:click="resetFilters" class="text-sm font-bold text-court-blue hover:text-gray-900 dark:hover:text-white transition-colors cursor-pointer">Reset Semua Filter</button>
            @endif
        </div>
    @endif

</div>
