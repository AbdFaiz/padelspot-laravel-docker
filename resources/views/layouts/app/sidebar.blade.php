<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen font-sans antialiased bg-sand text-gray-900 dark:bg-midnight dark:text-slate-100">

        <flux:sidebar sticky collapsible="mobile"
            class="bg-white dark:bg-midnight border-r border-gray-200 dark:border-slate-dark">

            {{-- Sidebar Header --}}
            <flux:sidebar.header class="border-b border-gray-200 dark:border-slate-dark pb-4 pt-1">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" />
            </flux:sidebar.header>

            {{-- Navigation --}}
            <flux:sidebar.nav class="mt-3 px-2">
                <flux:sidebar.group
                    :heading="__('Menu')"
                    class="grid [&_.flux-sidebar-group-heading]:text-gray-400 dark:[&_.flux-sidebar-group-heading]:text-gray-500 [&_.flux-sidebar-group-heading]:text-[10px] [&_.flux-sidebar-group-heading]:uppercase [&_.flux-sidebar-group-heading]:tracking-widest [&_.flux-sidebar-group-heading]:font-bold [&_.flux-sidebar-group-heading]:px-2 [&_.flux-sidebar-group-heading]:mb-1">

                    <flux:sidebar.item icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="map-pin"
                        :href="route('courts.index')"
                        :current="request()->routeIs('courts.*')"
                        wire:navigate>
                        {{ __('Lapangan') }}
                    </flux:sidebar.item>

                    @auth
                        <flux:sidebar.item icon="calendar"
                            :href="route('bookings.index')"
                            :current="request()->routeIs('bookings.*')"
                            wire:navigate>
                            {{ __('Booking Saya') }}
                        </flux:sidebar.item>

                        @if (auth()->user()->isAdmin())
                            <div class="h-px bg-gray-200 dark:bg-slate-dark my-3 mx-2"></div>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 dark:text-gray-500 font-bold px-2 mb-1">Admin</p>

                            <flux:sidebar.item icon="clipboard-document-check"
                                :href="route('admin.bookings.index')"
                                :current="request()->routeIs('admin.bookings.*')"
                                wire:navigate>
                                {{ __('Kelola Booking') }}
                            </flux:sidebar.item>

                            <flux:sidebar.item icon="banknotes"
                                :href="route('admin.payments.index')"
                                :current="request()->routeIs('admin.payments.*')"
                                wire:navigate>
                                {{ __('Kelola Pembayaran') }}
                            </flux:sidebar.item>
                        @endif
                    @endauth
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            {{-- User Profile at Bottom --}}
            @auth
                <div class="border-t border-gray-200 dark:border-slate-dark pt-3 pb-2 px-2">
                    <x-desktop-user-menu class="hidden lg:block" />
                </div>
            @endauth
        </flux:sidebar>

        {{-- Mobile Header --}}
        @auth
        <flux:header class="lg:hidden border-b border-gray-200 dark:border-slate-dark bg-white dark:bg-midnight">
            <flux:sidebar.toggle class="lg:hidden text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300" icon="bars-2" inset="left" />

            <div class="flex items-center gap-2 mx-auto">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-court-blue text-white">
                    <x-app-logo-icon class="w-4 h-4" />
                </span>
                <span class="font-bold text-gray-900 dark:text-white text-sm font-heading">PadelSpot</span>
            </div>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    class="text-gray-600 dark:text-gray-300"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
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
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer" data-test="logout-button">
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
