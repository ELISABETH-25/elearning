@extends('layouts.main')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">

    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
        <a href="{{ route('student.category.show', $category->id) }}" class="font-semibold hover:text-blue-700">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-lg font-medium">Materi: <strong>{{ $topic->judul }}</strong></h2>
        </div>
    </div>

    <!-- teacher's post -->
    <article class="rounded-lg border border-gray-100 bg-white p-4 shadow-xs transition hover:shadow-lg sm:p-6 mb-5">
        <div class="flex items-center justify-between">
            <span class="flex rounded-sm bg-blue-600 p-2 text-white">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="size-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
                <h3 class="px-3 text-white font-bold">{{ $topic->teacher_name }}</h3>
            </span>
        </div>

        <div class="mx-3 mt-5">
            <div class="prose max-w-none mt-2 text-gray-700">
                {!! $topic->body !!}
            </div>
        </div>

        <br />

        <!-- top level reply -->
        <div class="items-end justify-end">
            <button type="button" class="toggleReplyBtn
            justify-end group mt-4 cursor-pointer hover:text-blue-900 inline-flex items-center gap-1 text-sm font-medium text-blue-600"
                data-target="replyFormTop">
                Reply
                <span aria-hidden="true" class="block transition-all group-hover:ms-0.5 rtl:rotate-180">
                    &rarr;
                </span>
            </button>

            <!-- hidden reply form -->
            <form id="replyFormTop" action="{{ route('student.topic.comment.store', $topic->id) }}" method="POST" class="mt-3 hidden">
                @csrf
                <!-- Trix editor -->
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700">Tambah Komentar</label>
                    <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                    @error('body')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                    @enderror
                    <trix-editor input="body"></trix-editor>
                </div>
                <button type="submit" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Post Comment
                </button>
            </form>
        </div>

    </article>


    <!-- comment list -->
    <h3 class="text-md font-semibold mt-6 mb-3 text-gray-500">Komentar</h3>

    @forelse($topic->comments as $comment)
    <article class="rounded-lg border border-gray-100 bg-white p-4 shadow-sm mb-3">
        <div class="flex items-center justify-between">
            <div>
                @if($comment->user->role === 'teacher')
                <span class="inline-flex rounded-sm bg-blue-600 p-1 text-white items-center">
                    <strong class="ml-1">{{ $comment->user->name }}</strong>
                </span>
                @else
                <strong>{{ $comment->user->name }}</strong>
                <div class="text-xs italic text-gray-500">NIS: {{ optional($comment->user->student)->nis ?? '-' }}</div>
                @endif
                <span class="text-sm text-gray-500 ml-2">• {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <!-- Right section: Dropdown -->
            @if ($comment->user_id === auth()->id())
            <div class="flex items-center relative ml-auto">
                <button id="dropdownToggle-{{ $comment->id }}" class="cursor-pointer flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownMenu-{{ $comment->id }}" class="hidden absolute right-0 mt-2 w-25 bg-white rounded-lg shadow-lg">
                    <form method="POST" action="{{ route('student.topic.comment.destroy', [$topic->id, $comment->id]) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" onclick="return confirm('Anda akan menghapus komentar ini?')"
                            class="w-full text-left block px-4 py-2 text-gray-600 hover:bg-red-500 hover:text-white text-sm font-bold cursor-pointer hover:rounded-lg">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="prose max-w-none mt-2 text-gray-700">
            {!! $comment->body !!}
        </div>

        {{-- Reply toggle for this comment --}}
        <div class="mt-3">
            <button type="button" class="showReplyBtn text-sm text-blue-600 hover:text-blue-900" data-id="{{ $comment->id }}">
                Reply
            </button>
        </div>

        {{-- Hidden reply form for this comment --}}
        <form id="replyForm-{{ $comment->id }}" action="{{ route('student.topic.comment.store', $topic->id) }}" method="POST" class="mt-3 hidden">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input id="body-{{ $comment->id }}" type="hidden" name="body" value="">
            <trix-editor input="body-{{ $comment->id }}"></trix-editor>

            <button type="submit" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Post Reply
            </button>
        </form>

        {{-- Replies (if any) --}}
        @if($comment->replies->count())
        <div class="ml-6 mt-4 space-y-3">
            @foreach($comment->replies as $reply)
            <div class="border-l-2 pl-4">
                <div class="text-sm flex items-center justify-between">
                    <div>
                        <!-- <strong>{{ $reply->user->name }}</strong>
                        <span class="text-xs text-gray-500 ml-2">{{ $reply->created_at->diffForHumans() }}</span> -->
                        @if($reply->user->role === 'teacher')
                        <span class="inline-flex rounded-sm bg-blue-600 p-1 text-white items-center">
                            <strong class="ml-1">{{ $reply->user->name }}</strong>
                        </span>
                        @else
                        <strong>{{ $reply->user->name }}</strong>
                        @endif

                        <span class="text-xs text-gray-500 ml-2">{{ $reply->created_at->diffForHumans() }}</span>

                    </div>
                    <!-- Right section: Dropdown for reply -->
                    @if ($reply->user_id === auth()->id())
                    <div class="flex items-center relative ml-auto">
                        <button id="dropdownToggle-{{ $reply->id }}" class="cursor-pointer flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownMenu-{{ $reply->id }}" class="hidden absolute right-0 mt-2 w-25 bg-white rounded-lg shadow-lg">
                            <form method="POST" action="{{ route('student.topic.comment.destroy', [$topic->id, $reply->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" onclick="return confirm('Anda akan menghapus komentar ini?')"
                                    class="w-full text-left block px-4 py-2 text-gray-600 hover:bg-red-500 hover:text-white text-sm font-bold cursor-pointer hover:rounded-lg">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="text-sm prose max-w-none mt-2 text-gray-700">
                    {!! $reply->body !!}
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </article>
    @empty
    <p class="text-gray-500">No comments yet. Be the first to comment!</p>
    @endforelse
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
    // --- Dropdown toggle for delete ---
    document.querySelectorAll('[id^="dropdownToggle-"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();

            const id = this.id.replace('dropdownToggle-', '');
            const menu = document.getElementById(`dropdownMenu-${id}`);
            
            // Close other dropdowns
            document.querySelectorAll('[id^="dropdownMenu-"]').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });

            if (menu) menu.classList.toggle('hidden');
        });
    });

    // --- Close dropdowns & reply forms on outside click ---
    document.addEventListener('click', function (e) {
        // If clicked outside of any dropdown or button -> close dropdowns
        if (!e.target.closest('[id^="dropdownMenu-"]') && !e.target.closest('[id^="dropdownToggle-"]')) {
            document.querySelectorAll('[id^="dropdownMenu-"]').forEach(m => m.classList.add('hidden'));
        }

        // If clicked outside of any reply form or reply button -> close reply forms
        if (!e.target.closest('form[id^="replyForm"]') && !e.target.closest('.showReplyBtn') && !e.target.closest('.toggleReplyBtn')) {
            document.querySelectorAll('form[id^="replyForm"]').forEach(f => f.classList.add('hidden'));
        }
    });

    // --- Reply form only open 1 at a time ---
    function hideAllReplyForms() {
        document.querySelectorAll('form[id^="replyForm"]').forEach(f => f.classList.add('hidden'));
    }

    // Per-comment replies
    document.querySelectorAll('.showReplyBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); // prevent outside-click handler
            const id = this.dataset.id;
            const form = document.getElementById(`replyForm-${id}`);
            
            hideAllReplyForms();
            if (form) form.classList.toggle('hidden');
        });
    });

    // Top-level reply toggle
    document.querySelectorAll('.toggleReplyBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); // prevent outside-click handler
            const target = this.dataset.target;
            const form = document.getElementById(target);

            hideAllReplyForms();
            if (form) form.classList.toggle('hidden');
        });
    });
</script>

@endsection