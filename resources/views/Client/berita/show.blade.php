@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('berita.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Berita
            </a>

            <!-- Article -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden">
                @if($berita->foto)
                    <img src="{{ Storage::url($berita->foto) }}" 
                         alt="{{ $berita->judul }}" 
                         class="w-full h-96 object-cover">
                @endif
                
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $berita->judul }}</h1>
                    
                    <div class="flex items-center text-gray-500 mb-6 pb-6 border-b">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $berita->published_at->format('d F Y') }}
                        <span class="mx-3">•</span>
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $berita->penulis }}
                    </div>
                    
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($berita->konten)) !!}
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
                       class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300">
                        @if($terkait->foto)
                            <img src="{{ Storage::url($terkait->foto) }}" 
                                 alt="{{ $terkait->judul }}" 
                                 class="w-full h-32 object-cover rounded-t-lg">
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 hover:text-blue-600">
                                {{ Str::limit($terkait->judul, 50) }}
                            </h3>
                            <p class="text-gray-500 text-sm mt-1">
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
@endsection