<x-layouts::auth :title="__('Masuk')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-[#0052CC] font-heading">Selamat Datang Kembali</h2>
            <p class="text-sm text-slate-600 font-medium">Masuk ke akun PadelSpot Anda untuk kelola booking</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <flux:input
                name="email"
                :label="__('Alamat Email')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@email.com"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Kata Sandi')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Kata Sandi')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <a class="absolute top-0 right-0 text-xs font-semibold text-[#0052CC] hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <flux:checkbox name="remember" :label="__('Ingat saya')" :checked="old('remember')" />

            <button type="submit" class="w-full bg-[#FF6600] hover:bg-[#E55C00] active:scale-[0.98] text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-orange-500/30 transition-all text-center cursor-pointer font-heading text-base mt-2" data-test="login-button">
                Masuk ke Akun
            </button>
        </form>

        <div class="text-sm text-center text-slate-600 font-medium">
            <span>Belum memiliki akun?</span>
            <a href="{{ route('register') }}" class="font-bold text-[#FF6600] hover:underline ml-1" wire:navigate>Daftar sekarang</a>
        </div>
    </div>
</x-layouts::auth>