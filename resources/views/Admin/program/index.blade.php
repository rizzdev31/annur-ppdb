@extends('layouts.admin')

@section('title', 'Kelola Program')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Program</h1>
            <p class="text-gray-600">Manage program unggulan yang ditampilkan di landing page</p>
        </div>
        <a href="{{ route('admin.program.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($programs as $program)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($program->foto)
                                <img src="{{ Storage::url($program->foto) }}" 
                                     alt="{{ $program->nama }}" 
                                     class="h-16 w-24 object-cover rounded cursor-pointer hover:opacity-80 transition"
                                     onclick="showImage('{{ Storage::url($program->foto) }}', '{{ $program->nama }}')">
                            @else
                                <div class="h-16 w-24 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $program->nama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="max-w-xs line-clamp-2">{{ $program->deskripsi }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">{{ $program->urutan }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $program->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $program->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.program.edit', $program->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.program.destroy', $program->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirmDelete('{{ $program->nama }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-xl font-medium mb-2">Belum ada program</p>
                            <p class="text-gray-400 mb-4">Mulai dengan menambahkan program unggulan pertama Anda</p>
                            <a href="{{ route('admin.program.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Program Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($programs->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $programs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Image Preview -->
<div id="imageModal" 
     class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4"
     onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        <button type="button"
                onclick="closeImageModal()"
                class="absolute -top-10 right-0 text-white hover:text-gray-300 transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" 
             src="" 
             alt="" 
             class="max-w-full max-h-[80vh] rounded-lg shadow-2xl"
             onclick="event.stopPropagation()">
        <p id="imageCaption" class="text-white text-center mt-4"></p>
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Fix for z-index issues */
    #imageModal {
        z-index: 9999 !important;
    }
    
    /* Ensure main content is not overlapped */
    main {
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    // Image preview functions
    function showImage(src, alt = '') {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const caption = document.getElementById('imageCaption');
        
        if (modal && modalImg) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalImg.src = src;
            modalImg.alt = alt;
            if (caption) {
                caption.textContent = alt;
            }
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
    
    // Confirm delete function
    function confirmDelete(programName) {
        return confirm(`Apakah Anda yakin ingin menghapus program "${programName}"?\n\nTindakan ini tidak dapat dibatalkan.`);
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            closeImageModal();
        }
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Fix z-index issues
        const tables = document.querySelectorAll('table');
        tables.forEach(table => {
            table.style.position = 'relative';
            table.style.zIndex = '1';
        });
        
        // Ensure all buttons are clickable
        const buttons = document.querySelectorAll('button, a');
        buttons.forEach(button => {
            button.style.position = 'relative';
            button.style.zIndex = '10';
        });
    });
</script>
@endpush
@endsection