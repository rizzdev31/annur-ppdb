@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Berita</h1>
            <p class="text-gray-600">Perbarui informasi berita</p>
        </div>
        <a href="{{ route('admin.berita.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                   value="{{ old('judul', $berita->judul) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                                       value="{{ old('slug', $berita->slug) }}" 
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
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Ringkasan singkat berita (max 255 karakter)"
                                      maxlength="255"
                                      required>{{ old('excerpt', $berita->excerpt) }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="excerpt-count">{{ strlen($berita->excerpt) }}</span>/255 karakter
                            </p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Isi Berita <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" 
                                      id="content"
                                      rows="15" 
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Tulis isi berita lengkap..."
                                      required>{{ old('content', $berita->content) }}</textarea>
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
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $berita->status == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Kategori
                            </label>
                            <select name="kategori" 
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kategori</option>
                                <option value="pengumuman" {{ $berita->kategori == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="kegiatan" {{ $berita->kategori == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="prestasi" {{ $berita->kategori == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                                <option value="artikel" {{ $berita->kategori == 'artikel' ? 'selected' : '' }}>Artikel</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Penulis
                            </label>
                            <input type="text" 
                                   name="author" 
                                   value="{{ old('author', $berita->author ?? Auth::user()->name) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Nama penulis">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tanggal Publikasi
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d\TH:i') : '') }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk publish sekarang</p>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ $berita->is_featured ? 'checked' : '' }}
                                       class="mr-2">
                                <span class="text-gray-700">Berita Utama</span>
                            </label>
                        </div>

                         <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_highlighted" 
                                       value="1" 
                                       {{ $berita->is_highlighted ? 'checked' : '' }}
                                       class="mr-2">
                                <span class="text-gray-700 font-semibold">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                    Tampilkan di Hero Landing Page
                                </span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-6">
                                Berita akan ditampilkan sebagai highlight utama di halaman depan
                            </p>
                        </div>
                        
                    </div>
                </div>
                

                <!-- Gambar -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-image text-orange-500 mr-2"></i> Gambar Berita
                    </h2>
                    
                    <div class="space-y-4">
                        @if($berita->image)
                        <div>
                            <p class="text-sm text-gray-700 mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $berita->image) }}" 
                                 alt="{{ $berita->judul }}"
                                 class="w-full rounded-lg shadow">
                        </div>
                        @endif

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Ganti Gambar
                            </label>
                            <input type="file" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">
                                Format: JPG, PNG, WebP (Max 2MB). Kosongkan jika tidak ingin mengubah
                            </p>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Alt Text Gambar
                            </label>
                            <input type="text" 
                                   name="image_alt" 
                                   value="{{ old('image_alt', $berita->image_alt) }}" 
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
                                      maxlength="160">{{ old('meta_description', $berita->meta_description) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="meta-count">{{ strlen($berita->meta_description ?? '') }}</span>/160 karakter
                            </p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Keywords
                            </label>
                            <input type="text" 
                                   name="keywords" 
                                   value="{{ old('keywords', $berita->keywords) }}" 
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="kata kunci, dipisah koma">
                            <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-between items-center bg-white rounded-lg shadow-lg p-6">
            <div>
                <p class="text-sm text-gray-500">
                    Terakhir diupdate: {{ $berita->updated_at->format('d M Y H:i') }}
                </p>
            </div>
            <div class="space-x-2">
                <a href="{{ route('admin.berita.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-300">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" 
                        name="action" 
                        value="save"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                @if($berita->status == 'draft')
                <button type="submit" 
                        name="action" 
                        value="publish"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-paper-plane"></i> Simpan & Publish
                </button>
                @endif
            </div>
        </div>
    </form>
</div>

@push('styles')
<!-- Include TinyMCE or CKEditor for rich text editing (optional) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
@endpush

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

// Optional: Add TinyMCE for rich text editing
// tinymce.init({
//     selector: '#content',
//     plugins: 'link image code table lists',
//     toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code'
// });
</script>
@endpush
@endsection