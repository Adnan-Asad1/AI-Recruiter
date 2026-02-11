<x-guest-layout>
   
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-3xl font-bold text-center text-indigo-800 mb-6">Welcome Back</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center text-green-600" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input
                        id="email"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="text-sm text-red-500 mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input
                        id="password"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="text-sm text-red-500 mt-1" />
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center space-x-2 text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" class="form-checkbox text-indigo-600" name="remember">
                        <span>{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div>
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                    Login
                </button>
                </div>

                <!-- Register Link -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">{{ __('Register') }}</a>
                </p>
            </form>
        </div>
  
</x-guest-layout>
