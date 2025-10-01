@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div>
                <h2 class="text-xl md:text-2xl font-semibold">Data: {{ $section }}</h2>
                <p>Total: {{ $total }}</p>
            </div>
            <a class="inline-block rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white transition hover:scale-105 hover:shadow-xl"
                href="{{ route('student.create') }}">
                Tambah Data
            </a>
        </div>

        <!-- Responsive table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-xs">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-2 text-left font-medium text-gray-500">No.</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-2 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-xs">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-100">
                        <td class="px-2 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2">{{ $student->nis }}</td>
                        <td class="px-4 py-2">{{ $student->kelas->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $student->gender }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($student->angkatan)->format('Y') }}</td>
                        <td class="px-4 py-2">{{ $student->user->email }}</td>
                        <td class="px-1 py-2">
                            <div class="flex items-center justify-between gap-3">
                                <a href="{{ route('student.view', $student->id) }}" class="cursor-pointer">
                                    <img class="w-5 h-5 transition-transform hover:scale-125" src="{{ asset('images/view.png') }}" alt="view" />
                                </a>
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
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

@endsection