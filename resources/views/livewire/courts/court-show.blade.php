@php $initialImage = $court->images->where('is_primary', true)->first()?->id ?? ($court->images->first()?->id ?? 'null'); @endphp
<div class="p-6 bg-[#F4F6F9] min-h-screen" x-data="{ activeImage: {{ $initialImage }} }">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" class="text-sm font-semibold text-[#0052CC] hover:underline inline-flex items-center gap-1" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                {{-- Image Gallery --}}
                @if ($court->images->count())
                    <div class="aspect-video bg-slate-100 relative overflow-hidden">
                        @foreach ($court->images as $image)
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $court->name }}"
                                class="w-full h-full object-cover absolute inset-0 transition-opacity duration-300"
                                :class="activeImage === {{ $image->id }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                        @endforeach
                    </div>
                    @if ($court->images->count() > 1)
                        <div class="flex gap-2 p-3 overflow-x-auto bg-slate-50">
                            @foreach ($court->images as $image)
                                <button type="button" @click="activeImage = {{ $image->id }}"
                                    class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition cursor-pointer"
                                    :class="activeImage === {{ $image->id }} ? 'border-[#FF6600]' : 'border-transparent hover:border-slate-300'">
                                    <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-video bg-gradient-to-br from-[#0052CC] to-[#003B99] flex items-center justify-center text-white">
                        <span class="text-6xl">🏓</span>
                    </div>
                @endif

                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-3xl font-extrabold text-slate-900 font-heading">{{ $court->name }}</h1>
                        @if ($court->status === 'available')
                            <span class="px-3.5 py-1 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-sm">Tersedia</span>
                        @else
                            <span class="px-3.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-full shadow-sm">Maintenance</span>
                        @endif
                    </div>

                    @if ($court->description)
                        <p class="text-slate-600 mb-8 text-base leading-relaxed">{{ $court->description }}</p>
                    @endif

                    {{-- Schedules --}}
                    <div class="mb-8 p-5 bg-[#F4F6F9] rounded-2xl border border-slate-200">
                        <h3 class="font-bold text-slate-900 mb-4 font-heading text-lg">Jam Operasional</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach ($court->schedules as $schedule)
                                <div class="bg-white rounded-xl p-3 text-center border border-slate-200 shadow-xs">
                                    <div class="text-xs font-bold text-[#0052CC] uppercase tracking-wider">{{ substr($schedule->day, 0, 3) }}</div>
                                    <div class="text-sm font-semibold text-slate-800 mt-1">{{ $schedule->open_time }} - {{ $schedule->close_time }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div>
                        <h3 class="font-bold text-slate-900 mb-4 font-heading text-lg">Ulasan Pelanggan ({{ $court->reviews->count() }})</h3>

                        {{-- Review Form --}}
                        @auth
                            @if (!$court->reviews->where('user_id', auth()->id())->first())
                                <div class="bg-white rounded-2xl p-5 mb-6 border border-slate-200 shadow-sm">
                                    <div class="flex items-center gap-1 mb-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button wire:click="$set('rating', {{ $i }})" class="text-2xl cursor-pointer {{ $i <= $this->rating ? 'text-[#FF6600]' : 'text-slate-300' }}">★</button>
                                        @endfor
                                    </div>
                                    <textarea
                                        wire:model="comment"
                                        placeholder="Tulis ulasan Anda tentang pengalaman bermain di lapangan ini..."
                                        class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm p-3"
                                        rows="3"
                                    ></textarea>
                                    <div class="mt-3 text-right">
                                        <button wire:click="submitReview" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-5 py-2.5 rounded-xl shadow-md transition-all text-sm font-heading cursor-pointer">
                                            Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        @forelse ($court->reviews->sortByDesc('created_at') as $review)
                            <div class="border-b border-slate-100 py-4 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900">{{ $review->user->name }}</span>
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-[#FF6600]' : 'text-slate-300' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    @auth
                                        @if ($review->user_id === auth()->id())
                                            <button wire:click="deleteReview({{ $review->id }})" onclick="return confirm('Hapus ulasan?')" class="text-xs font-semibold text-red-600 hover:text-red-800 cursor-pointer">Hapus</button>
                                        @endif
                                    @endauth
                                </div>
                                @if ($review->comment)
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                                @endif
                                <p class="text-xs text-slate-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Belum ada ulasan untuk lapangan ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Booking Card --}}
        <div>
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-lg sticky top-6">
                <div class="text-center mb-6">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Tarif Sewa</span>
                    <p class="text-3xl font-extrabold text-[#FF6600] font-heading">Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}</p>
                    <p class="text-sm text-slate-500 font-medium">per jam</p>
                </div>

                <div class="flex items-center justify-center gap-1 mb-6 py-2 bg-[#F4F6F9] rounded-xl border border-slate-200">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $court->average_rating)
                            <span class="text-[#FF6600] text-lg">★</span>
                        @else
                            <span class="text-slate-300 text-lg">★</span>
                        @endif
                    @endfor
                    <span class="text-sm font-bold text-slate-700 ml-1.5">{{ number_format($court->average_rating, 1) }} / 5.0</span>
                </div>

                @auth
                    @if ($court->status === 'available')
                        <a href="{{ route('bookings.create') . '?court=' . $court->id }}" class="w-full bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-orange-500/40 hover:shadow-orange-500/60 transition-all text-center block font-heading text-base" wire:navigate>
                            Booking Sekarang
                        </a>
                    @else
                        <div class="text-center text-sm font-semibold text-amber-600 bg-amber-50 py-3 rounded-xl border border-amber-200">
                            Lapangan sedang maintenance
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-orange-500/40 transition-all text-center block font-heading text-base" wire:navigate>
                        Masuk untuk Booking
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

