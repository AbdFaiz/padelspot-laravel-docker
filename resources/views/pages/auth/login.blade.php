<x-layouts::auth :title="__('Masuk')">
    <div class="flex flex-col gap-6">
        {{-- Header --}}
        <div class="flex flex-col text-center space-y-1.5">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Masuk ke akun PadelSpot Anda</p>
        </div>

        <x-auth-session-status class="text-center text-sm text-court-green" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
            @csrf

            {{-- Email --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="nama@email.com"
                    class="input-flat rounded-xl px-4 py-3 text-sm"
                >
                @error('email')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" wire:navigate class="text-xs font-semibold text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow transition-colors">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Kata Sandi"
                    class="input-flat rounded-xl px-4 py-3 text-sm"
                >
                @error('password')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <label class="flex items-center gap-2.5 cursor-pointer group">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-court-blue focus:ring-court-blue">
                <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors">Ingat saya</span>
            </label>

            <button type="submit"
                class="w-full bg-court-blue hover:bg-court-blue-dark text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center cursor-pointer font-heading text-sm mt-1"
                data-test="login-button">
                Masuk ke Akun
            </button>
        </form>

        <div class="text-sm text-center text-gray-500 dark:text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="font-bold text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow ml-1 transition-colors">Daftar sekarang</a>
        </div>
    </div>
</x-layouts::auth>
