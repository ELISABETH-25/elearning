@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex items-center justify-between pb-5 mb-4 mt-5">
            <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
                <a href="{{ route('students.show') }}" class="font-semibold hover:text-red-500">&larr; Back</a>
            </span>
            <div class="flex flex-col">
                <h2 class="mb-2 text-2xl font-bold">Detail Data: {{ $section }}</h2>
            </div>
        </div>

        <!-- Foto -->
        <div class="mt-6">
            <span class="block text-sm font-semibold">Foto:</span>
            @if($student->foto)
            <img src="{{ asset('storage/' . $student->foto) }}" alt="Foto Siswa" class="w-32 h-32 object-cover rounded mt-2">
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
                    <td class="px-4 py-2">{{ $student->name }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">NIS</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->nis }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Jenis Kelamin</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">TTL</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->domisili }}, {{ $student->date_of_birth }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Kelas</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->kelas->name ?? '-' }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Program Studi</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->kelas->prodi->name ?? '-' }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Angkatan/Tahun Masuk</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($student->angkatan)->format('Y') }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Email</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->user->email }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Kontak</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->phone }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Alamat</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->alamat }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Agama</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->agama }}</td>
                </tr>
                <tr class="border-b border-transparent">
                    <td class="px-4 py-2 font-semibold">Nama Orangtua/Wali</td>
                    <td class="px-4 py-2">:</td>
                    <td class="px-4 py-2">{{ $student->wali }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-end gap-5">
            <a href="{{ route('student.edit', $student->id) }}" class="cursor-pointer">
                <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/edit.png') }}" alt="edit" />
            </a>
            <form method="POST" action="{{ route('student.destroy', $student->id) }}">
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