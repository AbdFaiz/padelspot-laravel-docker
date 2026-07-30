@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'PadelSpot')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-court-blue text-white">
            <x-app-logo-icon class="w-5 h-5" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'PadelSpot')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-court-blue text-white">
            <x-app-logo-icon class="w-5 h-5" />
        </x-slot>
    </flux:brand>
@endif
