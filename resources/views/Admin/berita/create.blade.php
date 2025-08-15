@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tambah Berita</h1>
            <p class="text-gray-600">Buat berita atau informasi baru</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Judul & Slug -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-heading text-blue-500 mr-2"></i> Judul & URL
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul"
                                   value="{{ old('judul') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('judul') border-red-500 @enderror"
                                   placeholder="Masukkan judul berita"
                                   required>
                            @error('judul')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Slug URL
                            </label>
                            <div class="flex items-center">
                                <span class="text-gray-500 text-sm mr-2">{{ url('/berita') }}/</span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug"
                                       value="{{ old('slug') }}" 
                                       class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       readonly>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Slug akan dibuat otomatis dari judul</p>
                        </div>
                    </div>
                </div>

                <!-- Konten -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-file-alt text-green-500 mr-2"></i> Konten Berita
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Ringkasan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="excerpt" 
                                      rows="3" 
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('excerpt') border-red-500 @enderror"
                                      placeholder="Ringkasan singkat berita (max 255 karakter)"
                                      maxlength="255"
                                      required>{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="excerpt-count">0</span>/255 karakter
                            </p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Isi Berita <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" 
                                      id="content"
                                      rows="15" 
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                                      placeholder="Tulis isi berita lengkap..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publikasi -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-cog text-purple-500 mr-2"></i> Publikasi
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                                    required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Kategori
                            </label>
                            <select name="kategori" 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kategori</option>
                                <option value="pengumuman" {{ old('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="prestasi" {{ old('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="artikel" {{ old('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Penulis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="author" 
                                   value="{{ old('author', Auth::user()->name) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('author') border-red-500 @enderror"
                                   placeholder="Nama penulis"
                                   required>
                            @error('author')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tanggal Publikasi
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   value="{{ old('published_at') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk publish sekarang</p>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured') ? 'checked' : '' }}
                                       class="mr-2">
                                <span class="text-gray-700">Berita Utama</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Gambar -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-image text-orange-500 mr-2"></i> Gambar Berita
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Upload Gambar <span class="text-red-500">*</span>
                            </label>
                            <input type="file" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">
                                Format: JPG, PNG, WebP (Max 2MB)
                            </p>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <img id="preview" class="hidden w-full rounded-lg shadow">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Alt Text Gambar
                            </label>
                            <input type="text" 
                                   name="image_alt" 
                                   value="{{ old('image_alt') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Deskripsi gambar untuk SEO">
                        </div>
                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-search text-teal-500 mr-2"></i> SEO
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Meta Description
                            </label>
                            <textarea name="meta_description" 
                                      rows="3" 
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Deskripsi untuk mesin pencari (max 160 karakter)"
                                      maxlength="160">{{ old('meta_description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="meta-count">0</span>/160 karakter
                            </p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Keywords
                            </label>
                            <input type="text" 
                                   name="keywords" 
                                   value="{{ old('keywords') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="kata kunci, dipisah koma">
                            <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end items-center bg-white rounded-lg shadow-lg p-6">
            <div class="space-x-2">
                <a href="{{ route('admin.berita.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-300">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" 
                        name="action" 
                        value="draft"
                        class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition duration-300">
                    <i class="fas fa-save"></i> Simpan Draft
                </button>
                <button type="submit" 
                        name="action" 
                        value="publish"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-paper-plane"></i> Simpan & Publish
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Auto generate slug from title
document.getElementById('judul').addEventListener('input', function() {
    let slug = this.value.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;
});

// Character counter for excerpt
document.querySelector('textarea[name="excerpt"]').addEventListener('input', function() {
    document.getElementById('excerpt-count').textContent = this.value.length;
});

// Character counter for meta description
document.querySelector('textarea[name="meta_description"]').addEventListener('input', function() {
    document.getElementById('meta-count').textContent = this.value.length;
});

// Preview image
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
@endsection