@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex items-center justify-between pb-5 mb-4 mt-5">
            <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
                <a href="{{ route('subjects.show') }}" class="font-semibold hover:text-red-500">&larr; Back</a>
            </span>
            <div class="flex flex-col">
                <h2 class="mb-2 text-2xl font-bold">Detail Data: {{ $section }}</h2>
            </div>
        </div>

        <!-- detail -->
        <table class="min-w-full text-sm border-collapse mt-2">
            <tbody>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Mata Pelajaran</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $subject->name }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jumlah Kelas</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $subject->kelas_direct_count }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Daftar Kelas</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">
                        @if($subject->kelasDirect->isNotEmpty())
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($subject->kelasDirect as $kelas)
                            @php
                            $assignment = $subject->teacherSubjectClasses->firstWhere('kelas_id', $kelas->id);
                            @endphp
                            <li>
                                {{ $kelas->name }}
                                @if($kelas->prodi)
                                - {{ $kelas->prodi->name }}
                                @endif

                                @php
                                $assignment = $subject->teacherSubjectClasses->firstWhere('kelas_id', $kelas->id);
                                @endphp

                                @if($assignment && $assignment->teacher)
                                | Guru: {{ $assignment->teacher->name }}
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-gray-400 italic">-</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-end gap-5">
            <a href="{{ route('subject.edit', $subject->id) }}" class="cursor-pointer">
                <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/edit.png') }}" alt="edit" />
            </a>
            <form method="POST" action="{{ route('subject.destroy', $subject->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" onclick="return confirm('Hapus data ini?')"
                    class="cursor-pointer">
                    <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/delete.png') }}" alt="delete" />
                </button>
            </form>
        </div>

    </div>
</main>

@endsection