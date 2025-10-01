@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex items-center justify-between pb-5 mb-4 mt-5">
            <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
                <a href="{{ route('teachers.show') }}" class="font-semibold hover:text-red-500">&larr; Back</a>
            </span>
            <div class="flex flex-col">
                <h2 class="mb-2 text-2xl font-bold">Detail Data: {{ $section }}</h2>
            </div>
        </div>

        <!-- Foto -->
        <div class="mt-6">
            <span class="block text-sm font-semibold">Foto:</span>
            @if($teacher->foto)
            <img src="{{ asset('storage/' . $teacher->foto) }}" alt="Foto Guru" class="w-32 h-32 object-cover rounded mt-2">
            @else
            <p class="text-gray-500">Belum ada foto</p>
            @endif
        </div>

        <!-- detail -->
        <table class="min-w-full text-sm border-collapse mt-2">
            <tbody>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Nama</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->name }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">NIP / NUPTK</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->nip }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jenis Kelamin</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">TTL</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->domisili }}, {{ $teacher->date_of_birth }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Tahun Masuk</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($teacher->tahun_masuk)->format('Y') }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jabatan</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->jabatan }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Mata Pelajaran & Kelas</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">
                        <ul class="list-disc list-inside">
                            @foreach ($teacher->teacherSubjectClasses as $tsc)
                            <li>{{ $tsc->category->name }} ({{ $tsc->kelas->name }})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Email</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->user->email }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Kontak</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->phone }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Alamat</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->alamat }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Agama</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $teacher->agama }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-end gap-5">
            <a href="{{ route('teacher.edit', $teacher->id) }}" class="cursor-pointer">
                <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/edit.png') }}" alt="edit" />
            </a>
            <form method="POST" action="{{ route('teacher.destroy', $teacher->id) }}">
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