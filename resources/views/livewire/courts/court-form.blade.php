<div class="p-6 bg-[#F4F6F9] min-h-screen">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" class="text-sm font-semibold text-[#0052CC] hover:underline inline-flex items-center gap-1" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-3xl font-extrabold text-[#0052CC] font-heading mb-6">
            {{ $isEdit ? 'Edit Lapangan' : 'Tambah Lapangan Baru' }}
        </h1>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <form wire:submit="save" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Nama Lapangan</label>
                    <input type="text" wire:model="name" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4" placeholder="Contoh: Lapangan A (Indoor Panoramic)">
                    @error('name') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                    <textarea wire:model="description" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm p-3" rows="3" placeholder="Fasilitas dan deskripsi singkat lapangan..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Harga per Jam (Rp)</label>
                        <input type="number" wire:model="pricePerHour" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4" min="0">
                        @error('pricePerHour') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                        <select wire:model="status" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                            <option value="available">Tersedia</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Hari Operasional</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($days as $key => $label)
                            <label class="flex items-center gap-2 px-3.5 py-2 bg-[#F4F6F9] rounded-xl border border-slate-200 cursor-pointer hover:border-[#FF6600] transition-colors">
                                <input type="checkbox" wire:model="days" value="{{ $key }}" class="rounded text-[#FF6600] focus:ring-[#FF6600]">
                                <span class="text-xs font-bold text-slate-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('days') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Jam Buka</label>
                        <input type="time" wire:model="openTime" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                        @error('openTime') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Jam Tutup</label>
                        <input type="time" wire:model="closeTime" class="w-full rounded-xl border-slate-300 focus:border-[#FF6600] focus:ring-2 focus:ring-[#FF6600]/30 text-sm py-2.5 px-4">
                        @error('closeTime') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Foto Lapangan (maks. 5)</label>

                    @if (count($existingImages) > 0 || count($newImages) > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 mb-3">
                            @foreach ($existingImages as $image)
                                <div class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-square">
                                    <img src="{{ Storage::url($image['image_path']) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition">
                                        <button type="button" wire:click="removeExistingImage({{ $image['id'] }})"
                                            onclick="return confirm('Hapus foto ini?')"
                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs items-center justify-center hidden group-hover:flex cursor-pointer">✕</button>
                                        <button type="button" wire:click="setPrimary({{ $image['id'] }})"
                                            class="absolute bottom-1 left-1 px-1.5 py-0.5 text-xs font-bold rounded cursor-pointer
                                                {{ $primaryImageId === $image['id']
                                                    ? 'bg-[#FF6600] text-white'
                                                    : 'bg-black/50 text-white opacity-0 group-hover:opacity-100' }} transition">
                                            {{ $primaryImageId === $image['id'] ? '★ Utama' : '★ Utama' }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($newImages as $index => $image)
                                <div class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-square">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition">
                                        <button type="button" wire:click="removeNewImage({{ $index }})"
                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs items-center justify-center hidden group-hover:flex cursor-pointer">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (count($existingImages) + count($newImages) < 5)
                        <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer hover:border-[#FF6600] transition-colors bg-[#F4F6F9]">
                            <svg class="w-7 h-7 text-[#FF6600] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs font-bold text-slate-700">Upload Foto Lapangan</span>
                            <input type="file" wire:model="newImages" accept="image/jpeg,image/png,image/webp" multiple class="hidden">
                        </label>
                    @endif

                    <p class="text-xs text-slate-500 mt-1.5">Format: JPG, PNG, WebP. Maks. 2MB per foto.</p>
                    @error('newImages') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    @error('newImages.*') <p class="text-xs text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="bg-[#FF6600] hover:bg-[#E55C00] text-white font-bold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/30 transition-all font-heading text-sm cursor-pointer">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Lapangan' }}
                    </button>
                    <a href="{{ route('courts.index') }}" class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 rounded-xl hover:bg-slate-100 transition-all" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

