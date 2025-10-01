@extends('layouts.main')

@section('content')

<div class="rounded-lg p-6">
    <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
        <a href="{{ route('teacher.dashboard') }}" class="font-semibold hover:text-blue-700">&larr; Back</a>
    </span>

    <h2 class="text-md font-medium text-gray-500 mb-4">Daftar Mata Pelajaran</h2>
    <div class="flex space-x-4 overflow-x-auto">

        @foreach($categories as $category)

        <article class="rounded-[10px] border border-gray-200 bg-white px-4 pt-12 pb-4">
            <time datetime="2022-10-10" class="block text-xs text-gray-500"> kelas </time>

            <a href="{{ route('teacher.category.show', $category->id) }}">
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    {{ $category->name }}
                </h3>
            </a>

        </article>

        @endforeach

    </div>
</div>

@endsection