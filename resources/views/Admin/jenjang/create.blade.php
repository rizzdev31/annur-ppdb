@extends('layouts.admin')

@section('title', 'Tambah Jenjang Pendidikan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.jenjang.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Jenjang Pendidikan</h1>
        </div>
        <p class="text-gray-600">Tambahkan Jenjang Pendidikan baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl">
        <form action="{{ route('admin.jenjang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Jenjang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none @error('nama') input-error @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror"
                           placeholder="Contoh: Pramuka"
                           required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="5"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none @error('deskripsi') input-error @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror"
                              placeholder="Jelaskan tentang kegiatan ekstrakurikuler ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Deskripsi lengkap akan ditampilkan saat pengguna klik "Baca Selengkapnya"</p>
                </div>

                <!-- Foto -->
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex items-center">
                        <div class="flex-1">
                            <input type="file" 
                                   name="foto" 
                                   id="foto" 
                                   accept="image/jpeg,image/jpg,image/png"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none @error('foto') input-error @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror"
                                   onchange="previewImage(this)"
                                   required>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                        </div>
                    </div>
                    <!-- Preview Image -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="preview" src="" alt="Preview" class="h-48 w-auto rounded-lg shadow-md">
                    </div>
                </div>

                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampilan
                    </label>
                    <input type="number" 
                           name="urutan" 
                           id="urutan" 
                           value="{{ old('urutan', 0) }}"
                           min="0"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:outline-none @error('urutan') input-error @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror"
                           placeholder="0">
                    @error('urutan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Angka lebih kecil akan ditampilkan lebih dulu</p>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               id="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Aktif (Tampilkan di landing page)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.jenjang.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewDiv.classList.add('hidden');
    }
}
</script>
@endsection