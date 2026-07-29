<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#F4F6F9] font-sans antialiased">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-[#003B99] bg-[#0052CC]">
            <flux:sidebar.header class="border-b border-[#003B99]/60 pb-3">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden text-white/70 hover:text-white" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="mt-2">
                <flux:sidebar.group :heading="__('Menu')" class="grid [&_.flux-sidebar-group-heading]:text-white/50 [&_.flux-sidebar-group-heading]:text-[10px] [&_.flux-sidebar-group-heading]:uppercase [&_.flux-sidebar-group-heading]:tracking-widest [&_.flux-sidebar-group-heading]:font-bold">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate
                        class="text-white/80 hover:text-white hover:bg-white/10 data-[current=true]:bg-[#FF6600] data-[current=true]:text-white data-[current=true]:font-bold rounded-xl transition-all">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="map-pin" :href="route('courts.index')" :current="request()->routeIs('courts.*')" wire:navigate
                        class="text-white/80 hover:text-white hover:bg-white/10 data-[current=true]:bg-[#FF6600] data-[current=true]:text-white data-[current=true]:font-bold rounded-xl transition-all">
                        {{ __('Lapangan') }}
                    </flux:sidebar.item>

                    @auth
                        <flux:sidebar.item icon="calendar" :href="route('bookings.index')" :current="request()->routeIs('bookings.*')" wire:navigate
                            class="text-white/80 hover:text-white hover:bg-white/10 data-[current=true]:bg-[#FF6600] data-[current=true]:text-white data-[current=true]:font-bold rounded-xl transition-all">
                            {{ __('Booking Saya') }}
                        </flux:sidebar.item>

                        @if (auth()->user()->isAdmin())
                            <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.bookings.index')" :current="request()->routeIs('admin.bookings.*')" wire:navigate
                                class="text-white/80 hover:text-white hover:bg-white/10 data-[current=true]:bg-[#FF6600] data-[current=true]:text-white data-[current=true]:font-bold rounded-xl transition-all">
                                {{ __('Kelola Booking') }}
                            </flux:sidebar.item>

                            <flux:sidebar.item icon="banknotes" :href="route('admin.payments.index')" :current="request()->routeIs('admin.payments.*')" wire:navigate
                                class="text-white/80 hover:text-white hover:bg-white/10 data-[current=true]:bg-[#FF6600] data-[current=true]:text-white data-[current=true]:font-bold rounded-xl transition-all">
                                {{ __('Kelola Pembayaran') }}
                            </flux:sidebar.item>
                        @endif
                    @endauth
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            @auth
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @endauth
        </flux:sidebar>

        @auth
        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden bg-[#0052CC] border-b border-[#003B99]">
            <flux:sidebar.toggle class="lg:hidden text-white" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="text-white"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>
        @endauth

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>