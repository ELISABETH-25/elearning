@extends('layouts.teacherDashboard')

@section('content')

@php
    $kelasX  = $teacherSubjectClasses->filter(fn($tsc) => $tsc->kelas->tingkat == 'X');
    $kelasXI = $teacherSubjectClasses->filter(fn($tsc) => $tsc->kelas->tingkat == 'XI');
    $kelasXII= $teacherSubjectClasses->filter(fn($tsc) => $tsc->kelas->tingkat == 'XII');
@endphp

<div class="rounded-lg p-6">
    <h2 class="text-md font-medium text-gray-500 mb-4">Daftar Mata Pelajaran, Kelas: X</h2>
    <div class="flex space-x-4 overflow-x-auto">  

        @foreach($kelasX as $tsc)
           
                <article class="rounded-[10px] border border-gray-200 bg-white px-4 pt-8 pb-4">
                    <time datetime="2022-10-10" class="block text-xs text-gray-500">
                        {{ $tsc->kelas->name }}
                    </time>
                    <a href="{{ route('teacher.category.show', ['category' => $tsc->category->id, 'kelas' => $tsc->kelas->id]) }}">
                        <h3 class="mt-0.5 text-lg font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-800">
                            {{ $tsc->category->name }} 
                        </h3>
                    </a>
                </article>
            
        @endforeach

    </div>
</div>

<div class="rounded-lg p-6">
    <h2 class="text-md font-medium text-gray-500 mb-4">Daftar Mata Pelajaran, Kelas: XI</h2>
    <div class="flex space-x-4 overflow-x-auto">  

        @foreach($kelasXI as $tsc)
           
                <article class="rounded-[10px] border border-gray-200 bg-white px-4 pt-8 pb-4">
                    <time datetime="2022-10-10" class="block text-xs text-gray-500">
                        {{ $tsc->kelas->name }}
                    </time>
                    <a href="{{ route('teacher.category.show', ['category' => $tsc->category->id, 'kelas' => $tsc->kelas->id]) }}">
                        <h3 class="mt-0.5 text-lg font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-800">
                            {{ $tsc->category->name }} 
                        </h3>
                    </a>
                </article>
            
        @endforeach

    </div>
</div>

<div class="rounded-lg p-6">
    <h2 class="text-md font-medium text-gray-500 mb-4">Daftar Mata Pelajaran, Kelas: XII</h2>
    <div class="flex space-x-4 overflow-x-auto">  

        @foreach($kelasXII as $tsc)
           
                <article class="rounded-[10px] border border-gray-200 bg-white px-4 pt-8 pb-4">
                    <time datetime="2022-10-10" class="block text-xs text-gray-500">
                        {{ $tsc->kelas->name }}
                    </time>
                    <a href="{{ route('teacher.category.show', ['category' => $tsc->category->id, 'kelas' => $tsc->kelas->id]) }}">
                        <h3 class="mt-0.5 text-lg font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-800">
                            {{ $tsc->category->name }} 
                        </h3>
                    </a>
                </article>
            
        @endforeach

    </div>
</div>

@endsection