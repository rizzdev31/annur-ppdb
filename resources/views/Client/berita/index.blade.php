@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Berita & Informasi</h1>
            <p class="text-gray-600">Informasi terbaru seputar PPDB dan kegiatan sekolah</p>
        </div>

        <!-- Search -->
        <div class="max-w-2xl mx-auto mb-8">
            <form method="GET" action="{{ route('berita.index') }}" class="flex gap-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berita..." 
                       class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('berita.index') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Berita Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($beritas as $berita)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                @if($berita->foto)
                    <img src="{{ Storage::url($berita->foto) }}" 
                         alt="{{ $berita->judul }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $berita->published_at->format('d M Y') }}
                        <span class="mx-2">•</span>
                        {{ $berita->penulis }}
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $berita->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($berita->konten, 100) }}</p>
                    <a href="{{ route('berita.show', $berita->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                        Baca Selengkapnya 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </article>
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