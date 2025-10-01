@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4 mt-5">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('teacher.view', $teacher->id) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Edit Data: {{ $section }}</h2>
        </div>
    </div>

    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" class="space-y-4 mb-5" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="name" name="name" required autofocus
                value="{{ old('name', $teacher->name) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Email - Password -->
        <div class="flex justify-between mb-1">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" placeholder="Email@gmail.com" required
                    value="{{ old('email', $teacher->user->email) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                        @error('email') is-invalid @enderror">
                @error('email')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                </div>
                <input id="password" name="password" type="password" placeholder="Password"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                        @error('password') is-invalid @enderror">
                @error('password')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <span class="text-xs italic flex justify-end">*Kosongkan password jika tidak ingin diubah</span>

        <!-- Kontak -->
        <div class="mt-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Kontak</label>
            <input type="text" id="phone" name="phone" maxlength="12" required
                value="{{ old('phone', $teacher->phone) }}" placeholder="Hp/WhatsApp"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('phone') is-invalid @enderror">
            @error('phone')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <label class="block text-sm font-medium">Gender</label>
            <div class="mt-2 flex items-center space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="L"
                        {{ old('gender', $teacher->gender) === 'L' ? 'checked' : '' }}
                        class="form-radio text-blue-600">
                    <span class="ml-2">Laki-laki</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="gender" value="P"
                        {{ old('gender', $teacher->gender) === 'P' ? 'checked' : '' }}
                        class="form-radio text-blue-600">
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
            @error('gender')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tempat - Tgl. Lahir -->
        <div class="flex justify-between">
            <div>
                <label for="domisili" class="block text-sm font-medium text-gray-700">Tempat</label>
                <input type="text" id="domisili" name="domisili" required
                    value="{{ old('domisili', $teacher->domisili) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('domisili') is-invalid @enderror">
                @error('domisili')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required
                    value="{{ old('date_of_birth', $teacher->date_of_birth) }}"
                    class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('date_of_birth') is-invalid @enderror">
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" id="alamat" name="alamat" required
                value="{{ old('alamat', $teacher->alamat) }}"
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
                <option value="{{ $agama }}" {{ old('agama', $teacher->agama) == $agama ? 'selected' : '' }}>
                    {{ $agama }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- NUPTK / NIP -->
        <div>
            <label for="nip" class="block text-sm font-medium text-gray-700">NUPTK / NIP</label>
            <input type="text" id="nip" name="nip" maxlength="18" required
                value="{{ old('nip', $teacher->nip) }}" placeholder="1234567890"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('nip') is-invalid @enderror">
            @error('nip')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Jabatan-->
        <div>
            <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
            <select id="jabatan" name="jabatan" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Jabatan --</option>
                <option value="Guru Mapel" {{ old('jabatan', $teacher->jabatan) == 'Guru Mapel' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
                <option value="Guru Produktif" {{ old('jabatan', $teacher->jabatan) == 'Guru Produktif' ? 'selected' : '' }}>Guru Produktif</option>
                <option value="Guru BK" {{ old('jabatan', $teacher->jabatan) == 'Guru BK' ? 'selected' : '' }}>Guru BP/BK</option>
                <option value="Kakomli" {{ old('jabatan', $teacher->jabatan) == 'Kakomli' ? 'selected' : '' }}>Kakomli</option>
                <option value="Kepala Sekolah" {{ old('jabatan', $teacher->jabatan) == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                <option value="Tenaga Administrasi" {{ old('jabatan', $teacher->jabatan) == 'Tenaga Administrasi' ? 'selected' : '' }}>Tenaga Administrasi</option>
                <option value="Tata Usaha" {{ old('jabatan', $teacher->jabatan) == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                <option value="Wakil Kepala Sekolah" {{ old('jabatan', $teacher->jabatan) == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                <option value="Wali Kelas" {{ old('jabatan', $teacher->jabatan) == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
            </select>
        </div>

        <!-- Tahun masuk -->
        <div>
            <label for="tahun_masuk" class="block text-sm font-medium text-gray-700">Tahun Masuk</label>
            <input type="date" id="tahun_masuk" name="tahun_masuk" required
                value="{{ old('tahun_masuk', $teacher->tahun_masuk) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('tahun_masuk') is-invalid @enderror">
            @error('tahun_masuk')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Assignments => Subject - Class -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Tugas (Mata Pelajaran - Kelas)</label>
            <select name="assignments[]" multiple class="my-1 h-49 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @foreach($categories as $category)
                @foreach($category->kelasDirect->unique('id') as $class)

                @php
                $value = $category->id . '|' . $class->id;
                $isSelected = in_array($value, old('assignments', $existingAssignments));
                $isTaken = in_array($value, $takenAssignments);
                @endphp

                <option value="{{ $value }}"
                    {{ $isSelected ? 'selected' : '' }}
                    {{ $isTaken && !$isSelected ? 'disabled' : '' }}>
                    {{ $category->name }} - {{ $class->name }}
                    @if($isTaken && !$isSelected)
                    (sudah diambil)
                    @endif
                </option>

                @endforeach
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Tekan Ctrl / Shift untuk pilih lebih dari satu Subject</p>
        </div>


        <!-- Foto lama-->
        <div>
            <span class="block text-sm font-medium text-gray-700">Foto</span>
            <input type="hidden" name="oldFoto" value="{{ $teacher->foto }}">
            @if($teacher->foto)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$teacher->foto) }}" alt="Foto {{ $teacher->name }}" class="h-24 rounded-md shadow">
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

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Submit
            </button>
        </div>

    </form>
</div>

@endsection