<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex-grow flex items-center justify-center">
        <div
          class="relative w-[768px] bg-light min-h-[500px] rounded-2xl shadow-xl overflow-hidden">

          <!-- Sign In Form -->
          <div
            class="sign-in-form absolute w-1/2 h-full md:flex md:justify-center md:items-center top-0 left-0 flex flex-col justify-center items-center px-8 text-center z-2 bg-light"
          >
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-xs">
        <div class="flex-col justify-center items-center mb-4 text-center space-y-1">

            <h2 class="text-2xl font-bold">Sign In</h2>
            <span class="text-sm text-netral w-full"
            >or use your Email & Password</span>
        </div>
        <div class="">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        </div>
        @csrf

        <!-- Email Address -->
        <div class="text-start">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div  class="mt-4 text-start">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between items-center mt-4">

            <div class="block ">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded focus:ring-accent focus:border-accent shadow-sm " name="remember">
                    <span class="ms-2 text-sm text-netral">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-netral hover:text-netral-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}
            <button type="button"
        data-modal-target="resetModal"
        data-modal-toggle="resetModal"
        class="underline text-sm text-netral hover:text-netral-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
        {{ __('Forgot your password?') }}
        </button>

            </div>
                <x-secondary-button type="submit" class="w-full flex justify-center items-center mt-4">
                    {{ __('Log in') }}
                </x-secondary-button>
        </form>
            </div>

          {{-- Toggle Panel --}}
          {{-- Sign In --}}
          <div
            class="hidden md:flex absolute w-1/2 h-full top-0 left-1/2 bg-accent text-light flex flex-col justify-center items-center px-8 text-center z-10"
          >
            <div class="block flex flex-col items-center space-x-4">
             <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>      
             <h2 class="text-3xl font-bold mb-2 text-primary">
                Hello, Friend!
              </h2>
              
              <p class="text-sm mb-4">To stay connected, please login</p>
              
              <a href="{{ route('register') }}">
              <x-secondary-button class="flex justify-center items-center">
                {{ __('Sign Up') }}
                <i class="fa fa-arrow-right ml-1" aria-hidden="true"></i>
            </x-secondary-button>
             </a>
            </div>
            
           
          </div>
        </div>
        </div>

        <x-moddal id="resetModal" title="Reset Password" :name="'Reset Password'">
        <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
      </x-moddal>
</x-guest-layout>