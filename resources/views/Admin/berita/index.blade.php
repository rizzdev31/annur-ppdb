@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Berita & Informasi</h1>
            <p class="text-gray-600">Manage berita dan informasi terbaru</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <form method="GET" action="{{ route('admin.berita.index') }}" class="flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari berita..." 
                   class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            
            <select name="status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            
            <select name="kategori" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                <option value="prestasi" {{ request('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
            </select>
            
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            @if(request('search') || request('status') || request('kategori'))
                <a href="{{ route('admin.berita.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Featured</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Hero</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Views</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($beritas as $berita)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration + ($beritas->currentPage() - 1) * $beritas->perPage() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($berita->image)
                            <img src="{{ Storage::url($berita->image) }}" alt="{{ $berita->image_alt ?? $berita->judul }}" 
                                 class="h-16 w-24 object-cover rounded">
                        @else
                            <div class="h-16 w-24 bg-gray-200 rounded flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="font-medium">{{ Str::limit($berita->judul, 40) }}</div>
                        <div class="text-gray-500 text-xs">{{ Str::limit($berita->excerpt, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($berita->kategori)
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                {{ ucfirst($berita->kategori) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $berita->author }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div>{{ $berita->created_at->format('d M Y') }}</div>
                        @if($berita->published_at)
                            <div class="text-xs text-gray-500">Pub: {{ $berita->published_at->format('d M Y') }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $berita->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($berita->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($berita->is_featured)
                            <i class="fas fa-star text-yellow-500"></i>
                        @else
                            <i class="far fa-star text-gray-300"></i>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                        <span class="text-gray-600">{{ $berita->views ?? 0 }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('berita.show', $berita->slug) }}" 
                               target="_blank"
                               class="text-gray-600 hover:text-gray-900"
                               title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.berita.edit', $berita->id) }}" 
                               class="text-blue-600 hover:text-blue-900"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.berita.destroy', $berita->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-10 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <p class="mt-2">
                            @if(request('search') || request('status') || request('kategori'))
                                Tidak ada berita yang ditemukan
                            @else
                                Belum ada berita
                            @endif
                        </p>
                        <a href="{{ route('admin.berita.create') }}" class="mt-3 text-blue-600 hover:text-blue-800">
                            Tulis berita pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($beritas->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $beritas->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection