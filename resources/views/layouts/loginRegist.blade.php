<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

</head>

<body class="h-full">

    <div class="flex min-h-full flex-col justify-center items-center px-4 py-12">
        <div class="w-full max-w-xs">
            <!-- Logo -->
            <div class="flex flex-col items-center justify-center">
                <img class="size-25" src="{{ asset('images/logo.png') }}" alt="logo" />
                <h2 class="font-semibold text-xl mt-5">{{ $title }}</h2>
            </div>

            @yield('content')

            @include('sweetalert::alert')

        </div>
    </div>

</body>

</html>