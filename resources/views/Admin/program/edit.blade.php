@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Program</h1>
        <p class="text-gray-600">Update informasi program</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.program.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Nama Program <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $program->nama) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror" 
                           required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Foto Program</label>
                    
                    @if($program->foto)
                    <div class="mb-2">
                        <img src="{{ Storage::url($program->foto) }}" alt="{{ $program->nama }}" 
                             class="w-full max-w-xs rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                    </div>
                    @endif
                    
                    <input type="file" name="foto" accept="image/*" 
                           class="w-full px-4 py-2 border rounded-lg @error('foto') border-red-500 @enderror"
                           onchange="previewImage(this)">
                    <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto</p>
                    <div class="mt-2">
                        <img id="preview" class="hidden w-full max-w-xs rounded-lg">
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Urutan Tampilan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $program->urutan) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('urutan') border-red-500 @enderror">
                    @error('urutan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $program->is_active) ? 'checked' : '' }} 
                               class="mr-2">
                        <span class="text-gray-700">Aktif (Tampilkan di landing page)</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.program.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Program
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