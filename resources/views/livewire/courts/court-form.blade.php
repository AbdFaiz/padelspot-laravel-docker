<div class="p-6">
    <div class="mb-6">
        <flux:link :href="route('courts.index')" class="text-sm text-zinc-600 hover:text-zinc-900" wire:navigate>
            ← Kembali ke Daftar Lapangan
        </flux:link>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">
            {{ $isEdit ? 'Edit Lapangan' : 'Tambah Lapangan Baru' }}
        </h1>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Nama Lapangan</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700" placeholder="Lapangan A">
                    @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Deskripsi</label>
                    <textarea wire:model="description" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700" rows="3" placeholder="Deskripsi lapangan..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Harga per Jam (Rp)</label>
                        <input type="number" wire:model="pricePerHour" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700" min="0">
                        @error('pricePerHour') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                        <select wire:model="status" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
                            <option value="available">Tersedia</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Hari Operasional</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($days as $key => $label)
                            <label class="flex items-center gap-2 px-3 py-2 bg-zinc-50 dark:bg-zinc-700 rounded-lg cursor-pointer">
                                <input type="checkbox" wire:model="days" value="{{ $key }}" class="rounded border-zinc-300">
                                <span class="text-sm">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('days') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Jam Buka</label>
                        <input type="time" wire:model="openTime" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
                        @error('openTime') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Jam Tutup</label>
                        <input type="time" wire:model="closeTime" class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700">
                        @error('closeTime') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Foto Lapangan (maks. 5)</label>

                    @if (count($existingImages) > 0 || count($newImages) > 0)
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 mb-3">
                            @foreach ($existingImages as $image)
                                <div class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-600 aspect-square">
                                    <img src="{{ Storage::url($image['image_path']) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition">
                                        <button type="button" wire:click="removeExistingImage({{ $image['id'] }})"
                                            onclick="return confirm('Hapus foto ini?')"
                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs items-center justify-center hidden group-hover:flex">✕</button>
                                        <button type="button" wire:click="setPrimary({{ $image['id'] }})"
                                            class="absolute bottom-1 left-1 px-1.5 py-0.5 text-xs rounded
                                                {{ $primaryImageId === $image['id']
                                                    ? 'bg-yellow-400 text-yellow-900'
                                                    : 'bg-black/50 text-white opacity-0 group-hover:opacity-100' }} transition">
                                            {{ $primaryImageId === $image['id'] ? '★ Utama' : '★ Jadikan utama' }}
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($newImages as $index => $image)
                                <div class="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-600 aspect-square">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition">
                                        <button type="button" wire:click="removeNewImage({{ $index }})"
                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs items-center justify-center hidden group-hover:flex">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (count($existingImages) + count($newImages) < 5)
                        <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:border-green-400 dark:hover:border-green-500 transition">
                            <svg class="w-6 h-6 text-zinc-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            <span class="text-xs text-zinc-500">Tambah Foto</span>
                            <input type="file" wire:model="newImages" accept="image/jpeg,image/png,image/webp" multiple class="hidden">
                        </label>
                    @endif

                    <p class="text-xs text-zinc-500 mt-1">Format: JPG, PNG, WebP. Maks. 2MB per foto.</p>
                    @error('newImages') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    @error('newImages.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <flux:button type="submit" variant="primary">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Lapangan' }}
                    </flux:button>
                    <flux:link :href="route('courts.index')" class="px-4 py-2" wire:navigate>
                        Batal
                    </flux:link>
                </div>
            </form>
        </div>
    </div>
</div>
