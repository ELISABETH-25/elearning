@extends('layouts.guru')

@section('content')
<header class="bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900"> {{ $kelas->name }} , {{ $category->name }} </h1>
    </div>
</header>


<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Your content -->


        <div class=" mb-20">

            <div x-data class="space-y-2 mx-5 py-12">
                <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
                    <a href="{{ route('teacher.index') }}" class="font-semibold hover:text-blue-700">&larr; Back</a>
                </span>
                <div class="flex justify-end gap-4 pb-4">
                    <a class="inline-block rounded-sm bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
                        href="{{ route('teacher.category.createData', [$category->id, $kelas->id]) }}">
                        Tambah
                    </a>
                </div>

                <!-- Accordion for Chapters -->
                @foreach($chapters as $chapter)
                <div x-data="{ open: false }" class="bg-white rounded-lg cursor-pointer">
                    <div @click="open = !open" class="rounded-lg p-3 flex justify-between items-center">
                        <h2 class="text-md font-medium text-gray-700">Bab {{ $chapters->count() - $loop->index }}: {{ $chapter->judul }}</h2>

                        <div class="flex items-center gap-6">
                            <svg :class="{ 'rotate-180': open }" class="h-5 w-5 transition-transform duration-200 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>

                            <!-- Update-Delete buttons -->
                            <div class="flex items-center gap-5">
                                <a href="{{ route('chapter.edit', [$category->id, $kelas->id, $chapter->id]) }}" class="cursor-pointer">
                                    <img class="size-4 transition hover:scale-200" src="{{ asset('images/edit.png') }}" alt="edit" />
                                </a>
                                <form method="POST" action="{{ route('chapter.destroy', ['category' => $category->id, 'kelas' => $kelas->id, 'chapter' => $chapter->id]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="return confirm('Anda akan menghapus Bab ini?')"
                                        class="cursor-pointer">
                                        <img class="size-4 transition hover:scale-200" src="{{ asset('images/delete.png') }}" alt="delete" />
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                    <!--  Chapter content (Topics and Quizzes) -->
                    <div x-show="open" x-transition class="px-5 pb-3">
                        <ul class="space-y-1 text-sm text-gray-600">
                            @php
                            $totalTopics = $chapter->topics->count();
                            @endphp

                            @foreach($chapter->topics as $topic)
                            <li>
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('teacher.topic.show', [$category->id, $kelas->id, $topic->id]) }}" class="block my-2 hover:text-indigo-600">
                                        Materi {{ $totalTopics - $loop->index  }}: {{ $topic->judul }}
                                    </a>
                                    <span class="text-xs italic">Batas Pengerjaan : <time datetime="{{ $topic->deadline }}">{{ \Carbon\Carbon::parse($topic->deadline)->translatedFormat('d F Y') }}</time>
                                    </span>
                                </div>

                            </li>
                            @if($topic->quiz)
                            <div class="flex items-center justify-between">
                                <a href="{{ route('teacher.quiz.show', [$category->id, $kelas->id, $topic->quiz->id]) }}" class="block ml-4 my-1 text-indigo-400 hover:text-indigo-700">
                                    ➤ Quiz: {{ $topic->quiz->judul }}
                                </a>
                                <span class="text-xs italic">Batas Pengerjaan : <time datetime="{{ $topic->quiz->deadline }}">{{ \Carbon\Carbon::parse($topic->quiz->deadline)->translatedFormat('d F Y') }}</time>
                                </span>
                            </div>

                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </div>
</main>

@endsection