<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ArthaPlan') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('node_modules/flowbite/dist/flowbite.js') }}"></script>
        <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

    </head>

  <body class="bg-base font-display">
    <section class="min-h-screen flex flex-col justify-between px-6">
      <div class="flex-grow flex items-center justify-center">
        <div class="text-center">

          <h1 class="text-5xl font-bold text-primary-dark mb-4">404</h1>
          <h2 class="text-2xl font-semibold text-accent mb-2">
            Oops! Halaman tidak ditemukan
          </h2>
          <p class="text-md text-dark mb-6">
            Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
          </p>
        <a href="{{ url('/') }}"
            class="inline-block px-6 py-3 bg-accent text-light font-semibold rounded-lg shadow hover:bg-primary-dark transition duration-300"
          >
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </section>

    

    
   
  </body>
</html>