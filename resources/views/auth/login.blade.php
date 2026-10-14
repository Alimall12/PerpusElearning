<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-[#038666] text-[#FBB02D] shadow-sm focus:ring-[#038666]" name="remember">
                <span class="ms-2 text-sm text-[#081C15]">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#038666] hover:text-[#1B4322] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#038666]" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full mt-4">
            {{ __('Log in') }}
        </x-primary-button>
    </form>
    
    <!-- Divider -->
    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500">Atau login dengan</span>
        </div>
    </div>
    
    <!-- Google Login Button -->
    <button id="googleLoginBtn" type="button" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-md shadow-sm bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#038666] transition">
        <svg class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        <span class="text-gray-700 font-medium">Login dengan Google</span>
    </button>
    
    @if (Route::has('register'))
        <div class="text-center mt-4">
            <a class="underline text-sm text-[#038666] hover:text-[#1B4322] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#038666]" href="{{ route('register') }}">
                Belum punya akun? Daftar
            </a>
        </div>
    @endif
    
    <div id="firebaseError" class="mt-3 text-sm text-red-600 hidden"></div>
    
    <script>
        document.getElementById('googleLoginBtn').addEventListener('click', async () => {
            const btn = document.getElementById('googleLoginBtn');
            const errorDiv = document.getElementById('firebaseError');
            
            btn.disabled = true;
            btn.innerHTML = '<span class="text-gray-700">Loading...</span>';
            errorDiv.classList.add('hidden');
            
            try {
                const provider = new firebase.auth.GoogleAuthProvider();
                const result = await firebase.auth().signInWithPopup(provider);
                const idToken = await result.user.getIdToken();
                
                const response = await fetch('/auth/firebase/callback', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ idToken: idToken })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.error || 'Login gagal');
                }
            } catch (error) {
                console.error('Firebase login error:', error);
                errorDiv.textContent = 'Login gagal: ' + error.message;
                errorDiv.classList.remove('hidden');
                
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg><span class="text-gray-700 font-medium">Login dengan Google</span>';
            }
        });
    </script>
</x-guest-layout>
