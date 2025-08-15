@extends('layouts.client')

@section('content')
<!-- Hero Section - PPDB with Background Video/Animation -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Video atau Animated Gradient -->
    <div class="absolute inset-0">
        <!-- Option 1: YouTube Video Background (uncomment jika ingin pakai video) -->
        <!--
        <div class="absolute inset-0 w-full h-full overflow-hidden">
            <iframe 
                class="absolute top-1/2 left-1/2 w-[177.77777778vh] min-w-full h-[56.25vw] min-h-full transform -translate-x-1/2 -translate-y-1/2"
                src="https://www.youtube.com/embed/VIDEO_ID?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&autohide=1&playlist=VIDEO_ID" 
                frameborder="0" 
                allow="autoplay; encrypted-media">
            </iframe>
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-indigo-900/70 to-purple-900/80"></div>
        </div>
        -->
        
        <!-- Option 2: Animated Gradient Background -->
       <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-700 to-blue-300 animate-gradient-shift">
            <div class="absolute inset-0 opacity-50">
                <div class="absolute inset-0 bg-gradient-to-tr from-yellow-400 via-sky-500 to-white animate-gradient-shift-reverse"></div>
            </div>
        </div>
        
        <!-- Overlay dengan pattern -->
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <!-- Animated particles -->
        <div class="absolute inset-0">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle particle-lg"></div>
            <div class="particle particle-lg"></div>
        </div>
        
        <!-- Floating shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 py-20">
        <!-- Main Content Box with Image -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 md:p-12 shadow-2xl max-w-7xl mx-auto animate-fade-in-up">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- Text Content -->
                <div class="text-white order-2 md:order-1">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-slide-in-left">
                        PPDB MUBOSTA
                        <span class="block text-3xl md:text-5xl text-yellow-300 mt-2">MA eMAS {{ date('Y') }}</span>
                    </h1>
                    <p class="text-lg md:text-xl mb-8 animate-slide-in-left animation-delay-200">
                        Penerimaan Peserta Didik Baru 
                        @if($tahunAjaranAktif)
                            <span class="font-semibold">Tahun Ajaran {{ $tahunAjaranAktif->tahun }}</span>
                        @endif
                    </p>
                    
                    @if($gelombangAktif)
                    <div class="bg-white/20 backdrop-blur rounded-xl p-4 mb-6 animate-slide-in-left animation-delay-400">
                        <p class="text-lg font-semibold mb-2">
                            <i class="fas fa-calendar-check mr-2"></i>{{ $gelombangAktif->nama_gelombang }}
                        </p>
                        <p class="text-sm">
                            <i class="fas fa-clock mr-2"></i>Periode: {{ $gelombangAktif->tanggal_mulai->format('d M Y') }} - {{ $gelombangAktif->tanggal_selesai->format('d M Y') }}
                        </p>
                        <div class="mt-3">
                            <div class="bg-white/30 rounded-full h-6 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-full transition-all duration-1000 ease-out"
                                     style="width: {{ ($gelombangAktif->sisa_kuota / $gelombangAktif->kuota) * 100 }}%"></div>
                            </div>
                            <p class="text-sm mt-2">
                                <i class="fas fa-users mr-2"></i>Kuota Tersedia: <span class="font-bold text-yellow-300">{{ $gelombangAktif->sisa_kuota }}</span> dari {{ $gelombangAktif->kuota }}
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex flex-col sm:flex-row gap-4 animate-slide-in-left animation-delay-600">
                        @if(Auth::guard('pendaftaran')->check())
                            <a href="{{ route('santri.dashboard') }}" 
                               class="inline-flex items-center justify-center bg-green-400 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-green-300 transform hover:scale-105 transition duration-300 shadow-lg">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                        @else
                            <a href="{{ route('ppdb.token') }}" 
                               class="inline-flex items-center justify-center bg-yellow-400 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transform hover:scale-105 transition duration-300 shadow-lg hover:shadow-xl">
                                <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                            </a>
                        @endif
                        <a href="#tahapan" 
                           class="inline-flex items-center justify-center border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-gray-900 transition duration-300">
                            <i class="fas fa-info-circle mr-2"></i>Informasi
                        </a>
                    </div>
                </div>
                
                <!-- Animated Image Content -->
                <div class="relative animate-slide-in-right order-1 md:order-2">
                    <!-- Main Illustration -->
                    <div class="relative">
                        <!-- You can replace this with actual PNG image -->
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/People/Student.png" 
                             alt="Student" 
                             class="w-full max-w-md mx-auto animate-float">
                        
                        <!-- Or use placeholder if no image -->
                        <!--
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl transform hover:scale-105 transition duration-500">
                            <img src="https://via.placeholder.com/600x400/4F46E5/FFFFFF?text=MUBOSTA+MA+eMAS" 
                                 alt="MUBOSTA MA eMAS" 
                                 class="w-full h-auto">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                        -->
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 bg-yellow-400 text-gray-900 rounded-full p-4 shadow-lg animate-bounce-slow">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-green-400 text-gray-900 rounded-full p-4 shadow-lg animate-bounce-slow animation-delay-400">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <div class="absolute top-1/2 -right-8 bg-pink-400 text-white rounded-full p-3 shadow-lg animate-pulse">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    
                    <!-- Floating Icons Around -->
                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 animate-float-delayed">
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Objects/Books.png" 
                             alt="Books" 
                             class="w-16 h-16">
                    </div>
                    <div class="absolute -bottom-8 right-1/4 animate-float">
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Objects/Graduation%20Cap.png" 
                             alt="Graduation Cap" 
                             class="w-12 h-12">
                    </div>
                    <div class="absolute top-1/4 -left-12 animate-spin-slow">
                        <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Travel%20and%20places/Star.png" 
                             alt="Star" 
                             class="w-10 h-10">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Animated scroll indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Tahapan Pendaftaran Section -->
@if($tahapans->count() > 0)
<section id="tahapan" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Tahapan Pendaftaran</h2>
            <p class="text-gray-600 text-lg">Ikuti langkah-langkah mudah untuk mendaftar</p>
        </div>
        
        <div class="relative">
            <!-- Timeline line for desktop -->
            <div class="hidden md:block absolute top-24 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-{{ $tahapans->count() }} gap-8">
                @foreach($tahapans as $index => $tahapan)
                <div class="relative group">
                    <!-- Timeline dot -->
                    <div class="hidden md:block absolute top-20 left-1/2 transform -translate-x-1/2 w-8 h-8 bg-white border-4 border-indigo-500 rounded-full group-hover:scale-125 transition-transform"></div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white shadow-lg">
                                <i class="fas {{ $tahapan->icon }} text-3xl"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full mb-3">
                                Langkah {{ $tahapan->urutan }}
                            </span>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $tahapan->nama }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $tahapan->deskripsi }}</p>
                            <button onclick="showModal('tahapan', {{ json_encode($tahapan) }})" 
                                    class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                                Baca Selengkapnya →
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Jenjang Pendidikan Section -->
@if($jenjangs->count() > 0)
<section id="jenjang" class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Jenjang Pendidikan</h2>
            <p class="text-gray-600 text-lg">Pilihan program pendidikan yang tersedia</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($jenjangs as $jenjang)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:scale-105">
                @if($jenjang->foto)
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ Storage::url($jenjang->foto) }}" 
                             alt="{{ $jenjang->nama }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        @if($jenjang->durasi)
                        <div class="absolute top-4 right-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold">
                            {{ $jenjang->durasi }}
                        </div>
                        @endif
                    </div>
                @else
                    <div class="h-64 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-6xl"></i>
                    </div>
                @endif
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $jenjang->nama }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $jenjang->deskripsi }}</p>
                    <button onclick="showModal('jenjang', {{ json_encode($jenjang) }})" 
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold">
                        Baca Selengkapnya
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Fasilitas Section with Read More -->
@if($fasilitas->count() > 0)
<section id="fasilitas" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Fasilitas Kami</h2>
            <p class="text-gray-600 text-lg">Sarana dan prasarana terbaik untuk mendukung pembelajaran</p>
        </div>
        
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
                            <div class="w-full h-64 bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                                <i class="fas fa-building text-white text-5xl"></i>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $item->nama }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi }}</p>
                            <button onclick="showModal('fasilitas', {{ json_encode($item) }})" 
                                    class="text-blue-600 hover:text-blue-800 font-semibold">
                                Baca Selengkapnya →
                            </button>
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

<!-- Program Section with Read More -->
@if($programs->count() > 0)
<section id="program" class="py-20 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Program Unggulan</h2>
            <p class="text-gray-600 text-lg">Program-program terbaik untuk mengembangkan potensi santri</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($programs as $program)
            <div class="group relative overflow-hidden rounded-xl shadow-lg cursor-pointer">
                @if($program->foto)
                    <img src="{{ Storage::url($program->foto) }}" 
                         alt="{{ $program->nama }}" 
                         class="w-full h-72 object-cover group-hover:scale-110 transition duration-500">
                @else
                    <div class="w-full h-72 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-star text-white text-5xl"></i>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end">
                    <div class="p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2">{{ $program->nama }}</h3>
                        <p class="text-sm opacity-90 mb-3 line-clamp-2">{{ $program->deskripsi }}</p>
                        <button onclick="showModal('program', {{ json_encode($program) }})" 
                                class="inline-flex items-center bg-white/20 backdrop-blur px-4 py-2 rounded-full hover:bg-white/30 transition">
                            <span class="text-sm font-semibold">Baca Selengkapnya</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Ekstrakurikuler Section -->
@if($ekstrakurikulers->count() > 0)
<section id="ekstrakurikuler" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Ekstrakurikuler</h2>
            <p class="text-gray-600 text-lg">Kembangkan bakat dan minat melalui berbagai kegiatan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($ekstrakurikulers as $ekskul)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                @if($ekskul->foto)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ Storage::url($ekskul->foto) }}" 
                             alt="{{ $ekskul->nama }}" 
                             class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                @else
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                        <i class="fas fa-users text-white text-4xl"></i>
                    </div>
                @endif
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $ekskul->nama }}</h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $ekskul->deskripsi }}</p>
                    <button onclick="showModal('ekstrakurikuler', {{ json_encode($ekskul) }})" 
                            class="text-green-600 hover:text-green-800 font-semibold text-sm">
                        Selengkapnya →
                    </button>
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
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Informasi Terbaru</h2>
            <p class="text-gray-600 text-lg">Berita dan pengumuman terkini</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritas as $berita)
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
                @if($berita->image)
                    <img src="{{ Storage::url($berita->image) }}" 
                         alt="{{ $berita->image_alt ?? $berita->judul }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl"></i>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center text-gray-500 text-sm mb-2">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}
                        @if($berita->kategori)
                            <span class="mx-2">•</span>
                            <span class="text-blue-600">{{ ucfirst($berita->kategori) }}</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $berita->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ $berita->excerpt ?? Str::limit($berita->content, 100) }}</p>
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
               class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Lihat Semua Berita
            </a>
        </div>
        @endif
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 via-indigo-700 to-purple-800">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            @if(Auth::guard('pendaftaran')->check())
                Selamat Datang di PPDB Online
            @else
                Siap Bergabung Dengan Kami?
            @endif
        </h2>
        <p class="text-xl text-white/90 mb-8">
            @if(Auth::guard('pendaftaran')->check())
                Pantau terus status pendaftaran Anda melalui dashboard
            @else
                Daftarkan diri Anda sekarang dan jadilah bagian dari keluarga besar kami
            @endif
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(Auth::guard('pendaftaran')->check())
                <a href="{{ route('santri.dashboard') }}" 
                   class="inline-flex items-center justify-center bg-green-400 text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-green-300 transform hover:scale-105 transition duration-300 shadow-lg">
                    <i class="fas fa-tachometer-alt mr-2"></i>Ke Dashboard
                </a>
                <a href="{{ route('santri.profile') }}" 
                   class="inline-flex items-center justify-center bg-white text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transform hover:scale-105 transition duration-300 shadow-lg">
                    <i class="fas fa-user mr-2"></i>Lihat Profil
                </a>
            @else
                <a href="{{ route('ppdb.token') }}" 
                   class="inline-flex items-center justify-center bg-yellow-400 text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-yellow-300 transform hover:scale-105 transition duration-300 shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </a>
                <a href="{{ route('santri.login') }}" 
                   class="inline-flex items-center justify-center bg-white text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transform hover:scale-105 transition duration-300 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login Santri
                </a>
            @endif
        </div>
    </div>
</section>

<!-- Modal for Read More -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden shadow-2xl transform transition-all">
        <div class="relative">
            <div id="modalHeader" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-6">
                <h3 id="modalTitle" class="text-2xl font-bold"></h3>
                <button onclick="closeModal()" class="absolute top-4 right-4 text-white hover:text-gray-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <div id="modalImage" class="mb-6 hidden">
                    <img id="modalImageSrc" src="" alt="" class="w-full h-64 object-cover rounded-lg">
                </div>
                <div id="modalContent" class="prose max-w-none text-gray-700"></div>
                <div id="modalExtra" class="mt-4 hidden">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* Custom animations */
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
    
    @keyframes slide-in-left {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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
    
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    @keyframes float-delayed {
        0%, 100% {
            transform: translateY(0px) translateX(-50%);
        }
        50% {
            transform: translateY(-15px) translateX(-50%);
        }
    }
    
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    @keyframes gradient-shift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    
    @keyframes gradient-shift-reverse {
        0% {
            background-position: 100% 50%;
        }
        50% {
            background-position: 0% 50%;
        }
        100% {
            background-position: 100% 50%;
        }
    }
    
    .animate-gradient-shift {
        background-size: 200% 200%;
        animation: gradient-shift 15s ease infinite;
    }
    
    .animate-gradient-shift-reverse {
        background-size: 200% 200%;
        animation: gradient-shift-reverse 20s ease infinite;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 1s ease-out;
    }
    
    .animate-slide-in-left {
        animation: slide-in-left 0.8s ease-out;
    }
    
    .animate-slide-in-right {
        animation: slide-in-right 0.8s ease-out;
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
    
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    
    .animate-float-delayed {
        animation: float-delayed 4s ease-in-out infinite;
        animation-delay: 0.5s;
    }
    
    .animate-spin-slow {
        animation: spin-slow 10s linear infinite;
    }
    
    .animation-delay-200 {
        animation-delay: 0.2s;
    }
    
    .animation-delay-400 {
        animation-delay: 0.4s;
    }
    
    .animation-delay-600 {
        animation-delay: 0.6s;
    }
    
    /* Particle animation */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: float-particle 15s infinite;
    }
    
    .particle-lg {
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.3);
    }
    
    .particle:nth-child(1) {
        top: 20%;
        left: 20%;
        animation-duration: 8s;
        animation-delay: 0s;
    }
    
    .particle:nth-child(2) {
        top: 60%;
        left: 80%;
        animation-duration: 10s;
        animation-delay: 2s;
    }
    
    .particle:nth-child(3) {
        top: 40%;
        left: 40%;
        animation-duration: 12s;
        animation-delay: 4s;
    }
    
    .particle:nth-child(4) {
        top: 80%;
        left: 10%;
        animation-duration: 15s;
        animation-delay: 1s;
    }
    
    .particle:nth-child(5) {
        top: 10%;
        left: 70%;
        animation-duration: 9s;
        animation-delay: 3s;
    }
    
    .particle:nth-child(6) {
        top: 30%;
        left: 90%;
        animation-duration: 11s;
        animation-delay: 5s;
    }
    
    .particle:nth-child(7) {
        top: 70%;
        left: 30%;
        animation-duration: 14s;
        animation-delay: 2.5s;
    }
    
    @keyframes float-particle {
        0%, 100% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }
        10% {
            opacity: 0.5;
        }
        90% {
            opacity: 0.5;
        }
        50% {
            transform: translateY(-100px) translateX(100px);
        }
    }
    
    /* Floating shapes */
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: float-shape 20s infinite;
    }
    
    .shape-1 {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        top: 10%;
        left: 10%;
        animation-duration: 25s;
    }
    
    .shape-2 {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        bottom: 10%;
        right: 10%;
        animation-duration: 20s;
        animation-delay: 5s;
    }
    
    .shape-3 {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        top: 50%;
        right: 20%;
        animation-duration: 30s;
        animation-delay: 10s;
    }
    
    @keyframes float-shape {
        0%, 100% {
            transform: translate(0, 0) rotate(0deg);
        }
        33% {
            transform: translate(30px, -30px) rotate(120deg);
        }
        66% {
            transform: translate(-20px, 20px) rotate(240deg);
        }
    }
    
    /* Line clamp utility */
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
</style>
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
    
    // Modal functions
    function showModal(type, data) {
        const modal = document.getElementById('detailModal');
        const title = document.getElementById('modalTitle');
        const content = document.getElementById('modalContent');
        const imageDiv = document.getElementById('modalImage');
        const imageSrc = document.getElementById('modalImageSrc');
        const extraDiv = document.getElementById('modalExtra');
        const header = document.getElementById('modalHeader');
        
        // Set title
        title.textContent = data.nama || data.judul || '';
        
        // Set content
        content.innerHTML = `<p class="whitespace-pre-line">${data.deskripsi || data.content || ''}</p>`;
        
        // Set image if available
        if (data.foto || data.image) {
            imageDiv.classList.remove('hidden');
            imageSrc.src = `/storage/${data.foto || data.image}`;
            imageSrc.alt = data.nama || data.judul || '';
        } else {
            imageDiv.classList.add('hidden');
        }
        
        // Set extra info based on type
        if (type === 'jenjang' && data.durasi) {
            extraDiv.classList.remove('hidden');
            extraDiv.querySelector('span').textContent = `Durasi: ${data.durasi}`;
        } else if (type === 'tahapan') {
            extraDiv.classList.remove('hidden');
            extraDiv.querySelector('span').textContent = `Langkah ${data.urutan}`;
        } else {
            extraDiv.classList.add('hidden');
        }
        
        // Set header color based on type
        const headerColors = {
            'fasilitas': 'from-blue-600 to-indigo-700',
            'program': 'from-indigo-600 to-purple-700',
            'ekstrakurikuler': 'from-green-600 to-teal-700',
            'tahapan': 'from-blue-600 to-indigo-700',
            'jenjang': 'from-purple-600 to-pink-700'
        };
        
        header.className = `bg-gradient-to-r ${headerColors[type] || 'from-blue-600 to-indigo-700'} text-white p-6`;
        
        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal on outside click
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endpush
@endsection