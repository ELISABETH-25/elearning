@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('teacher.category.createData', [$category->id, $kelas->id]) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Tambah Quiz</h2>
            <p class="italic">{{ $category->name }}</p>
        </div>
    </div>

    <form action="{{ route('quiz.store', [$category->id, $kelas->id]) }}" method="POST" class="space-y-4">
        @csrf

        <!-- Judul Quiz -->
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700">Judul Quiz</label>
            <input type="text" id="judul" name="judul" required autofocus
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                 @error('judul') is-invalid @enderror">
            @error('judul')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Select Materi -->
        <div>
            <label for="topic_id" class="block text-sm font-medium text-gray-700">Pilih Materi</label>
            <select id="topic_id" name="topic_id" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Materi --</option>
                @foreach($chapters as $chapter)
                @foreach($chapter->topics as $topic)
                <option value="{{ $topic->id }}" {{ $topic->quiz ? 'disabled' : '' }}>
                    {{ $topic->judul }} {{ $topic->quiz ? '(Materi ini sudah punya quiz)' : '' }}
                </option>
                @endforeach
                @endforeach
            </select>
        </div>

        <!-- Textarea -->
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">Detail Quiz</label>
            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
            @error('body')
            <p class="text-red-500 text-sm">
                {{ $message }}
            </p>
            @enderror
            <trix-editor input="body"></trix-editor>
        </div>

        <!-- Deadline -->
        <div>
            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
            <input type="date" id="deadline" name="deadline" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('deadline') is-invalid @enderror">
            @error('deadline')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
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

<style>
    trix-editor {
        border: 1px solid #bbb;
        /* Keep existing border */
        border-radius: 3px;
        /* Keep existing border radius */
        margin: 0;
        padding: 20px 0.6em;
        /* Adjust top/bottom padding */
        min-height: 9em;
        /* Adjust minimum height */
        outline: none;
        /* Keep existing outline */
    }


    trix-editor ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-left: 1rem;
    }

    trix-editor ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-left: 1rem;
    }

    trix-editor h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }

    trix-editor h2 {
        font-size: 1.25rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }
</style>

<script>
    document.addEventListener('trix-file-accept', function(event) {
        event.preventDefault();
    });
</script>
@endsection