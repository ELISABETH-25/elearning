@extends('layouts.tambahData')

@section('content')
<div class="w-full max-w-sm">

    <div class="flex items-center justify-between pb-5 mb-4">
        <span aria-hidden="true" class="pb-5 block transition-all group-hover:ms-0.5 rtl:rotate-180">
            <a href="{{ route('kelas.view', $kelas->id) }}" class="font-semibold hover:text-red-500">&larr; Back</a>
        </span>
        <div class="flex flex-col">
            <h2 class="mb-2 text-2xl font-bold">Edit Data: {{ $section }}</h2>
        </div>
    </div>

    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" class="space-y-4">
        @method('PUT')
        @csrf

        <!-- Select Tingkat Kelas -->
        <div>
            <label class="block text-sm font-medium">Tingkat</label>
            <div class="mt-2 flex items-center space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="tingkat" value="X"
                        {{ old('tingkat', $kelas->tingkat) === 'X' ? 'checked' : '' }}
                        class="form-radio text-blue-600">
                    <span class="ml-2">X</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="tingkat" value="XI"
                        {{ old('tingkat', $kelas->tingkat) === 'XI' ? 'checked' : '' }}
                        class="form-radio text-blue-600">
                    <span class="ml-2">XI</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="tingkat" value="XII"
                        {{ old('tingkat', $kelas->tingkat) === 'XII' ? 'checked' : '' }}
                        class="form-radio text-blue-600">
                    <span class="ml-2">XII</span>
                </label>
            </div>
            @error('tingkat')
            <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Select Prodi -->
        <div>
            <label for="prodi_id" class="block text-sm font-medium text-gray-700">Pilih Prodi</label>
            <select id="prodi-id" name="prodi_id" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                <option value="">-- Pilih Prodi --</option>
                @foreach($prodis as $prodi)
                <option value="{{ $prodi->id }}" {{ old('prodi_id', $kelas->prodi_id) == $prodi->id ? 'selected' : '' }}>
                    {{ $prodi->name }}
                </option>
                @endforeach
            </select>
            @error('prodi_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Kode Kelas -->
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
            <input type="text" id="name" name="name" required autofocus value="{{ old('name', $kelas->name) }}" placeholder="X TKJ-A"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none
                @error('name') is-invalid @enderror">
            @error('name')
            <div class="text-red-500 text-sm">
                {{ $message }}
            </div>
            @enderror
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