@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4 mt-5">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('student.view', $student->id) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Edit Data: {{ $section }}</h2>
        </div>
    </div>

    <form action="{{ route('student.update', $student->id) }}" method="POST" class="space-y-4 mb-5" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="name" name="name" required autofocus
                value="{{ old('name', $student->name) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Email & Password -->
        <div class="flex justify-between gap-3">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    value="{{ old('email', $student->user->email) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="text" id="password" name="password" placeholder="Password"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
        </div>
        <span class="text-xs italic flex justify-end">*Kosongkan password jika tidak ingin diubah</span>

        <!-- Kontak -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Kontak</label>
            <input type="text" id="phone" name="phone" maxlength="12" required
                value="{{ old('phone', $student->phone) }}"
                placeholder="Hp/WhatsApp"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('phone') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <span class="block text-sm font-medium text-gray-700">Jenis Kelamin</span>
            <div class="mt-1 flex gap-3">
                <div>
                    <input type="radio" id="genderL" name="gender" value="L"
                        {{ old('gender', $student->gender) == 'L' ? 'checked' : '' }}>
                    <label for="genderL">Laki-laki</label>
                </div>
                <div>
                    <input type="radio" id="genderP" name="gender" value="P"
                        {{ old('gender', $student->gender) == 'P' ? 'checked' : '' }}>
                    <label for="genderP">Perempuan</label>
                </div>
            </div>
        </div>

        <!-- Tempat & Tanggal Lahir -->
        <div class="flex justify-between gap-3">
            <div>
                <label for="domisili" class="block text-sm font-medium text-gray-700">Tempat</label>
                <input type="text" id="domisili" name="domisili" required
                    value="{{ old('domisili', $student->domisili) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @error('domisili') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required
                    value="{{ old('date_of_birth', $student->date_of_birth) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @error('date_of_birth') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" required
                value="{{ old('alamat', $student->alamat) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('alamat') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Agama -->
        <div>
            <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
            <select id="agama" name="agama" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Agama --</option>
                @foreach (['Islam','Kristen Protestan','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                <option value="{{ $agama }}" {{ old('agama', $student->agama) == $agama ? 'selected' : '' }}>
                    {{ $agama }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Wali -->
        <div>
            <label for="wali" class="block text-sm font-medium text-gray-700">Nama Orangtua/Wali</label>
            <input type="text" id="wali" name="wali" required
                value="{{ old('wali', $student->wali) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('wali') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- NIS -->
        <div>
            <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
            <input type="text" id="nis" name="nis" maxlength="10" required
                value="{{ old('nis', $student->nis) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('nis') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Kelas -->
        <div>
            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
            <select id="kelas_id" name="kelas_id" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $class)
                <option value="{{ $class->id }}" {{ old('kelas_id', $student->kelas_id) == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Angkatan -->
        <div>
            <label for="angkatan" class="block text-sm font-medium text-gray-700">Tahun Masuk (Angkatan)</label>
            <input type="date" id="angkatan" name="angkatan" required
                value="{{ old('angkatan', $student->angkatan) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
            @error('angkatan') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Foto lama-->
        <div>
            <span class="block text-sm font-medium text-gray-700">Foto</span>
            <input type="hidden" name="oldFoto" value="{{ $student->foto }}">
            @if($student->foto)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$student->foto) }}" alt="Foto {{ $student->name }}" class="h-24 rounded-md shadow">
            </div>
            @endif
            @error('foto') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        <!-- Foto -->
        <span class="block text-sm font-medium text-gray-700">Ganti Foto (Ukuran tidak lebih dari 1MB)</span>
        <div x-data="{ fileName: '' }">
            <label for="File" class="cursor-pointer block rounded border border-gray-300 px4 text-gray-900 shadow-sm sm:p-6 @error('foto') is-invalid @enderror">
                <div class="flex items-center justify-center gap-4">
                    <span class="font-medium"> Upload new image </span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                    </svg>
                </div>
                <input
                    type="file"
                    id="File"
                    name="foto"
                    class="sr-only @error('foto') is-invalid @enderror"
                    x-on:change="fileName = $event.target.files.length ? $event.target.files[0].name : ''" />
                @error('foto')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </label>

            <!-- Tempat tampilkan nama file -->
            <div class="mt-2 text-sm text-gray-600" x-text="fileName"></div>
        </div>


        <!-- Submit -->
        <div>
            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Update
            </button>
        </div>

    </form>
</div>
@endsection