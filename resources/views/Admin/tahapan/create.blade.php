@extends('layouts.admin')

@section('title', 'Tambah Tahapan Pendaftaran')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.tahapan.index') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Tahapan Pendaftaran</h1>
        </div>
        <p class="text-gray-600">Tambahkan tahapan pendaftaran baru</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl">
        <form action="{{ route('admin.tahapan.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-3">
                        <div class="flex-1">
                            <input type="text" 
                                   name="icon" 
                                   id="icon" 
                                   value="{{ old('icon') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('icon') border-red-500 @enderror"
                                   placeholder="fa-whatsapp"
                                   required>
                        </div>
                        <div id="iconPreview" class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-question"></i>
                        </div>
                    </div>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Gunakan nama class Font Awesome (contoh: fa-whatsapp, fa-edit, fa-download)
                        <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline ml-1">Lihat daftar icon →</a>
                    </p>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Tahapan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: Hubungi Admin"
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
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan detail tahapan ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Deskripsi lengkap akan ditampilkan saat pengguna klik "Baca Selengkapnya"</p>
                </div>

                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan/Langkah Ke-
                    </label>
                    <input type="number" 
                           name="urutan" 
                           id="urutan" 
                           value="{{ old('urutan', 1) }}"
                           min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('urutan') border-red-500 @enderror"
                           placeholder="1">
                    @error('urutan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Menentukan urutan tahapan dalam alur pendaftaran</p>
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
                <a href="{{ route('admin.tahapan.index') }}" 
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

    <!-- Icon Examples -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6 max-w-4xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Contoh Icon yang Sering Digunakan:</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-whatsapp"></i>
                </div>
                <span class="text-sm text-gray-600">fa-whatsapp</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-edit"></i>
                </div>
                <span class="text-sm text-gray-600">fa-edit</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-download"></i>
                </div>
                <span class="text-sm text-gray-600">fa-download</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <span class="text-sm text-gray-600">fa-sign-in-alt</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-user-plus"></i>
                </div>
                <span class="text-sm text-gray-600">fa-user-plus</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="text-sm text-gray-600">fa-check-circle</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-teal-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="text-sm text-gray-600">fa-file-alt</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center text-white">
                    <i class="fas fa-envelope"></i>
                </div>
                <span class="text-sm text-gray-600">fa-envelope</span>
            </div>
        </div>
    </div>
</div>

<script>
// Update icon preview
document.getElementById('icon').addEventListener('input', function(e) {
    const iconPreview = document.getElementById('iconPreview');
    const iconClass = e.target.value || 'fa-question';
    iconPreview.innerHTML = `<i class="fas ${iconClass}"></i>`;
});
</script>
@endsection