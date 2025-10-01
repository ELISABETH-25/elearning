@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex items-center justify-between pb-5 mb-4 mt-5">
            <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
                <a href="{{ route('kelas.show') }}" class="font-semibold hover:text-red-500">&larr; Back</a>
            </span>
            <div class="flex flex-col">
                <h2 class="mb-2 text-2xl font-bold">Detail Data: {{ $section }}</h2>
            </div>
        </div>

        <!-- detail -->
        <table class="min-w-full text-sm border-collapse mt-2">
            <tbody>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Nama Kelas</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $kelas->name }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Tingkat</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $kelas->tingkat }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Prodi</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $kelas->prodi->name }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jumlah siswa</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $kelas->students_count }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jumlah Mata Pelajaran</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $kelas->categories_direct_count }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Daftar Mata Pelajaran</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">
                        @if($kelas->categoriesDirect && $kelas->categoriesDirect->isNotEmpty())
                        <ul class="list-disc list-inside">
                            @foreach($kelas->categoriesDirect as $category)
                            <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-gray-500">Belum ada mata pelajaran</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-end gap-5">
            <a href="{{ route('kelas.edit', $kelas->id) }}" class="cursor-pointer">
                <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/edit.png') }}" alt="edit" />
            </a>
            <form method="POST" action="{{ route('kelas.destroy', $kelas->id) }}">
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