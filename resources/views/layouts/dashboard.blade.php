<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

  <title> {{ $title }} </title>
  <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>

<body class="h-full">

  <div class="min-h-full">
    <!-- include navbar in partials -->
    @include('partials.nav')

    @include('partials.header_dashboard')
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Your content -->

        <div class="bg-white mb-20">
          @yield('content')
        </div>


      </div>
    </main>
  </div>

</body>

</html>