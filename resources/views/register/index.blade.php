@extends('layouts.loginRegist')

@section('content')

<!-- Form -->
<form action="/register" method="POST" class="mt-8 space-y-6">
    @csrf
    <div>
        <label for="name" class="block text-sm font-medium text-gray-900">Nama</label>
        <input id="name" name="name" type="text" placeholder="Nama Lengkap" required value="{{ old('name') }}"
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                        @error('name') is-invalid @enderror">
        @error('name')
        <div class="text-red-500 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
        <input id="email" name="email" type="email" autocomplete="email" placeholder="Email@gmail.com" required value="{{ old('email') }}"
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                        @error('email') is-invalid @enderror">
        @error('email')
        <div class="text-red-500 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
        </div>
        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Password" required
            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                        @error('password') is-invalid @enderror">
        @error('password')
        <div class="text-red-500 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <p class="text-sm text-gray-500">Sudah punya akun ? <a href="/login" class="text-blue-500 font-semibold">Login</a></p>

    <div>
        <button type="submit"
            class="cursor-pointer mt-3 block w-full rounded-md border bg-blue-900 border-gray-300 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            Register
        </button>
    </div>

</form>

@endsection