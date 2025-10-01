@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('teacher.category.show', [$category->id, $kelas->id]) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Edit Bab</h2>
            <p class="italic">{{ $category->name }}</p>
        </div>
    </div>

    <form action="{{ route('chapter.update', [$category->id, $kelas->id, $chapter->id]) }}" method="POST" class="space-y-4">
        @method('PUT')
        @csrf
        
        <!-- Judul Bab -->
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Bab</label>
            <input type="text" id="judul" name="judul" placeholder="Masukkan judul saja, nomor bab akan terbuat otomatis" required autofocus
                value="{{ old('judul', $chapter->judul) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('judul') is-invalid @enderror">
            @error('judul')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div>
            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit
            </button>
        </div>

    </form>
</div>
@endsection