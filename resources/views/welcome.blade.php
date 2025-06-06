<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ArthaPlan') }}</title>
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">

        <!-- Font Awesome -->
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>document.documentElement.classList.add('js')</script>
        <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>

    </head>
    <body class="font-display antialiased scroll-smooth">
        <div class="min-h-screen bg-base">
        <!-- Header / Navbar -->
        <header>
          <nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-primary-dark py-2.5 m-4 md:mx-6 max-w-screen-xl:rounded-full rounded-2xl shadow-lg px-4 sm:px-6 md:px-8" >
              <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto gap-4 md:gap-6">
                  <!-- Hamburger Menu - Show on mobile and tablet (md) -->
                  <button @click="open = !open" class="md:hidden inline-flex h-8 w-8 items-center justify-center rounded-md p-2 text-accent bg-primary-soft hover:bg-accent hover:text-light focus:outline-none focus:ring-2 focus:ring-inset focus:ring-light">
                      <i class="fa fa-bars fa-lg" :class="{ 'hidden': open, 'inline-flex': !open }"></i>
                      <i class="fa-solid fa-xmark" :class="{ 'hidden': !open, 'inline-flex': open }"></i>
                  </button>

                  <!-- Logo -->
                  <a href="#" class="flex items-center justify-center space-x-2 md:mr-4">
                      <x-application-logo class="block h-9 w-auto fill-current text-light" />
                      <span class="self-center text-xl md:text-lg font-semibold whitespace-nowrap text-light">ArthaPlan</span>
                  </a>

                  <!-- Navigation Links (Desktop Only - Show from lg up) -->
                  <div class="hidden lg:flex space-x-4 items-center justify-between w-full lg:w-auto lg:order-1">
                      <x-nav-link href="#beranda" active>
                          {{ __('Beranda') }}
                      </x-nav-link>
                      <x-nav-link href="#tentang" active>
                          {{ __('Tentang') }}
                      </x-nav-link>
                      <x-nav-link href="#fitur" active>
                          {{ __('Fitur') }}
                      </x-nav-link>
                      <x-nav-link href="#highlight" active>
                          {{ __('Highlight') }}
                      </x-nav-link>
                  </div>

                  <!-- Desktop Auth Buttons (Show from md up) -->
                  <div class="hidden md:flex items-center space-x-2 md:order-2">
                      @if (Route::has('login'))
                          @auth
                              <a href="{{ route('dashboard') }}">
                                  <x-primary-button class="rounded-lg px-4 py-2">Dashboard</x-primary-button>
                              </a>
                          @else
                              <a href="{{ route('login') }}">
                                  <x-primary-button class="rounded-lg px-3 py-1.5">Login</x-primary-button>
                              </a>
                              @if (Route::has('register'))
                                  <a href="{{ route('register') }}">
                                      <x-secondary-button class="rounded-lg px-3 py-1.5">Sign Up</x-secondary-button>
                                  </a>
                              @endif
                          @endauth
                      @endif
                  </div>
              </div>

              <!-- Responsive Mobile Menu (Show on mobile and tablet) -->
              <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
                  <div class="pt-2 pb-3 space-y-1">
                      <x-responsive-nav-link href="#beranda" active>
                          {{ __('Beranda') }}
                      </x-responsive-nav-link>
                      <x-responsive-nav-link href="#tentang" active>
                          {{ __('Tentang') }}
                      </x-responsive-nav-link>
                      <x-responsive-nav-link href="#fitur" active>
                          {{ __('Fitur') }}
                      </x-responsive-nav-link>
                      <x-responsive-nav-link href="#highlight" active>
                          {{ __('Highlight') }}
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
            <div class=" mt-[90px] sm:mt-[70px]">
<!-- Content 1 -->
    <section class="px-6 bg-base mt-[85px] sm:mt-[62px]" id="#beranda">
      <div
        class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:py-16 lg:px-12"
      >
        <a
          href="{{ route('login') }}"
          class="inline-flex items-center justify-between px-1 py-1 pr-4 text-sm text-light bg-primary rounded-full mb-7 hover:bg-primary-soft "
          role="alert"
        >
          <span class="bg-accent font-medium rounded-full px-4 py-1.5 mr-3"
            >Mulai</span
          >
          <span class="font-medium">Sekarang</span>
          <i class="fa fa-chevron-right ml-2 fa-sm" aria-hidden="true"></i>
        </a>

        <h1
          class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-dark md:text-5xl lg:text-6xl"
        >
          Kendalikan Keuangan Anda – Kelola Uang dengan Mudah dan Cerdas!
        </h1>
        <p
          class="mb-8 text-lg font-medium text-netral lg:text-xl sm:px-16 xl:px-48"
        >
          Lacak pengeluaran, buat anggaran, dan optimalkan keuangan Anda dengan
          alat manajemen keuangan yang intuitif.
        </p>
        <div
          class="flex flex-col mb-8 space-y-4 lg:mb-16 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4"
        >
          @if (Route::has('login'))
                          @auth
                              <a href="{{ route('dashboard') }}">
                                  <x-primary-button class="rounded-lg px-8 py-4">Dashboard</x-primary-button>
                              </a>
                          @else
                              <a href="{{ route('login') }}">
                                  <x-primary-button class="rounded-lg px-8 py-4">Login</x-primary-button>
                              </a>
                              @if (Route::has('register'))
                                  <a href="{{ route('register') }}">
                                      <x-secondary-button class="rounded-lg px-8 py-4">Sign Up</x-secondary-button>
                                  </a>
                              @endif
                          @endauth
                      @endif
        </div>
      </div>
    </section>

    <!-- Content 2 -->
    <section class="p-6 bg-primary-dark" id="tentang">
      <div
        class="items-center max-w-screen-xl gap-16 px-4 py-8 mx-auto lg:grid lg:grid-cols-2 lg:py-16 lg:px-6"
      >
        <div class="text-netral-light sm:text-lg">
          <h2
            class="mb-4 text-4xl font-extrabold tracking-tight text-light "
          >
            ArthaPlan
          </h2>
          <p
            class="mb-4 "
          >
            Website manajemen keuangan personal yang dirancang khusus untuk
            memudahkan pengguna mengontrol keuangan sehari-hari secara praktis
            dan menyenangkan. Berbeda dengan website finansial rumit lainnya,
            ARTHAPLAN menawarkan pengalaman pengguna yang simpel dan intuitif -
            mulai dari mencatat transaksi secepat mengunggah story media sosial
            hingga menampilkan laporan keuangan dalam grafik visual yang mudah
            dipahami.
          </p>
          <p>
            Website ini fokus pada konsep dasar pengelolaan uang yang sehat:
            penganggaran (budgeting), pelacakan pengeluaran, dan pemantauan cash
            flow, semua dalam tampilan satu halaman yang informatif.
          </p>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-8">

          <img src="{{ asset('assets/images/laporan1.png') }}"
         alt="Foto Profil" class="w-full mt-4 rounded-lg lg:mt-10">
<img src="{{ asset('assets/images/image.png') }}"
         alt="Foto Profil" class="w-full mt-4 rounded-lg lg:mt-10">
        </div>
      </div>
    </section>

    <!-- Content 3 -->
    <section class="px-6 bg-primary-soft" id="fitur">
      <div class="max-w-screen-xl px-4 py-8 mx-auto sm:py-16 lg:px-6">
        <div
          class="max-w-screen-md mb-8 lg:mb-16 "
        >
          <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-light">
            Fitur dalam ArthaPlan
          </h2>
          <p class="text-netral-light sm:text-xl">
            <strong>ArthaPlan</strong> Website finansial kekinian yang ngubah
            ngatur uang dari ribet jadi seru kayak main game, bikin kamu makin
            melek keuangan tanpa perlu jadi ahli!
          </p>
        </div>
        <div
          class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0"
        >
          <div>
            <div
              class="flex items-center justify-center w-10 h-10 mb-4 bg-accent rounded-full lg:h-12 lg:w-12"
            >
              <i
                class="fa fa-bar-chart fa-lg text-light"
                aria-hidden="true"
              ></i>
            </div>
            <h3 class="mb-2 text-xl font-bold text-light">
              Atur Anggaran Tanpa Ribet
            </h3>
            <p class="text-netral-light">
              Buat anggaran bulanan sesuai kebutuhan dan dapatkan peringatan
              otomatis saat pengeluaran hampir melebihi batas. Tidak perlu
              khawatir boros lagi!
            </p>
          </div>
          <div>
            <div
              class="flex items-center justify-center w-10 h-10 mb-4 bg-accent rounded-full lg:h-12 lg:w-12"
            >
              <i class="fa fa-file fa-lg text-light" aria-hidden="true"></i>
            </div>
            <h3 class="mb-2 text-xl font-bold text-light">
              Laporan Keuangan Jelas
            </h3>
            <p class="text-netral-light">
              Pantau semua transaksi Anda dalam bentuk grafik sederhana yang
              mudah dimengerti. Ketahui kemana uang Anda mengalir setiap
              bulannya.
            </p>
          </div>

          <div>
            <div
              class="flex items-center justify-center w-10 h-10 mb-4 bg-accent rounded-full lg:h-12 lg:w-12"
            >
              <i class="fa fa-gears fa-lg text-light" aria-hidden="true"></i>
            </div>
            <h3 class="mb-2 text-xl font-bold text-light">User-Friendly</h3>
            <p class="text-netral-light">
              Kelola uang semudah scroll Instagram - catat transaksi dalam 3
              detik, pantau budget lewat grafik warna-warni, dan nikmati fitur
              cerdas yang bikin finansialmu selalu aman!
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Content 4 -->
    <section class="px-6 bg-primary-dark" id="highlight">
      <div
        class="items-center max-w-screen-xl gap-8 px-4 py-8 mx-auto xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6"
      >
        <img
          class="w-full rounded-xl"
          src="../assets/images/Dashboard.png"
          alt="dashboard image"
        />

        <div class="mt-4 md:mt-0 ">
          <h2 class="mb-4 text-4xl font-extrabold tracking-tight text-light">
            Yuk, mulai atur uangmu dengan cara seru!
          </h2>
          <p class="mb-6 text-netral-light md:text-lg">
            Gak perlu pusing lagi ngitung uang di akhir bulan! ARTHAPLAN bantu
            kamu pantau pemasukan & pengeluaran sehari-hari dengan fitur super
            praktis.
          </p>
          <a
            href="{{ route('login') }}"
          >

                <x-primary-button class="rounded-lg " >Login<i class="fa fa-arrow-right ml-2 -mr-1" aria-hidden="true"></i>
</x-primary-button>

          </a>
        </div>
      </div>
    </section>

    <!-- footer -->
    <footer class="p-4 bg-base sm:p-6">
      <div class="max-w-screen-xl mx-auto">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
                        <x-application-logo class="block h-20 w-auto fill-current text-light" />
              <span class="self-center text-2xl font-semibold whitespace-nowrap"
                >ArthaPlan</span
              >
            </a>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
            <div>
              <h2 class="mb-6 text-sm font-semibold text-dark uppercase">
                Resources
              </h2>
              <ul class="text-netral">
                <li class="mb-4">
                  <a href="https://flowbite.com" class="hover:underline"
                    >Flowbite</a
                  >
                </li>
                <li class="mb-4">
                  <a href="https://tailwindcss.com/" class="hover:underline"
                    >Tailwind CSS</a
                  >
                </li>
                <li class="mb-4">
                  <a href="https://www.chartjs.org/docs/latest/" class="hover:underline"
                    >ChartJS</a
                  >
                </li>
                <li class="mb-4">
                  <a href="https://laravel.com" class="hover:underline"
                    >Laravel Blade</a
                  >
                </li>
                <li class="mb-4">
                  <a href="https://fontawesome.com/" class="hover:underline"
                    >Font Awesome</a
                  >
                </li>
              </ul>
            </div>
            <div>
              <h2 class="mb-6 text-sm font-semibold text-dark uppercase">
                Support by
              </h2>
              <ul class="text-netral">
                <li class="mb-4">
                  <a
                    href="https://github.com/aethersMist/ArthaPlan-PemWeb"
                    class="hover:underline"
                    >Github</a
                  >
                </li>
                <li class="mb-4">
                  <a
                    href="#"
                    class="hover:underline"
                    >Discord</a
                  >
                </li>
                <li class="mb-4">
                  <a
                    href="https://trello.com/b/vl409pP9/aplikasi-manajemen-keuangan-pribadi"
                    class="hover:underline"
                    >Trello</a
                  >
                </li>
              </ul>
            </div>
            <div>
              <h2 class="mb-6 text-sm font-semibold text-dark uppercase">
                Legal
              </h2>
              <ul class="text-netral">
                <li class="mb-4">
                  <a href="#" class="hover:underline">Privacy Policy</a>
                </li>
                <li>
                  <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <hr
          class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"
        />
        <div class="flex items-center justify-center">
          <span class="text-sm text-netral text-center"
            >© 2025
            <a href="#" class="hover:underline">Kelompok Pemrograman Web™</a>.
            All Rights Reserved.
          </span>
        </div>
      </div>
    </footer>
            </div>
        </main>
    </div>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    </body>
</html>
