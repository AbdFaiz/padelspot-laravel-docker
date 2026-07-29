<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#0052CC] font-sans antialiased selection:bg-[#FF6600] selection:text-white flex items-center justify-center relative overflow-hidden">
        {{-- Ambient Background Glow & Court Pattern --}}
        <div class="absolute inset-0 z-0">
            <img src="/images/padel_hero_bg.jpg" alt="Background" class="w-full h-full object-cover filter brightness-[0.75] opacity-40">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0052CC]/90 via-[#003B99]/85 to-[#002666]/95"></div>
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#FF6600]/25 rounded-full blur-[140px] pointer-events-none"></div>
        </div>

        <div class="relative z-10 flex min-h-svh w-full flex-col items-center justify-center p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                {{-- Brand Header --}}
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-3 group" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#FF6600] text-white shadow-xl shadow-orange-500/40 group-hover:scale-105 transition-transform">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl overflow-hidden p-8 sm:p-10">
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