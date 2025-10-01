@extends('layouts.admin')

@section('content')

<main class="flex-1 p-4 md:p-6 overflow-auto">
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <h2 class="text-xl md:text-2xl font-semibold">Selamat Datang di Dashboard</h2>
        </div>

        <div class="flex-col grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Prodi Card -->
            <article class="rounded-lg border border-gray-200 bg-white p-3 shadow hover:shadow-md transition text-sm">
                <span class="inline-block rounded bg-blue-600 px-2 py-1 text-white text-xl font-semibold">
                    1
                </span>
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    Data Prodi
                </h3>
                <p class="mt-2 text-gray-700">Total: <strong>{{ $prodiTotal }}</strong></p>
                <a href="{{ route('prodi.show') }}" class="mt-2 inline-flex items-center text-xs font-medium text-blue-600">
                    Lihat &rarr;
                </a>
            </article>

            <!-- Subject Card -->
            <article class="rounded-lg border border-gray-200 bg-white p-3 shadow hover:shadow-md transition text-sm">
                <span class="inline-block rounded bg-blue-600 px-2 py-1 text-white text-xl font-semibold">
                    2
                </span>
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    Mata Pelajaran
                </h3>
                <p class="mt-2 text-gray-700">Total: <strong>{{ $subjectTotal }}</strong></p>
                <a href="{{ route('subjects.show') }}" class="mt-2 inline-flex items-center text-xs font-medium text-blue-600">
                    Lihat &rarr;
                </a>
            </article>

            <!-- Teacher Card -->
            <article class="rounded-lg border border-gray-200 bg-white p-3 shadow hover:shadow-md transition text-sm">
                <span class="inline-block rounded bg-blue-600 px-2 py-1 text-white text-xl font-semibold">
                    3
                </span>
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    Data Guru
                </h3>
                <p class="mt-2 text-gray-700">Total: <strong>{{ $teacherTotal }}</strong></p>
                <a href="{{ route('teachers.show') }}" class="mt-2 inline-flex items-center text-xs font-medium text-blue-600">
                    Lihat &rarr;
                </a>
            </article>

            <!-- Kelas Card -->
            <article class="rounded-lg border border-gray-200 bg-white p-3 shadow hover:shadow-md transition text-sm">
                <span class="inline-block rounded bg-blue-600 px-2 py-1 text-white text-xl font-semibold">
                    4
                </span>
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    Data Kelas
                </h3>
                <p class="mt-2 text-gray-700">Total: <strong>{{ $kelasTotal }}</strong></p>
                <a href="{{ route('kelas.show') }}" class="mt-2 inline-flex items-center text-xs font-medium text-blue-600">
                    Lihat &rarr;
                </a>
            </article>

            <!-- Student Card -->
            <article class="rounded-lg border border-gray-200 bg-white p-3 shadow hover:shadow-md transition text-sm">
                <span class="inline-block rounded bg-blue-600 px-2 py-1 text-white text-xl font-semibold">
                    5
                </span>
                <h3 class="mt-0.5 text-lg font-medium text-gray-900">
                    Data Siswa
                </h3>
                <p class="mt-2 text-gray-700">Total: <strong>{{ $studentTotal }}</strong></p>
                <a href="{{ route('students.show') }}" class="mt-2 inline-flex items-center text-xs font-medium text-blue-600">
                    Lihat &rarr;
                </a>
            </article>

        </div>


        <div class="my-12">
            <h1 class="text-lg font-semibold my-3">Data Admin</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-500">No.</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs">
                        @forelse ($admins as $index => $admin)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $admin->name }}</td>
                            <td class="px-4 py-2">{{ $admin->email }}</td>
                            <td class="px-1 py-2">
                                <div class="flex items-center gap-3">
                                    <form method="POST" action="{{ route('admin.destroy', $admin->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Hapus data ini?')"
                                            class="cursor-pointer">
                                            <img class="w-4 h-4 transition-transform hover:scale-125" src="{{ asset('images/delete.png') }}" alt="delete" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada admin</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

@endsection