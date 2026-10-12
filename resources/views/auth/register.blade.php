<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-10 bg-gray-50 px-4">
        
        <!-- Kartu Form Register -->
        <div class="w-full sm:max-w-md bg-white px-8 py-8 shadow-xl rounded-3xl border border-gray-100">
            
            <!-- Icon Kepala & Dada di atas judul -->
            <div class="flex justify-center mb-3">
                <div class="w-14 h-14 bg-emerald-50 text-[#134e32] rounded-full flex items-center justify-center border border-emerald-100 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <!-- Judul -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Create Account</h2>
                <p class="text-xs text-gray-400 mt-1">Join us today! Fill in the details to get started.</p>
            </div>

            <!-- Form Validation Errors -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Full Name -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Full Name</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-gray-400 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#134e32] focus:ring-2 focus:ring-emerald-100 outline-none transition">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Email Address -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Email Address</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-gray-400 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#134e32] focus:ring-2 focus:ring-emerald-100 outline-none transition">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-gray-400 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="Enter your phone number" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#134e32] focus:ring-2 focus:ring-emerald-100 outline-none transition">
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Gender (Laki-laki & Perempuan) -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Gender</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50/50 hover:bg-emerald-50/40 cursor-pointer transition has-[:checked]:border-[#134e32] has-[:checked]:bg-emerald-50/60">
                            <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} class="text-[#134e32] focus:ring-emerald-500" required>
                            <span class="ml-2.5 text-xs font-semibold text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50/50 hover:bg-emerald-50/40 cursor-pointer transition has-[:checked]:border-[#134e32] has-[:checked]:bg-emerald-50/60">
                            <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="text-[#134e32] focus:ring-emerald-500">
                            <span class="ml-2.5 text-xs font-semibold text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-gray-400 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="Create a password" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#134e32] focus:ring-2 focus:ring-emerald-100 outline-none transition">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Confirm Password</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-3.5 text-gray-400 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" 
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#134e32] focus:ring-2 focus:ring-emerald-100 outline-none transition">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Terms & Conditions Checkbox -->
                <div class="flex items-start pt-1">
                    <input id="terms" type="checkbox" name="terms" required class="mt-0.5 w-4 h-4 text-[#134e32] border-gray-300 rounded focus:ring-emerald-500">
                    <label for="terms" class="ml-2 text-xs text-gray-600 leading-relaxed">
                        I agree to the <a href="#" class="text-[#134e32] hover:underline font-medium">terms & conditions</a> and <a href="#" class="text-[#134e32] hover:underline font-medium">privacy policy</a>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('terms')" class="mt-1 text-xs text-red-500" />

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-3 py-3 bg-[#134e32] hover:bg-[#0b2f1f] text-white font-semibold rounded-xl shadow-md transition duration-200 cursor-pointer text-sm">
                    Sign Up
                </button>

                <!-- Footer Link to Login -->
                <div class="text-center pt-2">
                    <p class="text-xs text-gray-500">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-[#134e32] font-semibold hover:underline">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>