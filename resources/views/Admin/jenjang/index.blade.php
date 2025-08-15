@extends('layouts.admin')

@section('title', 'Kelola Jenjang Pendidikan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Jenjang Pendidikan</h1>
            <p class="text-gray-600">Manage jenjang pendidikan yang ditampilkan di landing page</p>
        </div>
        <a href="{{ route('admin.jenjang.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Jenjang
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Jenjang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($jenjangs as $jenjang)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($jenjang->foto)
                            <img src="{{ Storage::url($jenjang->foto) }}" alt="{{ $jenjang->nama }}" 
                                 class="h-16 w-24 object-cover rounded cursor-pointer"
                                 onclick="showImage('{{ Storage::url($jenjang->foto) }}')">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $jenjang->nama }}</td>
                    <td class="px-6 py-4 text-sm">
                        <div class="max-w-xs">{{ Str::limit($jenjang->deskripsi, 100) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($jenjang->durasi)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                {{ $jenjang->durasi }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $jenjang->urutan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jenjang->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $jenjang->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.jenjang.edit', $jenjang->id) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('admin.jenjang.destroy', $jenjang->id) }}" 
                              method="POST" class="inline" 
                              onsubmit="return confirm('Yakin ingin menghapus jenjang {{ $jenjang->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        </svg>
                        <p class="mt-2">Belum ada jenjang pendidikan</p>
                        <a href="{{ route('admin.jenjang.create') }}" class="mt-3 text-blue-600 hover:text-blue-800">
                            Tambah jenjang pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($jenjangs->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $jenjangs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Image Preview -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <img id="modalImage" src="" alt="" class="max-w-full max-h-full rounded-lg">
</div>

<script>
function showImage(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection