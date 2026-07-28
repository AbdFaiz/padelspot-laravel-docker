<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-neutral-950">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col p-10 lg:flex bg-gradient-to-br from-emerald-950 via-neutral-900 to-neutral-950">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full blur-[128px]"></div>
                    <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-400 rounded-full blur-[128px]"></div>
                </div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-2 text-lg font-medium text-white" wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-600">
                        <span class="text-white font-bold">PS</span>
                    </span>
                    PadelSpot
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg" class="text-white/90">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer><flux:heading class="text-emerald-400/80">{{ trim($author) }}</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-600 shadow-lg shadow-emerald-500/20">
                            <span class="text-white font-bold">PS</span>
                        </span>
                        <span class="text-sm font-semibold text-neutral-900 dark:text-white">PadelSpot</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>