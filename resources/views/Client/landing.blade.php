@extends('layouts.client')

@section('content')

<!-- Hero Section - Modern Design with Sky Blue Theme -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-sky-50 via-white to-sky-100">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <!-- Gradient Orbs with GPU Acceleration -->
        <div class="absolute top-0 -left-40 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-40 w-80 h-80 bg-sky-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-20 w-80 h-80 bg-sky-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%230EA5E9" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 py-20">
        @if($highlightedBerita)
        <!-- Highlighted News Content - Modern Card Design -->
        <div class="max-w-7xl mx-auto">
            <!-- News Badge -->
            <div class="mb-8 flex justify-center animate-bounce-slow">
                <span class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-bold text-sm shadow-lg">
                    <span class="animate-pulse mr-2">🔥</span> BERITA TERKINI
                </span>
            </div>
            
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform hover:scale-[1.02] transition-all duration-500">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- News Image -->
                    <div class="relative h-full animate-fade-in">
                        @if($highlightedBerita->image)
                        <div class="relative h-full min-h-[400px]">
                            <img src="{{ Storage::url($highlightedBerita->image) }}" 
                                 alt="{{ $highlightedBerita->image_alt ?? $highlightedBerita->judul }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            
                            <!-- Floating Badge -->
                            <div class="absolute top-6 left-6">
                                <span class="inline-block px-4 py-2 bg-yellow-400 text-black rounded-full text-xs font-bold shadow-lg animate-pulse">
                                    <i class="fas fa-fire mr-1"></i> HOT NEWS
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="h-full min-h-[400px] bg-gradient-to-br from-sky-400 via-sky-500 to-blue-600 flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-newspaper text-8xl mb-4 animate-float"></i>
                                <p class="text-2xl font-bold">Breaking News</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- News Content -->
                    <div class="p-8 md:p-12 flex flex-col justify-center animate-slide-in-right">
                        <!-- Category & Date -->
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            @if($highlightedBerita->kategori)
                            <span class="inline-block px-3 py-1 bg-sky-100 text-sky-800 rounded-full text-xs font-semibold">
                                {{ strtoupper($highlightedBerita->kategori) }}
                            </span>
                            @endif
                            <span class="text-sm text-gray-500">
                                <i class="far fa-calendar mr-1"></i>
                                {{ $highlightedBerita->published_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $highlightedBerita->judul }}
                        </h1>
                        
                        <!-- Excerpt -->
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            {{ $highlightedBerita->excerpt }}
                        </p>
                        
                        <!-- Meta Info -->
                        <div class="flex items-center gap-6 text-sm text-gray-500 mb-8">
                            <span>
                                <i class="fas fa-user-circle mr-1"></i>
                                {{ $highlightedBerita->author }}
                            </span>
                            @if($highlightedBerita->views > 0)
                            <span>
                                <i class="fas fa-eye mr-1"></i>
                                {{ number_format($highlightedBerita->views) }} views
                            </span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('berita.show', $highlightedBerita->slug) }}" 
                               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-semibold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-book-open mr-2"></i>Baca Selengkapnya
                            </a>
                            <a href="{{ route('ppdb.token') }}" 
                               class="inline-flex items-center px-8 py-3 bg-white border-2 border-gray-900 text-gray-900 rounded-full font-semibold hover:bg-gray-900 hover:text-white transition-all duration-300">
                                <i class="fas fa-user-plus mr-2"></i>Daftar PPDB
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PPDB Quick Info -->
            @if($gelombangAktif)
            <div class="mt-8 bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-400 rounded-2xl p-6 shadow-xl animate-fade-in-up">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-black mb-4 md:mb-0">
                        <p class="font-bold text-lg">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            PPDB {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun : date('Y') }}
                        </p>
                        <p class="text-sm opacity-90">
                            {{ $gelombangAktif->nama_gelombang }} • Kuota: {{ $gelombangAktif->sisa_kuota }}/{{ $gelombangAktif->kuota }}
                        </p>
                    </div>
                    <a href="{{ route('ppdb.token') }}" 
                       class="bg-black text-white px-6 py-3 rounded-full font-bold hover:bg-gray-800 transition-all duration-300 hover:shadow-lg">
                        Daftar Sekarang →
                    </a>
                </div>
            </div>
            @endif
        </div>
        @else
        <!-- Default PPDB Hero - Modern Design -->
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0 items-center">
                    <!-- Text Content -->
                    <div class="p-8 md:p-12 order-2 md:order-1 animate-fade-in">
                        <!-- Badge -->
                        <div class="inline-block mb-6">
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                📚 Pendaftaran Dibuka!
                            </span>
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl font-bold mb-6">
                            <span class="text-gray-900">PPDB</span>
                            <span class="text-sky-500 block mt-2">MUBOSTA</span>
                            <span class="text-2xl md:text-3xl text-gray-600 font-normal block mt-2">
                                MA eMAS {{ date('Y') }}
                            </span>
                        </h1>
                        
                        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                            Penerimaan Peserta Didik Baru 
                            @if($tahunAjaranAktif)
                                <span class="font-semibold text-gray-900">Tahun Ajaran {{ $tahunAjaranAktif->tahun }}</span>
                            @endif
                        </p>
                        
                        @if($gelombangAktif)
                        <div class="bg-sky-50 border-l-4 border-sky-500 rounded-lg p-4 mb-8">
                            <p class="font-semibold text-gray-900 mb-2">
                                <i class="fas fa-info-circle text-sky-500 mr-2"></i>
                                {{ $gelombangAktif->nama_gelombang }}
                            </p>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>📅 {{ $gelombangAktif->tanggal_mulai->format('d M') }} - {{ $gelombangAktif->tanggal_selesai->format('d M Y') }}</p>
                                <div class="mt-3">
                                    <div class="flex justify-between mb-1">
                                        <span>Kuota Tersedia</span>
                                        <span class="font-bold">{{ $gelombangAktif->sisa_kuota }}/{{ $gelombangAktif->kuota }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="bg-gradient-to-r from-sky-400 to-blue-500 h-full rounded-full transition-all duration-1000 ease-out"
                                             style="width: {{ ($gelombangAktif->sisa_kuota / $gelombangAktif->kuota) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex flex-wrap gap-4">
                            @if(Auth::guard('pendaftaran')->check())
                                <a href="{{ route('santri.dashboard') }}" 
                                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ route('ppdb.token') }}" 
                                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                                </a>
                            @endif
                            <a href="#tahapan" 
                               class="inline-flex items-center px-8 py-4 bg-white border-2 border-gray-900 text-gray-900 rounded-full font-bold hover:bg-gray-900 hover:text-white transition-all duration-300">
                                <i class="fas fa-info-circle mr-2"></i>Informasi
                            </a>
                        </div>
                    </div>
                    
                    <!-- Image/Illustration -->
                    <div class="relative h-full min-h-[500px] order-1 md:order-2 bg-gradient-to-br from-sky-400 via-blue-500 to-blue-600 animate-gradient">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white p-8">
                                <div class="relative">
                                    <div class="w-48 h-48 mx-auto mb-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-float">
                                        <i class="fas fa-graduation-cap text-8xl"></i>
                                    </div>
                                    <!-- Floating Elements -->
                                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center text-black animate-bounce-slow">
                                        <i class="fas fa-star text-2xl"></i>
                                    </div>
                                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white rounded-full flex items-center justify-center text-sky-500 animate-bounce-slow animation-delay-1000">
                                        <i class="fas fa-award text-2xl"></i>
                                    </div>
                                </div>
                                <h2 class="text-3xl font-bold mb-2">Raih Masa Depan Gemilang</h2>
                                <p class="text-white/90">Pendidikan Berkualitas, Akhlak Mulia</p>
                            </div>
                        </div>
                        
                        <!-- Decorative Shapes -->
                        <div class="absolute top-10 left-10 w-20 h-20 bg-yellow-400/30 rounded-full animate-pulse"></div>
                        <div class="absolute bottom-10 right-10 w-32 h-32 bg-white/20 rounded-full animate-pulse animation-delay-1000"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-10 h-16 border-2 border-gray-900 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-gray-900 rounded-full mt-2 animate-scroll"></div>
        </div>
    </div>
</section>

<!-- Wave Divider after Hero -->
<div class="custom-shape-divider-bottom-1">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
</div>

<!-- Tahapan Pendaftaran - Modern Timeline -->
@if($tahapans->count() > 0)
<section id="tahapan" class="py-20 bg-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="section-pattern"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">Proses Mudah</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Tahapan Pendaftaran</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Ikuti langkah-langkah sederhana untuk bergabung dengan kami</p>
            </div>
        </div>
        
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-{{ $tahapans->count() }} gap-8 relative">
                <!-- Connection Line -->
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-sky-300 via-yellow-300 to-sky-300 transform -translate-y-1/2"></div>
                
                @foreach($tahapans as $index => $tahapan)
                <div class="relative group animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 transform hover:-translate-y-2 relative z-10">
                        <!-- Step Number -->
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <div class="w-8 h-8 bg-gradient-to-r from-sky-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ $tahapan->urutan }}
                            </div>
                        </div>
                        
                        <!-- Icon -->
                        <div class="mb-6 flex justify-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-sky-100 to-blue-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas {{ $tahapan->icon }} text-3xl text-sky-600"></i>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">{{ $tahapan->nama }}</h3>
                        <p class="text-gray-600 text-center text-sm mb-4 line-clamp-3">{{ $tahapan->deskripsi }}</p>
                        
                        <button onclick='showModal("tahapan", @json($tahapan))' 
                                class="w-full py-2 text-sky-600 hover:text-sky-800 font-semibold text-sm transition-colors">
                            Pelajari Lebih Lanjut →
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Geometric Section Divider -->
<div class="section-divider-geometric">
    <div class="divider-shape-1"></div>
    <div class="divider-shape-2"></div>
    <div class="divider-shape-3"></div>
</div>

<!-- Jenjang Pendidikan - Modern Cards -->
@if($jenjangs->count() > 0)
<section id="jenjang" class="py-20 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
    <div class="section-pattern"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-yellow-600 font-semibold text-sm uppercase tracking-wider">Program Kami</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Jenjang Pendidikan</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilih program pendidikan yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($jenjangs as $index => $jenjang)
            <div class="group animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    @if($jenjang->foto)
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ Storage::url($jenjang->foto) }}" 
                                 alt="{{ $jenjang->nama }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            @if($jenjang->durasi)
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 bg-yellow-400 text-black rounded-full text-xs font-bold">
                                    {{ $jenjang->durasi }}
                                </span>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="h-64 bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $jenjang->nama }}</h3>
                        <p class="text-gray-600 mb-6 line-clamp-3">{{ $jenjang->deskripsi }}</p>
                        
                        <button onclick='showModal("jenjang", @json($jenjang))' 
                                class="inline-flex items-center text-sky-600 hover:text-sky-800 font-semibold group">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Curved Section Divider -->
<div class="custom-shape-divider-top-1">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
    </svg>
</div>

<!-- Fasilitas - Modern Carousel -->
@if($fasilitas->count() > 0)
<section id="fasilitas" class="py-20 bg-white relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">Fasilitas Lengkap</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Fasilitas Kami</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Sarana dan prasarana modern untuk mendukung pembelajaran optimal</p>
            </div>
        </div>
        
        <div class="swiper fasilitasSwiper">
            <div class="swiper-wrapper">
                @foreach($fasilitas as $item)
                <div class="swiper-slide">
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300">
                        @if($item->foto)
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ Storage::url($item->foto) }}" 
                                     alt="{{ $item->nama }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @else
                            <div class="h-64 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                <i class="fas fa-building text-white text-5xl"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->nama }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi }}</p>
                            
                            <button onclick='showModal("fasilitas", @json($item))' 
                                    class="text-sky-600 hover:text-sky-800 font-semibold inline-flex items-center group">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-8"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
@endif

<!-- Zigzag Section Divider -->
<div class="section-divider-zigzag">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,0 L150,50 L300,0 L450,50 L600,0 L750,50 L900,0 L1050,50 L1200,0 L1200,120 L0,120 Z" class="shape-fill"></path>
    </svg>
</div>

<!-- Program Unggulan - Modern Grid -->
@if($programs->count() > 0)
<section id="program" class="py-20 bg-gradient-to-br from-gray-50 via-white to-sky-50 relative overflow-hidden">
    <div class="section-pattern"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-yellow-600 font-semibold text-sm uppercase tracking-wider">Excellence</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Program Unggulan</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Program-program terbaik untuk mengembangkan potensi santri</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($programs as $index => $program)
            <div class="group animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                <div class="relative bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    @if($program->foto)
                        <div class="h-72 overflow-hidden">
                            <img src="{{ Storage::url($program->foto) }}" 
                                 alt="{{ $program->nama }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    @else
                        <div class="h-72 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-star text-white text-5xl"></i>
                        </div>
                    @endif
                    
                    <!-- Overlay Content -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $program->nama }}</h3>
                        <p class="text-white/90 text-sm mb-4 line-clamp-2">{{ $program->deskripsi }}</p>
                        
                        <button onclick='showModal("program", @json($program))' 
                                class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full hover:bg-white/30 transition-all duration-300 group">
                            <span class="text-sm font-semibold">Pelajari</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Ornamental Divider -->
<div class="ornamental-divider">
    <div class="ornament-line"></div>
    <div class="ornament-center">
        <span class="ornament-dot"></span>
        <span class="ornament-dot"></span>
        <span class="ornament-dot"></span>
    </div>
    <div class="ornament-line"></div>
</div>

<!-- Ekstrakurikuler - Modern Cards -->
@if($ekstrakurikulers->count() > 0)
<section id="ekstrakurikuler" class="py-20 bg-white relative overflow-hidden">
    <div class="section-pattern"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-green-600 font-semibold text-sm uppercase tracking-wider">Aktivitas</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Ekstrakurikuler</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Kembangkan bakat dan minat melalui berbagai kegiatan</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            @foreach($ekstrakurikulers as $index => $ekskul)
            <div class="animate-fade-in-up" style="animation-delay: {{ $index * 50 }}ms">
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                    @if($ekskul->foto)
                        <div class="h-48 overflow-hidden">
                            <img src="{{ Storage::url($ekskul->foto) }}" 
                                 alt="{{ $ekskul->nama }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-users text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $ekskul->nama }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $ekskul->deskripsi }}</p>
                        
                        <button onclick='showModal("ekstrakurikuler", @json($ekskul))' 
                                class="text-green-600 hover:text-green-800 font-semibold text-sm inline-flex items-center group">
                            <span>Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gradient Wave Divider -->
<div class="gradient-wave-divider">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
        <defs>
            <linearGradient id="wave-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#0EA5E9;stop-opacity:0.3" />
                <stop offset="50%" style="stop-color:#FACC15;stop-opacity:0.3" />
                <stop offset="100%" style="stop-color:#0EA5E9;stop-opacity:0.3" />
            </linearGradient>
        </defs>
        <path d="M0,56 C150,100 350,0 600,56 C850,112 1050,0 1200,56 L1200,120 L0,120 Z" fill="url(#wave-gradient)"></path>
    </svg>
</div>

<!-- Berita Section - Modern Blog Cards -->
@if($beritas->count() > 0)
<section id="informasi" class="py-20 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
    <div class="section-pattern"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-sky-500 font-semibold text-sm uppercase tracking-wider">Update</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Informasi Terbaru</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Berita dan pengumuman terkini dari sekolah kami</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach($beritas as $index => $berita)
            <article class="animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    @if($berita->image)
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ Storage::url($berita->image) }}" 
                                 alt="{{ $berita->image_alt ?? $berita->judul }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-white text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            @if($berita->kategori)
                                <span class="px-2 py-1 bg-sky-100 text-sky-700 rounded-full text-xs font-semibold">
                                    {{ ucfirst($berita->kategori) }}
                                </span>
                            @endif
                            <span class="text-gray-500 text-xs">
                                {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-sky-600 transition-colors">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $berita->excerpt ?? Str::limit($berita->content, 100) }}
                        </p>
                        
                        <a href="{{ route('berita.show', $berita->slug) }}" 
                           class="inline-flex items-center text-sky-600 hover:text-sky-800 font-semibold text-sm group">
                            <span>Baca Selengkapnya</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        @if($beritas->count() >= 6)
        <div class="text-center mt-12">
            <a href="{{ route('berita.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <span>Lihat Semua Berita</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Animated Divider before Social Media -->
<div class="animated-divider">
    <div class="divider-animation">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<!-- Social Media Section - Improved Responsive Design -->
<section id="social-media" class="py-20 bg-gradient-to-br from-white via-gray-50 to-white relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-72 h-72 bg-gradient-to-br from-pink-200 to-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-blob"></div>
        <div class="absolute bottom-20 right-20 w-72 h-72 bg-gradient-to-br from-yellow-200 to-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-to-br from-cyan-200 to-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-16 animate-fade-in">
            <div class="section-header-decoration">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600 font-semibold text-sm uppercase tracking-wider">Stay Connected</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Follow Us on Social Media</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Ikuti update terbaru kegiatan dan informasi sekolah kami di berbagai platform media sosial</p>
            </div>
        </div>
        
        <!-- Social Media Cards with Proper Aspect Ratios -->
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- YouTube Card - 16:9 Aspect Ratio -->
                <div class="group animate-fade-in-up">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <!-- YouTube Header -->
                        <div class="h-14 bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-between px-6">
                            <div class="flex items-center">
                                <i class="fab fa-youtube text-white text-2xl"></i>
                                <span class="ml-3 text-white font-bold">YouTube</span>
                            </div>
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        </div>
                        
                        <div class="p-6">
                            <!-- YouTube Video Container - 16:9 -->
                            <div class="youtube-container rounded-xl overflow-hidden shadow-lg mb-4">
                                <iframe 
                                    src="https://www.youtube.com/embed/zE07WiDE3wk&t" 
                                    title="YouTube video" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    class="w-full h-full">
                                </iframe>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-2">Video Profil Sekolah</h3>
                            <p class="text-gray-600 text-sm mb-4">MA eMAS Muhammadiyah An Nur</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-eye mr-1"></i>12K views</span>
                                    <span><i class="fas fa-thumbs-up mr-1"></i>856</span>
                                </div>
                                <a href="https://www.youtube.com/@ppm.an-nursidoarjoofficial6323" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-full text-sm font-semibold transition-all duration-300">
                                    <i class="fab fa-youtube mr-2"></i>Subscribe
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Instagram Card - 4:5 Aspect Ratio -->
                <div class="group animate-fade-in-up" style="animation-delay: 100ms">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <!-- Instagram Header -->
                        <div class="h-14 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 flex items-center justify-between px-6">
                            <div class="flex items-center">
                                <i class="fab fa-instagram text-white text-2xl"></i>
                                <span class="ml-3 text-white font-bold">Instagram</span>
                            </div>
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        </div>
                        
                        <div class="p-6">
                            <!-- Instagram Post Container - 4:5 -->
                            <div class="instagram-container rounded-xl overflow-hidden shadow-lg mb-4">
                                <img src="https://www.instagram.com/p/DMGuWb6TOt9/?utm_source=ig_web_button_share_sheet&igsh=MzRlODBiNWFlZA==" alt="Instagram post" class="w-full h-full object-cover">
                                <!-- Instagram Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <div class="text-white">
                                        <p class="font-bold">@ppmannursidoarjoofficial</p>
                                        <p class="text-sm opacity-90">Kegiatan pembelajaran terbaru</p>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-2">Latest Post</h3>
                            <p class="text-gray-600 text-sm mb-4">Aktivitas dan kegiatan sekolah</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-heart mr-1"></i>342</span>
                                    <span><i class="fas fa-comment mr-1"></i>28</span>
                                </div>
                                <a href="https://www.instagram.com/ppmannursidoarjoofficial" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full text-sm font-semibold transition-all duration-300">
                                    <i class="fab fa-instagram mr-2"></i>Follow
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TikTok Card - 9:16 Aspect Ratio -->
                <div class="group animate-fade-in-up" style="animation-delay: 200ms">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <!-- TikTok Header -->
                        <div class="h-14 bg-gradient-to-r from-gray-900 to-gray-800 flex items-center justify-between px-6 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-red-500 to-cyan-500 opacity-50"></div>
                            <div class="flex items-center relative z-10">
                                <i class="fab fa-tiktok text-white text-2xl"></i>
                                <span class="ml-3 text-white font-bold">TikTok</span>
                            </div>
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse relative z-10"></span>
                        </div>
                        
                        <div class="p-6">
                            <!-- TikTok Video Container - 9:16 -->
                            <div class="tiktok-container rounded-xl overflow-hidden shadow-lg mb-4 mx-auto">
                                <div class="w-full h-full bg-gradient-to-br from-pink-500 via-purple-500 to-cyan-500 flex items-center justify-center relative">
                                    <div class="text-center text-white relative z-10">
                                        <i class="fab fa-tiktok text-6xl mb-4 animate-bounce-slow"></i>
                                        <p class="text-lg font-bold">Latest Video</p>
                                        <p class="text-sm opacity-90 mt-2">#PPDBOnline</p>
                                        <p class="text-xs opacity-75">#Muhammadiyah</p>
                                    </div>
                                    <!-- Animated Background -->
                                    <div class="absolute inset-0">
                                        <div class="absolute top-0 left-0 w-full h-full bg-white/10 transform rotate-45 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-2">Trending Video</h3>
                            <p class="text-gray-600 text-sm mb-4">Tips PPDB dan info sekolah</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    <span><i class="fas fa-heart mr-1"></i>5.2K</span>
                                    <span><i class="fas fa-share mr-1"></i>189</span>
                                </div>
                                <a href="https://www.tiktok.com/@ppmannursidoarjoofficiai?is_from_webapp=1&sender_device=pc" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-black text-white rounded-full text-sm font-semibold transition-all duration-300">
                                    <i class="fab fa-tiktok mr-2"></i>Follow
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Social Media Statistics -->
            <div class="mt-12 bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div class="animate-fade-in">
                        <div class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">5K+</div>
                        <div class="text-gray-600 text-sm mt-1">Total Followers</div>
                    </div>
                    <div class="animate-fade-in" style="animation-delay: 100ms">
                        <div class="text-3xl font-bold bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">250+</div>
                        <div class="text-gray-600 text-sm mt-1">Video Content</div>
                    </div>
                    <div class="animate-fade-in" style="animation-delay: 200ms">
                        <div class="text-3xl font-bold bg-gradient-to-r from-blue-500 to-cyan-500 bg-clip-text text-transparent">2M+</div>
                        <div class="text-gray-600 text-sm mt-1">Total Views</div>
                    </div>
                    <div class="animate-fade-in" style="animation-delay: 300ms">
                        <div class="text-3xl font-bold bg-gradient-to-r from-green-500 to-teal-500 bg-clip-text text-transparent">98%</div>
                        <div class="text-gray-600 text-sm mt-1">Engagement Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final Section Divider -->
<div class="final-divider">
    <div class="divider-gradient"></div>
</div>

<!-- CTA Section - Modern Design -->
<section class="py-20 bg-gradient-to-br from-black via-gray-900 to-black relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block mb-6">
                <span class="px-4 py-2 bg-yellow-400/20 backdrop-blur-sm text-yellow-400 rounded-full text-sm font-semibold animate-pulse">
                    ✨ Masa Depan Dimulai Dari Sini
                </span>
            </div>
            
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                @if(Auth::guard('pendaftaran')->check())
                    Selamat Datang di PPDB Online
                @else
                    Siap Bergabung Dengan Kami?
                @endif
            </h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                @if(Auth::guard('pendaftaran')->check())
                    Pantau terus status pendaftaran Anda melalui dashboard
                @else
                    Daftarkan diri Anda sekarang dan jadilah bagian dari keluarga besar kami
                @endif
            </p>
            
            <div class="flex flex-wrap gap-4 justify-center">
                @if(Auth::guard('pendaftaran')->check())
                    <a href="{{ route('santri.dashboard') }}" 
                       class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-tachometer-alt mr-2"></i>Ke Dashboard
                    </a>
                    <a href="{{ route('santri.profile') }}" 
                       class="inline-flex items-center px-10 py-4 bg-white text-gray-900 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-user mr-2"></i>Lihat Profil
                    </a>
                @else
                    <a href="{{ route('ppdb.token') }}" 
                       class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                    </a>
                    <a href="{{ route('santri.login') }}" 
                       class="inline-flex items-center px-10 py-4 bg-white text-gray-900 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Santri
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Modern Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-hidden shadow-2xl transform transition-all animate-modal-in">
        <div class="relative">
            <div id="modalHeader" class="relative bg-gradient-to-r from-sky-500 to-blue-600 text-white p-8">
                <h3 id="modalTitle" class="text-3xl font-bold pr-10"></h3>
                <button onclick="closeModal()" class="absolute top-6 right-6 text-white/80 hover:text-white p-2 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-8 max-h-[60vh] overflow-y-auto">
                <div id="modalImage" class="mb-6 hidden">
                    <img id="modalImageSrc" src="" alt="" class="w-full h-64 object-cover rounded-2xl">
                </div>
                <div id="modalContent" class="prose prose-lg max-w-none text-gray-700"></div>
                <div id="modalExtra" class="mt-6 hidden">
                    <span class="inline-block bg-sky-100 text-sky-800 text-sm font-semibold px-4 py-2 rounded-full"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* Section Dividers - Enhanced Styles */
    .custom-shape-divider-bottom-1 {
        position: relative;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        transform: rotate(180deg);
        margin-top: -1px;
        height: 100px;
    }
    
    .custom-shape-divider-bottom-1 svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 100px;
    }
    
    .custom-shape-divider-bottom-1 .shape-fill {
        fill: #FFFFFF;
    }
    
    .custom-shape-divider-top-1 {
        position: relative;
        top: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
        margin-bottom: -1px;
        height: 80px;
    }
    
    .custom-shape-divider-top-1 svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 80px;
    }
    
    .custom-shape-divider-top-1 .shape-fill {
        fill: #F9FAFB;
    }
    
    /* Geometric Divider */
    .section-divider-geometric {
        height: 100px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .divider-shape-1, .divider-shape-2, .divider-shape-3 {
        position: absolute;
        width: 100px;
        height: 100px;
        background: linear-gradient(45deg, #0EA5E9 25%, transparent 25%, transparent 75%, #FACC15 75%);
        opacity: 0.1;
    }
    
    .divider-shape-1 {
        left: 25%;
        transform: rotate(45deg);
        animation: float 6s ease-in-out infinite;
    }
    
    .divider-shape-2 {
        left: 50%;
        transform: translateX(-50%) rotate(30deg);
        animation: float 8s ease-in-out infinite;
    }
    
    .divider-shape-3 {
        right: 25%;
        transform: rotate(60deg);
        animation: float 7s ease-in-out infinite;
    }
    
    /* Zigzag Divider */
    .section-divider-zigzag {
        position: relative;
        height: 60px;
        overflow: hidden;
        margin: 2rem 0;
    }
    
    .section-divider-zigzag svg {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    
    .section-divider-zigzag .shape-fill {
        fill: #F3F4F6;
    }
    
    /* Ornamental Divider */
    .ornamental-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 0;
        position: relative;
    }
    
    .ornament-line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, #0EA5E9, transparent);
    }
    
    .ornament-center {
        display: flex;
        gap: 1rem;
        padding: 0 2rem;
    }
    
    .ornament-dot {
        width: 8px;
        height: 8px;
        background: #0EA5E9;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
    }
    
    .ornament-dot:nth-child(2) {
        animation-delay: 0.5s;
        background: #FACC15;
    }
    
    .ornament-dot:nth-child(3) {
        animation-delay: 1s;
    }
    
    /* Gradient Wave Divider */
    .gradient-wave-divider {
        position: relative;
        height: 100px;
        overflow: hidden;
        margin: 2rem 0;
    }
    
    .gradient-wave-divider svg {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    
    /* Animated Divider */
    .animated-divider {
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .divider-animation {
        display: flex;
        justify-content: center;
        gap: 2rem;
    }
    
    .divider-animation span {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(45deg, #0EA5E9, #FACC15);
        animation: bounce-divider 1.5s ease-in-out infinite;
    }
    
    .divider-animation span:nth-child(2) {
        animation-delay: 0.2s;
    }
    
    .divider-animation span:nth-child(3) {
        animation-delay: 0.4s;
    }
    
    @keyframes bounce-divider {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-20px) scale(1.2); }
    }
    
    /* Final Divider */
    .final-divider {
        height: 80px;
        position: relative;
        overflow: hidden;
    }
    
    .divider-gradient {
        position: absolute;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(14, 165, 233, 0.3),
            rgba(250, 204, 21, 0.3),
            rgba(14, 165, 233, 0.3),
            transparent
        );
        animation: slide-gradient 10s linear infinite;
    }
    
    @keyframes slide-gradient {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }
    
    /* Social Media Aspect Ratio Containers */
    .youtube-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        background: #000;
    }
    
    .youtube-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .instagram-container {
        position: relative;
        width: 100%;
        max-width: 270px;
        aspect-ratio: 4/5; /* 1080x1350 */
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }
    
    .tiktok-container {
        position: relative;
        width: 100%;
        max-width: 200px;
        aspect-ratio: 9/16; /* 1080x1920 */
        background: #000;
    }
    
    /* Section Pattern */
    .section-pattern {
        position: absolute;
        inset: 0;
        opacity: 0.02;
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(14, 165, 233, 0.5) 35px, rgba(14, 165, 233, 0.5) 70px),
            repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(250, 204, 21, 0.5) 35px, rgba(250, 204, 21, 0.5) 70px);
    }
    
    /* Section Header Decoration */
    .section-header-decoration {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .section-header-decoration::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, #0EA5E9, #FACC15, #0EA5E9);
        border-radius: 2px;
    }
    
    /* Modern Animations */
    @keyframes blob {
        0%, 100% { 
            transform: translate(0, 0) scale(1); 
        }
        25% { 
            transform: translate(20px, -50px) scale(1.1); 
        }
        50% { 
            transform: translate(-20px, 20px) scale(1); 
        }
        75% { 
            transform: translate(50px, -20px) scale(0.9); 
        }
    }
    
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slide-in-right {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes scroll {
        0% { transform: translateY(0); }
        100% { transform: translateY(8px); }
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes modal-in {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Animation Classes */
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out both;
    }
    
    .animate-slide-in-right {
        animation: slide-in-right 0.8s ease-out;
    }
    
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
    
    .animate-scroll {
        animation: scroll 1.5s ease-in-out infinite;
    }
    
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
    }
    
    .animate-modal-in {
        animation: modal-in 0.3s ease-out;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Swiper Custom Styles */
    .swiper-button-next,
    .swiper-button-prev {
        color: #0EA5E9;
        background: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
        font-weight: bold;
    }
    
    .swiper-pagination-bullet {
        background: #0EA5E9;
        width: 10px;
        height: 10px;
        opacity: 0.5;
    }
    
    .swiper-pagination-bullet-active {
        opacity: 1;
        width: 30px;
        border-radius: 5px;
    }
    
    /* Line Clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #0EA5E9;
        border-radius: 5px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #0284C7;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    // Initialize Page Components
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
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
        
        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-fade-in-up').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    });
    
    // Modal Functions
    window.showModal = function(type, data) {
        const modal = document.getElementById('detailModal');
        const title = document.getElementById('modalTitle');
        const content = document.getElementById('modalContent');
        const imageDiv = document.getElementById('modalImage');
        const imageSrc = document.getElementById('modalImageSrc');
        const extraDiv = document.getElementById('modalExtra');
        const header = document.getElementById('modalHeader');
        
        // Parse data if string
        if (typeof data === 'string') {
            data = JSON.parse(data);
        }
        
        // Set content
        title.textContent = data.nama || data.judul || '';
        content.innerHTML = `<p class="text-gray-700 leading-relaxed">${data.deskripsi || data.content || 'Tidak ada deskripsi'}</p>`;
        
        // Handle image
        if (data.foto || data.image) {
            imageDiv.classList.remove('hidden');
            imageSrc.src = `/storage/${data.foto || data.image}`;
            imageSrc.alt = data.nama || data.judul || '';
        } else {
            imageDiv.classList.add('hidden');
        }
        
        // Handle extra info
        if (extraDiv) {
            if (type === 'jenjang' && data.durasi) {
                extraDiv.classList.remove('hidden');
                extraDiv.querySelector('span').textContent = `Durasi: ${data.durasi}`;
            } else if (type === 'tahapan') {
                extraDiv.classList.remove('hidden');
                extraDiv.querySelector('span').textContent = `Langkah ${data.urutan}`;
            } else {
                extraDiv.classList.add('hidden');
            }
        }
        
        // Set header gradient based on type
        const gradients = {
            'fasilitas': 'from-sky-500 to-blue-600',
            'program': 'from-indigo-500 to-purple-600',
            'ekstrakurikuler': 'from-green-500 to-teal-600',
            'tahapan': 'from-sky-500 to-blue-600',
            'jenjang': 'from-purple-500 to-pink-600'
        };
        
        header.className = `relative bg-gradient-to-r ${gradients[type] || 'from-sky-500 to-blue-600'} text-white p-8`;
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    
    window.closeModal = function() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal on outside click
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Close modal on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
@endsection