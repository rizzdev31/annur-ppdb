@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm mb-6">
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-800">
                    Berita
                </a>
                @if($berita->kategori)
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('berita.index', ['kategori' => $berita->kategori]) }}" class="text-blue-600 hover:text-blue-800">
                        {{ ucfirst($berita->kategori) }}
                    </a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-600">{{ Str::limit($berita->judul, 30) }}</span>
            </nav>

            <!-- Article -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden">
                @if($berita->image)
                    <div class="relative">
                        <img src="{{ Storage::url($berita->image) }}" 
                             alt="{{ $berita->image_alt ?? $berita->judul }}" 
                             class="w-full h-96 object-cover">
                        @if($berita->is_featured)
                            <span class="absolute top-4 left-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-star mr-1"></i>Berita Utama
                            </span>
                        @endif
                    </div>
                @endif
                
                <div class="p-8">
                    <!-- Category & Date -->
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        @if($berita->kategori)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ ucfirst($berita->kategori) }}
                            </span>
                        @endif
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $berita->published_at->format('d F Y, H:i') }} WIB
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $berita->author }}
                        </div>
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $berita->views }} views
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $berita->judul }}</h1>
                    
                    <!-- Excerpt -->
                    @if($berita->excerpt)
                        <div class="text-lg text-gray-600 font-medium mb-6 pb-6 border-b">
                            {{ $berita->excerpt }}
                        </div>
                    @endif
                    
                    <!-- Content -->
                    <div class="prose prose-lg max-w-none text-gray-700">
                        {!! nl2br(e($berita->content)) !!}
                    </div>
                    
                    <!-- Tags/Keywords -->
                    @if($berita->keywords)
                        <div class="mt-8 pt-6 border-t">
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="text-gray-600 font-semibold">Tags:</span>
                                @foreach(explode(',', $berita->keywords) as $keyword)
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                                        #{{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Share Buttons -->
                    <div class="mt-8 pt-6 border-t">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 font-semibold mb-2">Bagikan:</p>
                                <div class="flex items-center gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                       target="_blank"
                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                                       target="_blank"
                                       class="bg-sky-400 text-white px-4 py-2 rounded-lg hover:bg-sky-500">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                                       target="_blank"
                                       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('berita.index') }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Berita
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if($beritaTerkait->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($beritaTerkait as $terkait)
                    <a href="{{ route('berita.show', $terkait->slug) }}" 
                       class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300 group">
                        @if($terkait->image)
                            <img src="{{ Storage::url($terkait->image) }}" 
                                 alt="{{ $terkait->image_alt ?? $terkait->judul }}" 
                                 class="w-full h-32 object-cover rounded-t-lg">
                        @else
                            <div class="w-full h-32 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            @if($terkait->kategori)
                                <span class="text-xs text-blue-600">{{ ucfirst($terkait->kategori) }}</span>
                            @endif
                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 mt-1">
                                {{ Str::limit($terkait->judul, 50) }}
                            </h3>
                            <p class="text-gray-500 text-sm mt-2">
                                {{ $terkait->published_at->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('meta')
<!-- SEO Meta Tags -->
<meta name="description" content="{{ $berita->meta_description ?? $berita->excerpt }}">
<meta name="keywords" content="{{ $berita->keywords }}">
<meta property="og:title" content="{{ $berita->judul }}">
<meta property="og:description" content="{{ $berita->excerpt }}">
<meta property="og:image" content="{{ $berita->image ? asset('storage/' . $berita->image) : '' }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta name="twitter:card" content="summary_large_image">
@endpush
@endsection