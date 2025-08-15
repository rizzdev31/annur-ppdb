@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Berita & Informasi</h1>
            <p class="text-gray-600">Informasi terbaru seputar PPDB dan kegiatan sekolah</p>
        </div>

        <!-- Search & Filter -->
        <div class="max-w-4xl mx-auto mb-8">
            <form method="GET" action="{{ route('berita.index') }}" class="flex flex-wrap gap-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berita..." 
                       class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                
                <select name="kategori" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="prestasi" {{ request('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>Artikel</option>
                </select>
                
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('berita.index') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Featured News (if any) -->
        @php
            $featuredBerita = $beritas->where('is_featured', true)->first();
        @endphp
        
        @if($featuredBerita && !request('search') && !request('kategori'))
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="md:flex">
                    @if($featuredBerita->image)
                        <div class="md:w-1/3">
                            <img src="{{ Storage::url($featuredBerita->image) }}" 
                                 alt="{{ $featuredBerita->image_alt ?? $featuredBerita->judul }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="p-8 {{ $featuredBerita->image ? 'md:w-2/3' : 'w-full' }}">
                        <div class="flex items-center mb-4">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">
                                <i class="fas fa-star mr-1"></i>Berita Utama
                            </span>
                            @if($featuredBerita->kategori)
                                <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ ucfirst($featuredBerita->kategori) }}
                                </span>
                            @endif
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $featuredBerita->judul }}</h2>
                        <p class="text-gray-600 mb-4">{{ $featuredBerita->excerpt }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $featuredBerita->published_at->format('d M Y') }}
                                <span class="mx-2">•</span>
                                {{ $featuredBerita->author }}
                                @if($featuredBerita->views > 0)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-eye mr-1"></i>{{ $featuredBerita->views }}
                                @endif
                            </div>
                            <a href="{{ route('berita.show', $featuredBerita->slug) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Berita Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($beritas as $berita)
                @if(!$berita->is_featured || request('search') || request('kategori'))
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                    @if($berita->image)
                        <img src="{{ Storage::url($berita->image) }}" 
                             alt="{{ $berita->image_alt ?? $berita->judul }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            @if($berita->kategori)
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ ucfirst($berita->kategori) }}
                                </span>
                            @endif
                            @if($berita->is_featured)
                                <span class="ml-2 text-yellow-500">
                                    <i class="fas fa-star"></i>
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $berita->judul }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($berita->excerpt, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $berita->published_at->format('d M Y') }}
                                @if($berita->views > 0)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-eye mr-1"></i>{{ $berita->views }}
                                @endif
                            </div>
                            <a href="{{ route('berita.show', $berita->slug) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
                @endif
            @empty
            <div class="col-span-3 text-center py-10">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <p class="mt-2 text-gray-500">
                    @if(request('search'))
                        Tidak ada berita yang ditemukan untuk "{{ request('search') }}"
                    @else
                        Belum ada berita
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($beritas->hasPages())
        <div class="mt-8">
            {{ $beritas->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection