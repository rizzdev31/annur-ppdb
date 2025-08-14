@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Tahun Ajaran</h1>
        <p class="text-gray-600">Perbarui data tahun ajaran</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            {{-- Form action points to the update route, passing the specific academic year ID --}}
            <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Use PUT method for updating resource --}}
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                    {{-- The input value is pre-filled with existing data --}}
                    {{-- old() helper is used to retain user input if validation fails --}}
                    <input type="text" name="tahun" value="{{ old('tahun', $tahunAjaran->tahun) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('tahun') border-red-500 @enderror" 
                           placeholder="Contoh: 2025/2026"
                           required>
                    @error('tahun')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        {{-- The checkbox is checked based on the existing 'is_active' status --}}
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }} 
                               class="mr-2">
                        <span class="text-gray-700">Set sebagai tahun ajaran aktif</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">Hanya satu tahun ajaran yang bisa aktif</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.tahun-ajaran.index') }}" 
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
