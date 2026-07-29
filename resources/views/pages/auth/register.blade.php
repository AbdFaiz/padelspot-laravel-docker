<x-layouts::auth :title="__('Daftar')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col text-center space-y-1">
            <h2 class="text-2xl font-extrabold text-[#0052CC] font-heading">Buat Akun Baru</h2>
            <p class="text-sm text-slate-600 font-medium">Daftar sekarang untuk mulai memesan lapangan padel</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf

            <flux:input
                name="name"
                :label="__('Nama Lengkap')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama Lengkap"
            />

            <flux:input
                name="email"
                :label="__('Alamat Email')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="nama@email.com"
            />

            <flux:input
                name="phone"
                :label="__('Nomor WhatsApp / HP')"
                :value="old('phone')"
                type="tel"
                autocomplete="tel"
                placeholder="081234567890"
            />

            <flux:input
                name="password"
                :label="__('Kata Sandi')"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Buat Kata Sandi"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <flux:input
                name="password_confirmation"
                :label="__('Konfirmasi Kata Sandi')"
                type="password"
                required
                autocomplete="new-password"
                placeholder="Ulangi Kata Sandi"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <button type="submit" class="w-full bg-[#FF6600] hover:bg-[#E55C00] active:scale-[0.98] text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-orange-500/30 transition-all text-center cursor-pointer font-heading text-base mt-2" data-test="register-user-button">
                Daftar Akun Gratis
            </button>
        </form>

        <div class="text-sm text-center text-slate-600 font-medium">
            <span>Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="font-bold text-[#FF6600] hover:underline ml-1" wire:navigate>Masuk ke Akun</a>
        </div>
    </div>
</x-layouts::auth>