@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('subjects.show') }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Tambah: {{ $section }}</h2>
        </div>
    </div>

    <form action="{{ route('subject.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" required autofocus value="{{ old('name') }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- multi Select Kelas -->
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas (tekan dan tahan CTRL untuk pilih lebih dari 1 kelas)</label>
            <select id="kelas_id" name="kelas_id[]" required multiple
                class="my-1 h-49 w-full rounded-md border border-gray-300 px-3 py-3 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @foreach ($kelas as $class)
                <option class="py-1 px-2" value="{{ $class->id }}" {{ collect(old('kelas_id'))->contains($class->id) ? 'selected' : '' }}>
                    {{ $class->name }} ({{ $class->prodi->name }})
                </option>
                @endforeach
            </select>
        </div>


        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit
            </button>
        </div>

    </form>
</div>

@endsection