<div class="page-bg p-6 lg:p-8">
    <div class="mb-6">
        <a href="{{ route('courts.index') }}" wire:navigate
            class="text-sm font-semibold text-court-blue hover:text-gray-900 dark:hover:text-white inline-flex items-center gap-1.5 transition-colors">
            ← Kembali ke Daftar Lapangan
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white font-heading mb-6">
            {{ $isEdit ? 'Edit Lapangan' : 'Tambah Lapangan Baru' }}
        </h1>

        <div class="card-flat p-6 sm:p-8">
            <form wire:submit="save" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Nama Lapangan</label>
                    <input type="text" wire:model="name" class="input-flat" placeholder="Contoh: Lapangan A (Indoor Panoramic)">
                    @error('name') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Deskripsi</label>
                    <textarea wire:model="description" class="input-flat" rows="3" placeholder="Fasilitas dan deskripsi singkat lapangan..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Harga per Jam (Rp)</label>
                        <input type="number" wire:model="pricePerHour" class="input-flat" min="0">
                        @error('pricePerHour') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
                        <select wire:model="status" class="input-flat">
                            <option value="available">Tersedia</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Hari Operasional</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($days as $key => $label)
                            <label class="flex items-center gap-2 px-3.5 py-2 option-flat {{ in_array($key, old('days', $this->days ?? [])) ? 'option-flat-active' : '' }}">
                                <input type="checkbox" wire:model="days" value="{{ $key }}" class="rounded text-[var(--color-accent)] focus:ring-[var(--color-accent)] bg-white/10 border-white/20">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('days') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Jam Buka</label>
                        <input type="time" wire:model="openTime" class="input-flat">
                        @error('openTime') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1.5">Jam Tutup</label>
                        <input type="time" wire:model="closeTime" class="input-flat">
                        @error('closeTime') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-2">Foto Lapangan (maks. 5)</label>

                    @if (count($existingImages) > 0 || count($newImages) > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 mb-3">
                            @foreach ($existingImages as $image)
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 dark:border-slate-dark aspect-square bg-court-blue-dark">
                                    <img src="{{ Storage::url($image['image_path']) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                                        <button type="button" wire:click="removeExistingImage({{ $image['id'] }})"
                                            onclick="return confirm('Hapus foto ini?')"
                                            class="w-6 h-6 bg-red-500 text-white rounded-full text-xs items-center justify-center hidden group-hover:flex cursor-pointer">✕</button>
                                        <button type="button" wire:click="setPrimary({{ $image['id'] }})"
                                            class="px-1.5 py-0.5 text-xs font-bold rounded cursor-pointer
                                                {{ $primaryImageId === $image['id']
                                                    ? 'bg-[var(--color-accent)] text-white'
                                                    : 'bg-black/50 text-gray-700 dark:text-gray-300 hidden group-hover:block' }} transition">
                                            {{ $primaryImageId === $image['id'] ? '★ Utama' : 'Jadikan Utama' }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($newImages as $index => $image)
                                <div class="relative group rounded-xl overflow-hidden border border-gray-200 dark:border-slate-dark aspect-square bg-court-blue-dark">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                                        <button type="button" wire:click="removeNewImage({{ $index }})"
                                            class="w-6 h-6 bg-red-500 text-white rounded-full text-xs hidden group-hover:flex items-center justify-center cursor-pointer">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (count($existingImages) + count($newImages) < 5)
                        <label class="upload-flat flex flex-col items-center justify-center w-full h-28">
                            <svg class="w-7 h-7 text-[var(--color-accent)] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Upload Foto Lapangan</span>
                            <input type="file" wire:model="newImages" accept="image/jpeg,image/png,image/webp" multiple class="hidden">
                        </label>
                    @endif

                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Format: JPG, PNG, WebP. Maks. 2MB per foto.</p>
                    @error('newImages') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                    @error('newImages.*') <p class="text-xs text-red-400 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-slate-dark">
                    <button type="submit" class="bg-[var(--color-accent)] hover:opacity-90 text-white font-bold px-6 py-3 rounded-xl transition-all font-heading text-sm cursor-pointer">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Lapangan' }}
                    </button>
                    <a href="{{ route('courts.index') }}" class="px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-200 dark:border-slate-dark hover:border-gray-300 dark:hover:border-gray-600 rounded-xl transition-all" wire:navigate>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
