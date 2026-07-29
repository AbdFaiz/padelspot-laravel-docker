<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading">Daftar Lapangan Padel</h1>
            <p class="text-slate-600 mt-1">Pilih lapangan favorit Anda dan langsung lakukan reservasi online</p>
        </div>

        @if (auth()->check() && auth()->user()->isAdmin())
            <div>
                <a href="{{ route('courts.create') }}" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-5 py-2.5 rounded-xl shadow-md shadow-orange-500/30 transition-all inline-flex items-center gap-2 font-heading" wire:navigate>
                    <span>+ Tambah Lapangan</span>
                </a>
            </div>
        @endif
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-8">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Cari Lapangan</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nama atau deskripsi lapangan..."
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            <div class="w-36">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Harga Min</label>
                <input type="number" wire:model.live.debounce.500ms="minPrice" placeholder="0" min="0"
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            <div class="w-36">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Harga Max</label>
                <input type="number" wire:model.live.debounce.500ms="maxPrice" placeholder="∞" min="0"
                    class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
            </div>
            <div class="w-44">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                <select wire:model.live="statusFilter" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                    <option value="">Semua Status</option>
                    <option value="available">Tersedia</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>
            @if ($search !== '' || $minPrice !== null || $maxPrice !== null || $statusFilter !== '')
                <button wire:click="resetFilters" class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl hover:bg-slate-100 transition-all cursor-pointer">
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    @if ($courts->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($courts as $court)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div>
                    @php $primaryImage = $court->images->where('is_primary', true)->first() ?? $court->images->first(); @endphp
                    <div class="aspect-video bg-slate-100 flex items-center justify-center overflow-hidden relative">
                        @if ($primaryImage)
                            <img src="{{ Storage::url($primaryImage->image_path) }}" alt="{{ $court->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#0052CC] to-[#003B99] flex items-center justify-center text-white">
                                <span class="text-5xl">🏓</span>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            @if ($court->status === 'available')
                                <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-md">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full shadow-md">Maintenance</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="font-bold text-xl text-slate-900 mb-2 font-heading group-hover:text-[#0052CC] transition-colors">{{ $court->name }}</h3>

                        @if ($court->description)
                            <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $court->description }}</p>
                        @endif

                        <div class="flex items-center gap-1 mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $court->average_rating)
                                    <span class="text-[#FF6600] text-lg">★</span>
                                @else
                                    <span class="text-slate-300 text-lg">★</span>
                                @endif
                            @endfor
                            <span class="text-xs font-medium text-slate-500 ml-1">({{ $court->reviews_count ?? $court->reviews->count() }} ulasan)</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <div>
                            <span class="text-xs text-slate-500 block">Tarif per jam</span>
                            <span class="text-xl font-extrabold text-[#FF6600]">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('courts.show', $court->id) }}" class="bg-[#0052CC] hover:bg-[#003B99] text-white font-bold px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all text-sm font-heading" wire:navigate>
                            Lihat Detail
                        </a>
                    </div>

                    @if (auth()->check() && auth()->user()->isAdmin())
                        <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-100 text-xs">
                            <a href="{{ route('courts.edit', $court->id) }}" class="text-slate-600 hover:text-[#0052CC] font-semibold" wire:navigate>
                                Edit Lapangan
                            </a>
                            <form method="POST" action="{{ route('courts.destroy', $court->id) }}" onsubmit="return confirm('Yakin hapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold cursor-pointer">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="text-4xl mb-3">🏸</div>
            <p class="text-slate-600 font-medium mb-4">Tidak ada lapangan yang sesuai dengan filter Anda.</p>
            @if ($search !== '' || $minPrice !== null || $maxPrice !== null || $statusFilter !== '')
                <button wire:click="resetFilters" class="text-sm font-bold text-[#FF6600] hover:underline cursor-pointer">Reset Semua Filter</button>
            @endif
        </div>
    @endif
</div>
