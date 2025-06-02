<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <body class="font-display antialiased">
    <div class="min-h-screen bg-base">
        <!-- Header / Navbar -->
        <header>
            <nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-primary-dark py-2.5 m-4 md:mx-6 max-w-screen-xl:rounded-full rounded-2xl shadow-lg px-4 sm:px-6 md:px-8">
                <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto gap-4 md:gap-2">
                    <!-- Hamburger Menu -->
                    <button @click="open = !open" class="sm:hidden inline-flex h-8 w-8 items-center justify-center rounded-md p-2 text-accent bg-primary-soft hover:bg-accent hover:text-light focus:outline-none focus:ring-2 focus:ring-inset focus:ring-light">
                        <i class="fa fa-bars fa-lg" :class="{ 'hidden': open, 'inline-flex': !open }"></i>
                        <i class="fa-solid fa-xmark" :class="{ 'hidden': !open, 'inline-flex': open }"></i>
                    </button>

                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-light" />
                        <span class="self-center text-xl md:text-lg font-semibold whitespace-nowrap text-light">ArthaPlan</span>
                    </a>

                    <!-- Navigation Links (Desktop Only) -->
                    <div class="hidden space-x-3 sm:-my-px sm:flex items-center justify-between w-full md:flex sm:w-auto md:order-1">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Beranda') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('transactions')" :active="request()->routeIs('transactions')">
                            {{ __('Riwayat') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Anggaran') }}
                        </x-nav-link>
                    </div>

                    <!-- Desktop Auth Buttons (Hidden on sm/md) -->
                    <div class="hidden lg:flex items-center md:order-2 space-x-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}">
                                    <x-primary-button class="bg-primary">Dashboard</x-primary-button>
                                </a>
                            @else
                                <a href="{{ route('login') }}">
                                    <x-primary-button class="bg-accent">Login</x-primary-button>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">
                                        <x-primary-button class="bg-primary">Sign Up</x-primary-button>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Responsive Mobile Menu -->
                <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Beranda') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Laporan') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('transactions')" :active="request()->routeIs('transactions')">
                            {{ __('Riwayat') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Anggaran') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Mobile Auth Buttons -->
                    <div class="pt-3 pb-4 border-t border-gray-200 space-y-2">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="block">
                                    <x-primary-button class="w-full bg-primary">Dashboard</x-primary-button>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block">
                                    <x-primary-button class="w-full bg-accent">Login</x-primary-button>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block">
                                        <x-primary-button class="w-full bg-primary">Sign Up</x-primary-button>
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main -->
        <main>
            <div class="p-6 mt-[90px] sm:mt-[70px]">
                {{-- Konten di sini --}}
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="pt-4 pb-2 text-center text-sm lg:text-md font-medium text-light bg-primary-dark">
        <p>&copy; 2025 Money Manager. All rights reserved.</p>
        <p class="mt-1">
            Designed by
            <a href="#" class="text-accent hover:font-medium hover:bg-accent hover:text-primary rounded-2xl px-2 transition duration-300 ease-in-out">
                Pemrograman Web Team
            </a>
        </p>
    </footer>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

    </body>
</html>
