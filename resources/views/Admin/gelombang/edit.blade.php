@extends('layouts.admin')

@section('title', 'Edit Gelombang')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Gelombang Pendaftaran</h1>
        <p class="text-gray-600">Perbarui data gelombang pendaftaran</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            {{-- Form action points to the update route, passing the specific wave ID --}}
            <form action="{{ route('admin.gelombang.update', $gelombang->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Use PUT method for updating resource --}}
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_ajaran_id" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('tahun_ajaran_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjarans as $ta)
                            {{-- The select option is pre-selected based on existing data --}}
                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $gelombang->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_ajaran_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Nama Gelombang <span class="text-red-500">*</span></label>
                    {{-- The input value is pre-filled with existing data --}}
                    <input type="text" name="nama_gelombang" value="{{ old('nama_gelombang', $gelombang->nama_gelombang) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama_gelombang') border-red-500 @enderror" 
                           placeholder="Contoh: Gelombang 1"
                           required>
                    @error('nama_gelombang')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Mulai <span class="text-red-500">*</span></label>
                        {{-- The date input is pre-filled with existing data --}}
                        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $gelombang->tanggal_mulai) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('tanggal_mulai') border-red-500 @enderror" 
                               required>
                        @error('tanggal_mulai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Selesai <span class="text-red-500">*</span></label>
                        {{-- The date input is pre-filled with existing data --}}
                        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $gelombang->tanggal_selesai) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('tanggal_selesai') border-red-500 @enderror" 
                               required>
                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Kuota <span class="text-red-500">*</span></label>
                    {{-- The number input is pre-filled with existing data --}}
                    <input type="number" name="kuota" value="{{ old('kuota', $gelombang->kuota) }}" min="1"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('kuota') border-red-500 @enderror" 
                           required>
                    @error('kuota')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        {{-- The checkbox is checked based on the existing 'is_active' status --}}
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gelombang->is_active) ? 'checked' : '' }} 
                               class="mr-2">
                        <span class="text-gray-700">Set sebagai gelombang aktif</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">Hanya satu gelombang per tahun ajaran yang bisa aktif</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.gelombang.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
