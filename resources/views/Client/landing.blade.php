@extends('layouts.client')

@section('content')
<!-- Hero Section - PPDB -->
<section class="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative z-10 text-center text-white px-4">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in">
            PPDB MUBOSTA / MA eMAS {{ date('Y') }}
        </h1>
        <p class="text-xl md:text-2xl mb-8 animate-slide-up">
            Penerimaan Peserta Didik Baru 
            @if($tahunAjaranAktif)
                Tahun Ajaran {{ $tahunAjaranAktif->tahun }}
            @endif
        </p>
        
        @if($gelombangAktif)
        <div class="bg-white/20 backdrop-blur rounded-lg p-4 mb-8 max-w-2xl mx-auto">
            <p class="text-lg font-semibold mb-2">{{ $gelombangAktif->nama_gelombang }}</p>
            <p class="text-sm">
                Periode: {{ $gelombangAktif->tanggal_mulai->format('d M Y') }} - {{ $gelombangAktif->tanggal_selesai->format('d M Y') }}
            </p>
            <p class="text-sm mt-2">
                Kuota: <span class="font-bold">{{ $gelombangAktif->sisa_kuota }}</span> dari {{ $gelombangAktif->kuota }} tersedia
            </p>
        </div>
        @endif
        
        <div class="space-x-4">
            <a href="{{ route('ppdb.token') }}" 
               class="inline-block bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transform hover:scale-105 transition duration-300">
                Daftar Sekarang
            </a>
            <a href="#informasi" 
               class="inline-block border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-gray-900 transition duration-300">
                Informasi Lebih Lanjut
            </a>
        </div>
    </div>
    
    <!-- Animated scroll indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Fasilitas Section -->
@if($fasilitas->count() > 0)
<section id="fasilitas" class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Fasilitas Kami</h2>
        
        <div class="swiper fasilitasSwiper">
            <div class="swiper-wrapper">
                @foreach($fasilitas as $item)
                <div class="swiper-slide">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300">
                        @if($item->foto)
                            <img src="{{ Storage::url($item->foto) }}" 
                                 alt="{{ $item->nama }}" 
                                 class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->nama }}</h3>
                            <p class="text-gray-600">{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif

<!-- Program Section -->
@if($programs->count() > 0)
<section id="program" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Program Unggulan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($programs as $program)
            <div class="group relative overflow-hidden rounded-xl shadow-lg cursor-pointer">
                @if($program->foto)
                    <img src="{{ Storage::url($program->foto) }}" 
                         alt="{{ $program->nama }}" 
                         class="w-full h-72 object-cover group-hover:scale-110 transition duration-500">
                @else
                    <div class="w-full h-72 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                    <div class="p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $program->nama }}</h3>
                        <p class="text-sm opacity-90">{{ $program->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Berita Section -->
@if($beritas->count() > 0)
<section id="informasi" class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Informasi Terbaru</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritas as $berita)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                @if($berita->foto)
                    <img src="{{ Storage::url($berita->foto) }}" 
                         alt="{{ $berita->judul }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-500">No Image</span>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $berita->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($berita->konten, 100) }}</p>
                    <a href="{{ route('berita.show', $berita->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold">
                        Baca Selengkapnya →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        
        @if($beritas->count() >= 6)
        <div class="text-center mt-8">
            <a href="{{ route('berita.index') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                Lihat Semua Berita
            </a>
        </div>
        @endif
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-800">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Siap Bergabung Dengan Kami?</h2>
        <p class="text-xl text-white/90 mb-8">Daftarkan diri Anda sekarang dan jadilah bagian dari keluarga besar kami</p>
        <div class="space-x-4">
            <a href="{{ route('ppdb.token') }}" 
               class="inline-block bg-yellow-400 text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transform hover:scale-105 transition duration-300">
                Daftar Sekarang
            </a>
            <a href="{{ route('santri.login') }}" 
               class="inline-block bg-white text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transform hover:scale-105 transition duration-300">
                Login Santri
            </a>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    // Initialize Swiper for Fasilitas
    const swiper = new Swiper('.fasilitasSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>
@endpush
@endsection