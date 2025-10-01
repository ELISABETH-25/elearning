@extends('layouts.tambahData')

@section('content')
<div x-data class="space-y-2 mx-5 py-12">
    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('teacher.category.show', [$category->id, $kelas->id]) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Tambah Data</h2>
            <p class="italic">{{ $category->name }}</p>
        </div>
    </div>
    <div class="flex justify-end gap-4 pb-4">
        <a class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
            href="{{ route('teacher.category.createChapter', [$category->id, $kelas->id]) }}">
            Tambah Bab
        </a>
        <a class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
            href="{{ route('teacher.category.createTopic', [$category->id, $kelas->id]) }}">
            Tambah Materi
        </a>
        <a class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-indigo-600 transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
            href="{{ route('teacher.category.createQuiz', [$category->id, $kelas->id]) }}">
            Tambah Quiz
        </a>
    </div>
</div>
@endsection