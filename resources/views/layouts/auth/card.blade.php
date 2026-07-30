<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-court-blue font-sans antialiased selection:bg-court-blue selection:text-white flex items-center justify-center relative overflow-hidden">
        {{-- Clean flat gradient background --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-court-blue via-court-blue-dark to-court-blue-dark"></div>
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-ball-yellow/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-white/5 rounded-full blur-[140px] pointer-events-none"></div>
        </div>

        <div class="relative z-10 flex min-h-svh w-full flex-col items-center justify-center p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                {{-- Brand Header --}}
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 group" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 text-white">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none">
                            <circle cx="7" cy="7" r="3" fill="currentColor"/>
                            <circle cx="17" cy="7" r="3" fill="currentColor"/>
                            <circle cx="7" cy="17" r="3" fill="currentColor"/>
                            <circle cx="17" cy="17" r="3" fill="currentColor"/>
                            <path d="M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="text-2xl font-extrabold text-white tracking-tight font-heading">{{ config('app.name', 'PadelSpot') }}</span>
                </a>

                {{-- Auth Form Card --}}
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden p-8 sm:p-10">
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
