<x-layouts::auth :title="__('Daftar')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col text-center space-y-1.5">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white font-heading">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Daftar gratis dan mulai booking lapangan padel</p>
        </div>

        <x-auth-session-status class="text-center text-sm text-court-green" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Lengkap"
                    class="input-flat rounded-xl px-4 py-3 text-sm">
                @error('name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com"
                    class="input-flat rounded-xl px-4 py-3 text-sm">
                @error('email') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nomor WhatsApp / HP</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="081234567890"
                    class="input-flat rounded-xl px-4 py-3 text-sm">
                @error('phone') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kata Sandi</label>
                <input type="password" name="password" required autocomplete="new-password" placeholder="Buat Kata Sandi"
                    class="input-flat rounded-xl px-4 py-3 text-sm">
                @error('password') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Kata Sandi"
                    class="input-flat rounded-xl px-4 py-3 text-sm">
            </div>

            <button type="submit"
                class="w-full bg-court-blue hover:bg-court-blue-dark text-white font-bold py-3.5 px-6 rounded-xl transition-all text-center cursor-pointer font-heading text-sm mt-1"
                data-test="register-user-button">
                Daftar Akun Gratis
            </button>
        </form>

        <div class="text-sm text-center text-gray-500 dark:text-gray-400">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" wire:navigate class="font-bold text-court-blue hover:text-court-blue-dark dark:hover:text-ball-yellow ml-1 transition-colors">Masuk ke Akun</a>
        </div>
    </div>
</x-layouts::auth>
