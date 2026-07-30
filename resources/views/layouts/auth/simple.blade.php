<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen font-sans antialiased selection:bg-court-blue selection:text-white flex items-center justify-center relative overflow-hidden bg-sand text-gray-900 dark:bg-midnight dark:text-slate-100">

        {{-- Full-bleed background — subtle padel court pattern feel --}}
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-court-blue/5 to-transparent dark:from-court-blue/10 dark:to-transparent pointer-events-none"></div>
        <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-court-blue/5 blur-[120px] dark:bg-ball-yellow/5 pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] rounded-full bg-court-blue/5 blur-[120px] dark:bg-court-blue/10 pointer-events-none"></div>

        {{-- Auth Container --}}
        <div class="relative z-10 flex min-h-svh w-full flex-col items-center justify-center p-5 md:p-10">
            <div class="flex w-full max-w-[420px] flex-col gap-7">

                {{-- Brand Logo --}}
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 group" wire:navigate>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-court-blue text-white">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <circle cx="7" cy="7" r="2.5" fill="currentColor"/>
                            <circle cx="17" cy="7" r="2.5" fill="currentColor"/>
                            <circle cx="7" cy="17" r="2.5" fill="currentColor"/>
                            <circle cx="17" cy="17" r="2.5" fill="currentColor"/>
                            <path d="M10 12H14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight font-heading">{{ config('app.name', 'PadelSpot') }}</span>
                </a>

                {{-- Auth Form Card --}}
                <div class="bg-white dark:bg-slate-dark border border-gray-200 dark:border-slate-dark rounded-2xl p-8 sm:p-9 text-gray-900 dark:text-slate-100">
                    {{ $slot }}
                </div>

                {{-- Back to home --}}
                <p class="text-center text-xs text-gray-400 dark:text-gray-500">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-court-blue dark:hover:text-ball-yellow transition-colors">← Kembali ke Beranda</a>
                </p>
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
