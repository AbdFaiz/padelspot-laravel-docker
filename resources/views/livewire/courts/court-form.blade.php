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
