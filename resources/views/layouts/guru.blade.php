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

    @yield('content')

    @include('sweetalert::alert')

  </div>

</body>

</html>