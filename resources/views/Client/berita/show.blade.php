@extends('layouts.client')

@section('content')
<!-- Hero Section dengan Parallax Effect -->
<section class="relative min-h-[60vh] flex items-end overflow-hidden">
    <!-- Background Image dengan Parallax -->
    @if($berita->image)
    <div class="absolute inset-0">
        <img src="{{ Storage::url($berita->image) }}" 
             alt="{{ $berita->image_alt ?? $berita->judul }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
    </div>
    @else
    <div class="absolute inset-0 bg-gradient-to-br from-sky-600 via-blue-700 to-indigo-800">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23FFFFFF" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    @endif
    
    <!-- Content Overlay -->
    <div class="relative z-10 container mx-auto px-4 py-16">
        <div class="max-w-5xl animate-fade-in-up">
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm mb-6 text-white/80">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
                <span class="mx-2">/</span>
                <a href="{{ route('berita.index') }}" class="hover:text-white transition-colors">
                    Berita
                </a>
                @if($berita->kategori)
                    <span class="mx-2">/</span>
                    <a href="{{ route('berita.index', ['kategori' => $berita->kategori]) }}" class="hover:text-white transition-colors">
                        {{ ucfirst($berita->kategori) }}
                    </a>
                @endif
            </nav>
            
            <!-- Category & Featured Badge -->
            <div class="flex flex-wrap items-center gap-3 mb-6">
                @if($berita->kategori)
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-semibold">
                        {{ ucfirst($berita->kategori) }}
                    </span>
                @endif
                @if($berita->is_featured)
                    <span class="px-4 py-2 bg-yellow-400 text-black rounded-full text-sm font-bold animate-pulse">
                        <i class="fas fa-star mr-1"></i>Berita Utama
                    </span>
                @endif
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                {{ $berita->judul }}
            </h1>
            
            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-6 text-white/90">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/60">Penulis</p>
                        <p class="font-semibold">{{ $berita->author }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-calendar text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/60">Dipublikasikan</p>
                        <p class="font-semibold">{{ $berita->published_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-eye text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-white/60">Dibaca</p>
                        <p class="font-semibold">{{ number_format($berita->views) }} kali</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-12 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <article class="lg:col-span-2">
                    <!-- Excerpt dengan Style Modern -->
                    @if($berita->excerpt)
                    <div class="mb-8 p-6 bg-gradient-to-r from-sky-50 to-blue-50 rounded-2xl border-l-4 border-sky-500 animate-fade-in">
                        <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium italic">
                            "{{ $berita->excerpt }}"
                        </p>
                    </div>
                    @endif
                    
                    <!-- Article Body -->
                    <div class="prose prose-lg max-w-none text-gray-700 animate-fade-in-up">
                        <div class="space-y-4">
                            @foreach(explode("\n\n", $berita->content) as $paragraph)
                                @if(trim($paragraph))
                                <p class="text-gray-700 leading-relaxed first-letter:text-5xl first-letter:font-bold first-letter:float-left first-letter:mr-3 first-letter:text-sky-600">
                                    {{ $paragraph }}
                                </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    @if($berita->keywords)
                    <div class="mt-12 pt-8 border-t-2 border-gray-100 animate-fade-in">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-tags mr-2 text-sky-500"></i>Tags Terkait
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $berita->keywords) as $keyword)
                            <a href="{{ route('berita.index', ['search' => trim($keyword)]) }}" 
                               class="px-4 py-2 bg-gray-100 hover:bg-sky-100 text-gray-700 hover:text-sky-700 rounded-full text-sm font-medium transition-all duration-300 hover:scale-105">
                                #{{ trim($keyword) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </article>
                
                <!-- Sidebar -->
                <aside class="lg:col-span-1 space-y-6">
                    <!-- Share Box Sticky -->
                    <div class="sticky top-24 space-y-6">
                        <!-- Share Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg p-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-share-alt mr-2 text-sky-500"></i>Bagikan Berita
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 hover:scale-105 group">
                                    <i class="fab fa-facebook-f mr-2"></i>
                                    <span class="text-sm font-medium">Facebook</span>
                                </a>
                                
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center px-4 py-3 bg-sky-400 hover:bg-sky-500 text-white rounded-xl transition-all duration-300 hover:scale-105 group">
                                    <i class="fab fa-twitter mr-2"></i>
                                    <span class="text-sm font-medium">Twitter</span>
                                </a>
                                
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-all duration-300 hover:scale-105 group">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    <span class="text-sm font-medium">WhatsApp</span>
                                </a>
                                
                                <button onclick="copyToClipboard('{{ request()->url() }}')"
                                        class="flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-all duration-300 hover:scale-105 group">
                                    <i class="fas fa-link mr-2"></i>
                                    <span class="text-sm font-medium">Salin Link</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Reading Progress -->
                        <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-in">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-book-reader mr-2 text-sky-500"></i>Progress Membaca
                            </h3>
                            <div class="relative">
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div id="readingProgress" class="bg-gradient-to-r from-sky-400 to-blue-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">
                                    <span id="progressText">0%</span> selesai dibaca
                                </p>
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-2xl p-6 animate-fade-in">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <i class="fas fa-clock text-2xl text-sky-500 mb-2"></i>
                                    <p class="text-sm text-gray-500">Waktu Baca</p>
                                    <p class="font-bold text-gray-900">{{ ceil(str_word_count($berita->content) / 200) }} menit</p>
                                </div>
                                <div>
                                    <i class="fas fa-align-left text-2xl text-sky-500 mb-2"></i>
                                    <p class="text-sm text-gray-500">Jumlah Kata</p>
                                    <p class="font-bold text-gray-900">{{ str_word_count($berita->content) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($beritaTerkait->count() > 0)
<section class="py-16 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12 animate-fade-in">
                <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">Baca Juga</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Berita Terkait</h2>
            </div>
            
            <!-- Related Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritaTerkait as $index => $terkait)
                <article class="animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                    <a href="{{ route('berita.show', $terkait->slug) }}" 
                       class="group block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if($terkait->image)
                                <img src="{{ Storage::url($terkait->image) }}" 
                                     alt="{{ $terkait->image_alt ?? $terkait->judul }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                    <i class="fas fa-newspaper text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($terkait->kategori)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 rounded-full text-xs font-semibold">
                                    {{ ucfirst($terkait->kategori) }}
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <i class="far fa-calendar mr-2"></i>
                                {{ $terkait->published_at->format('d M Y') }}
                                @if($terkait->views > 0)
                                <span class="mx-2">•</span>
                                <i class="far fa-eye mr-1"></i>
                                {{ number_format($terkait->views) }}
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-sky-600 transition-colors line-clamp-2">
                                {{ $terkait->judul }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                                {{ Str::limit($terkait->excerpt, 80) }}
                            </p>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            
            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('berita.index') }}" 
                   class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-semibold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <span>Lihat Semua Berita</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-black via-gray-900 to-black relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-sky-400/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block mb-6">
                <span class="px-4 py-2 bg-yellow-400/20 backdrop-blur-sm text-yellow-400 rounded-full text-sm font-semibold animate-pulse">
                    ✨ Informasi PPDB
                </span>
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Tertarik Mendaftar di Sekolah Kami?
            </h2>
            <p class="text-lg text-gray-300 mb-8">
                Dapatkan informasi lengkap tentang Penerimaan Peserta Didik Baru
            </p>
            
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('ppdb.token') }}" 
                   class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Daftar PPDB
                </a>
                <a href="{{ route('berita.index') }}" 
                   class="inline-flex items-center px-8 py-3 bg-white/10 backdrop-blur-sm border-2 border-white text-white rounded-full font-bold hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Berita
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span>Link berhasil disalin!</span>
    </div>
</div>

@push('styles')
<style>
    /* Animations */
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
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out both;
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    /* Line Clamp */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Prose Enhancements */
    .prose p:first-of-type::first-letter {
        font-size: 3.5rem;
        font-weight: bold;
        float: left;
        margin-right: 0.5rem;
        line-height: 1;
        color: #0EA5E9;
    }
    
    /* Toast Animation */
    .toast-show {
        transform: translateY(0) !important;
    }
    
    /* Custom Selection */
    ::selection {
        background: #0EA5E9;
        color: white;
    }
    
    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script>
    // Reading Progress Indicator
    document.addEventListener('DOMContentLoaded', function() {
        const article = document.querySelector('article');
        const progressBar = document.getElementById('readingProgress');
        const progressText = document.getElementById('progressText');
        
        if (article && progressBar) {
            window.addEventListener('scroll', () => {
                const scrollTop = window.scrollY;
                const articleTop = article.offsetTop;
                const articleHeight = article.offsetHeight;
                const windowHeight = window.innerHeight;
                
                const scrollPercentage = Math.min(100, Math.max(0, 
                    ((scrollTop - articleTop + windowHeight) / articleHeight) * 100
                ));
                
                progressBar.style.width = scrollPercentage + '%';
                progressText.textContent = Math.round(scrollPercentage) + '%';
            });
        }
        
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
    
    // Copy to Clipboard Function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            const toast = document.getElementById('toast');
            toast.classList.add('toast-show');
            
            setTimeout(() => {
                toast.classList.remove('toast-show');
            }, 3000);
        });
    }
    
    // Parallax Effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElement = document.querySelector('.parallax-bg');
        
        if (parallaxElement) {
            parallaxElement.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
</script>
@endpush

@push('meta')
<!-- SEO Meta Tags -->
<meta name="description" content="{{ $berita->meta_description ?? $berita->excerpt }}">
<meta name="keywords" content="{{ $berita->keywords }}">
<meta property="og:title" content="{{ $berita->judul }}">
<meta property="og:description" content="{{ $berita->excerpt }}">
<meta property="og:image" content="{{ $berita->image ? asset('storage/' . $berita->image) : '' }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:type" content="article">
<meta property="article:author" content="{{ $berita->author }}">
<meta property="article:published_time" content="{{ $berita->published_at->toIso8601String() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $berita->judul }}">
<meta name="twitter:description" content="{{ $berita->excerpt }}">
<meta name="twitter:image" content="{{ $berita->image ? asset('storage/' . $berita->image) : '' }}">
@endpush
@endsection