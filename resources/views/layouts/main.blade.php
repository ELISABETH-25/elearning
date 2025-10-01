<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <title> {{ $title }} </title>
  <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">


  <!-- trix editor -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
  <script type="text/javascript" src="{{ asset('js/trix.js') }}"></script>

  <style>
    [x-cloak] {
      display: none !important;
    }

    trix-toolbar [data-trix-button-group="file-tools"] {
      display: none;
    }
  </style>
</head>

<body class="h-full">

  <div class="min-h-full">
    <!-- include navbar in partials -->
    @include('partials.nav')

    @include('partials.header')
    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Your content -->

        <div class="bg-white mb-20">
          @yield('content')

          @include('sweetalert::alert')

        </div>


      </div>
    </main>
  </div>
  <script>
    // Dropdown toggle
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownToggle.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
      if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.add('hidden');
      }
    });
  </script>
</body>

</html>