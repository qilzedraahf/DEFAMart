<x-guest-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[#f7f8f2] px-4 py-8 sm:px-6 lg:flex lg:items-center lg:justify-center lg:p-4">
        <div class="mx-auto grid w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-xl shadow-green-950/10 lg:grid-cols-2">
            <div class="relative flex min-h-[250px] flex-col justify-between overflow-hidden bg-[#174b35] p-8 text-white sm:p-12 lg:min-h-[460px]">
                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border-[35px] border-white/5"></div>
                <div class="absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-[#a8c99b]/10"></div>

                <a href="/" class="relative text-2xl font-extrabold tracking-tight">
                    DEFA<span class="text-[#c6e2a8]">Mart.</span>
                </a>

                <div class="relative my-8">
                    <span class="mb-5 inline-block rounded-full bg-white/10 px-4 py-2 text-sm text-green-100">
                        Belanja lebih mudah
                    </span>
                    <h1 class="max-w-md text-3xl font-bold leading-tight sm:text-4xl">
                        Kebutuhan harianmu, semua ada di sini.
                    </h1>
                    <p class="mt-4 max-w-md leading-7 text-green-100/80">
                        Temukan berbagai kebutuhan pilihanmu dan nikmati pengalaman belanja yang praktis bersama DEFAMart.
                    </p>
                </div>

                <p class="relative text-sm text-green-100/70">
                    Belanja nyaman, kebutuhan terpenuhi.
                </p>
            </div>

            <div class="flex items-center p-6 sm:p-10 lg:p-12">
                <div class="w-full">
                    <div class="mb-8">
                        <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-[#568264]">
                            Selamat datang
                        </p>
                        <h2 class="text-3xl font-bold text-gray-800">
                            Selamat Datang Kembali!
                        </h2>
                        <p class="mt-3 text-sm leading-6 text-gray-500">
                            Masuk ke akun DEFAMart kamu dan lanjutkan belanjamu.
                        </p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">
                                Alamat Email
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                required autofocus autocomplete="username"
                                placeholder="nama@email.com"
                                class="w-full rounded-xl border border-gray-200 bg-[#fbfcf9] px-4 py-3.5 text-sm outline-none transition focus:border-[#39734d] focus:ring-2 focus:ring-[#39734d]/15">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">
                                Kata Sandi
                            </label>
                            <input id="password" type="password" name="password"
                                required autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full rounded-xl border border-gray-200 bg-[#fbfcf9] px-4 py-3.5 text-sm outline-none transition focus:border-[#39734d] focus:ring-2 focus:ring-[#39734d]/15">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                            <label for="remember_me" class="flex items-center gap-2 text-gray-600">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-[#174b35] focus:ring-[#174b35]">
                                Ingat saya
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="font-semibold text-[#286342] hover:text-[#174b35]">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-[#174b35] px-4 py-3.5 font-semibold text-white shadow-lg shadow-green-950/10 transition hover:bg-[#103b29] focus:outline-none focus:ring-2 focus:ring-[#39734d] focus:ring-offset-2">
                            Masuk ke Akun
                        </button>
                    </form>

                    <p class="mt-7 text-center text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold text-[#286342] hover:underline">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>



