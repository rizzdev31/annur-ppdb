@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Berita</h1>
        <p class="text-gray-600">Buat berita atau informasi baru</p>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('judul') border-red-500 @enderror" 
                           placeholder="Masukkan judul berita"
                           required>
                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Konten Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" rows="10" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('konten') border-red-500 @enderror"
                              placeholder="Tulis konten berita..."
                              required>{{ old('konten') }}</textarea>
                    @error('konten')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Foto Cover <span class="text-red-500">*</span></label>
                        <input type="file" name="foto" accept="image/*" 
                               class="w-full px-4 py-2 border rounded-lg @error('foto') border-red-500 @enderror" 
                               onchange="previewImage(this)"
                               required>
                        <div class="mt-2">
                            <img id="preview" class="hidden w-full rounded-lg">
                        </div>
                        @error('foto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" value="{{ old('penulis', Auth::user()->name) }}" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('penulis') border-red-500 @enderror" 
                               required>
                        @error('penulis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6 mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} 
                               class="mr-2">
                        <span class="text-gray-700">Publish sekarang</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1">Jika tidak dicentang, berita akan disimpan sebagai draft</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.berita.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit" name="action" value="draft"
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Simpan Draft
                    </button>
                    <button type="submit" name="action" value="publish"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Publish
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection