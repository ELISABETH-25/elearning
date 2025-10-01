@extends('layouts.dashboard')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-5xl lg:px-8">
    <h2 class="sr-only text-red-700">Program Studi</h2>

    <div class="grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 xl:gap-x-8">
        @foreach($categories as $category)
        <a href="{{ route('student.category.show', $category->id) }}" class="group">
            <img src="https://picsum.photos/seed/{{ $category->id }}/200/200"
                alt="{{ $category->name }}"
                class="aspect-square w-40 h-40 rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-7/8" />
            <p class="mt-1 text-lg font-medium text-gray-900 hover:text-blue-600">{{ $category->name }}</p>
            @foreach($category->teacherSubjectClasses as $tsc)
            <p class="text-sm text-gray-500">
                👩‍🏫 {{ $tsc->teacher->user->name }}
            </p>
            @endforeach
        </a>
        @endforeach
    </div>
</div>

<!-- latest quiz -->
<div class="max-w-md mx-auto my-10 px-4 pb-15 sm:max-w-md sm:px-3 lg:max-w-5xl lg:px-8">
    <h3 class="font-semibold text-xl mb-4">Quiz terbaru</h3>
    <ul role="list" class="divide-y divide-gray-100">
        @forelse($latestQuizzes as $item)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <a href="{{ route('student.quiz.show', [$item['category']->id, $item['quiz']->id]) }}">
                            <p class="text-sm/6 font-semibold text-gray-900 hover:text-blue-600">
                                {{ $item['quiz']->judul }}
                            </p>
                        </a>
                        <p class="mt-1 truncate text-xs/5 text-gray-500">
                            {{ $item['category']->name }}
                        </p>
                    </div>
                </div>
                <div class="shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="mt-1 text-xs/5 text-gray-500">
                        Deadline:
                        <time datetime="{{ $item['quiz']->deadline }}">
                            {{ \Carbon\Carbon::parse($item['quiz']->deadline)->translatedFormat('d F Y') }}
                        </time>
                    </p>
                </div>
            </li>
        @empty
            <li class="py-5 text-gray-500">Belum ada quiz terbaru.</li>
        @endforelse
    </ul>
</div>
@endsection