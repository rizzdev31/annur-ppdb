@extends('layouts.client')

@section('content')
<!-- Hero Section dengan Gradient Modern -->
<section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-sky-50 via-white to-sky-100">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 -left-40 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-40 w-80 h-80 bg-sky-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-20 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        
        <!-- Pattern Background -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%230EA5E9" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4 py-16 text-center">
        <div class="animate-fade-in-up">
            <span class="inline-block px-4 py-2 bg-yellow-400/20 backdrop-blur-sm text-yellow-700 rounded-full text-sm font-semibold mb-4">
                <i class="fas fa-newspaper mr-2"></i>PORTAL BERITA
            </span>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-sky-600 to-blue-600">
                Berita & Informasi
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Dapatkan informasi terbaru seputar PPDB, kegiatan sekolah, dan prestasi siswa
            </p>
        </div>
    </div>
    
    <!-- Animated Scroll Indicator -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-gray-400 rounded-full flex justify-center">
            <div class="w-1 h-2 bg-gray-400 rounded-full mt-1 animate-scroll"></div>
        </div>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-8 bg-white sticky top-0 z-40 shadow-lg">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('berita.index') }}" class="max-w-5xl mx-auto">
            <div class="flex flex-wrap gap-3 items-center justify-center">
                <!-- Search Input dengan Icon -->
                <div class="relative flex-1 min-w-[300px] group">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berita yang Anda inginkan..." 
                           class="w-full px-12 py-3 border-2 border-gray-200 rounded-full focus:border-sky-500 focus:outline-none transition-all duration-300 group-hover:border-sky-300">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-hover:text-sky-500 transition-colors"></i>
                </div>
                
                <!-- Category Filter -->
                <select name="kategori" class="px-6 py-3 border-2 border-gray-200 rounded-full focus:border-sky-500 focus:outline-none transition-all duration-300 hover:border-sky-300 cursor-pointer">
                    <option value="">🗂️ Semua Kategori</option>
                    <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                    <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>🎉 Kegiatan</option>
                    <option value="prestasi" {{ request('kategori') == 'prestasi' ? 'selected' : '' }}>🏆 Prestasi</option>
                    <option value="artikel" {{ request('kategori') == 'artikel' ? 'selected' : '' }}>📝 Artikel</option>
                </select>
                
                <!-- Action Buttons -->
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-semibold hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                
                @if(request('search') || request('kategori'))
                <a href="{{ route('berita.index') }}" 
                   class="px-8 py-3 bg-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-300 transform hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
                @endif
            </div>
        </form>
        
        <!-- Quick Filter Tags -->
        <div class="flex flex-wrap gap-2 justify-center mt-4">
            <span class="text-sm text-gray-500">Filter Cepat:</span>
            <a href="{{ route('berita.index', ['kategori' => 'pengumuman']) }}" 
               class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm hover:bg-red-200 transition-colors">
                #pengumuman
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'kegiatan']) }}" 
               class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition-colors">
                #kegiatan
            </a>
            <a href="{{ route('berita.index', ['kategori' => 'prestasi']) }}" 
               class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm hover:bg-yellow-200 transition-colors">
                #prestasi
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gradient-to-br from-gray-50 to-white min-h-screen">
    <div class="container mx-auto px-4">
        
        <!-- Featured News (Hero Card) -->
        @php
            $featuredBerita = $beritas->where('is_featured', true)->first();
        @endphp
        
        @if($featuredBerita && !request('search') && !request('kategori'))
        <div class="mb-12 animate-fade-in">
            <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden group hover:shadow-3xl transition-all duration-500">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Image Section -->
                    <div class="relative h-[400px] md:h-full overflow-hidden">
                        @if($featuredBerita->image)
                            <img src="{{ Storage::url($featuredBerita->image) }}" 
                                 alt="{{ $featuredBerita->image_alt ?? $featuredBerita->judul }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        @else
                            <div class="h-full bg-gradient-to-br from-sky-400 via-blue-500 to-indigo-600 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-8xl animate-float"></i>
                            </div>
                        @endif
                        
                        <!-- Featured Badge -->
                        <div class="absolute top-6 left-6 flex items-center gap-2">
                            <span class="px-4 py-2 bg-yellow-400 text-black rounded-full text-sm font-bold shadow-lg animate-pulse">
                                <i class="fas fa-fire mr-2"></i>BERITA UTAMA
                            </span>
                            @if($featuredBerita->kategori)
                            <span class="px-3 py-2 bg-white/90 backdrop-blur-sm text-gray-800 rounded-full text-sm font-semibold">
                                {{ ucfirst($featuredBerita->kategori) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="space-y-4">
                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="far fa-calendar-alt mr-2 text-sky-500"></i>
                                    {{ $featuredBerita->published_at->format('d F Y') }}
                                </span>
                                <span class="flex items-center">
                                    <i class="far fa-user mr-2 text-sky-500"></i>
                                    {{ $featuredBerita->author }}
                                </span>
                                @if($featuredBerita->views > 0)
                                <span class="flex items-center">
                                    <i class="far fa-eye mr-2 text-sky-500"></i>
                                    {{ number_format($featuredBerita->views) }} views
                                </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight group-hover:text-sky-600 transition-colors">
                                {{ $featuredBerita->judul }}
                            </h2>
                            
                            <!-- Excerpt -->
                            <p class="text-gray-600 text-lg leading-relaxed">
                                {{ $featuredBerita->excerpt }}
                            </p>
                            
                            <!-- Action Button -->
                            <div class="pt-4">
                                <a href="{{ route('berita.show', $featuredBerita->slug) }}" 
                                   class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-full font-semibold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                                    <span>Baca Selengkapnya</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @forelse($beritas as $index => $berita)
                @if(!$berita->is_featured || request('search') || request('kategori'))
                <article class="animate-fade-in-up" style="animation-delay: {{ $index * 100 }}ms">
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                        <!-- Image Container -->
                        <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                            @if($berita->image)
                                <img src="{{ Storage::url($berita->image) }}" 
                                     alt="{{ $berita->image_alt ?? $berita->judul }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                
                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-5xl group-hover:scale-110 transition-transform"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($berita->kategori)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 rounded-full text-xs font-semibold shadow-lg">
                                    {{ ucfirst($berita->kategori) }}
                                </span>
                            </div>
                            @endif
                            
                            <!-- Featured Star -->
                            @if($berita->is_featured)
                            <div class="absolute top-4 right-4">
                                <span class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <i class="fas fa-star text-white text-sm"></i>
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <!-- Date & Views -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span class="flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $berita->published_at->diffForHumans() }}
                                </span>
                                @if($berita->views > 0)
                                <span class="flex items-center">
                                    <i class="far fa-eye mr-1"></i>
                                    {{ number_format($berita->views) }}
                                </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-sky-600 transition-colors">
                                {{ $berita->judul }}
                            </h3>
                            
                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($berita->excerpt, 120) }}
                            </p>
                            
                            <!-- Author & Read More -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    <i class="far fa-user mr-1"></i>
                                    {{ Str::limit($berita->author, 15) }}
                                </span>
                                <a href="{{ route('berita.show', $berita->slug) }}" 
                                   class="inline-flex items-center text-sky-600 hover:text-sky-800 font-semibold text-sm group">
                                    <span>Baca</span>
                                    <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endif
            @empty
            <!-- Empty State -->
            <div class="col-span-full flex flex-col items-center justify-center py-20 animate-fade-in">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-newspaper text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">
                    @if(request('search'))
                        Tidak Ada Hasil
                    @else
                        Belum Ada Berita
                    @endif
                </h3>
                <p class="text-gray-500 text-center max-w-md">
                    @if(request('search'))
                        Tidak ada berita yang ditemukan untuk pencarian "<span class="font-semibold">{{ request('search') }}</span>". 
                        Coba gunakan kata kunci lain atau reset filter.
                    @else
                        Belum ada berita yang dipublikasikan. Silakan cek kembali nanti.
                    @endif
                </p>
                @if(request('search') || request('kategori'))
                <a href="{{ route('berita.index') }}" 
                   class="mt-6 inline-flex items-center px-6 py-3 bg-sky-500 text-white rounded-full font-semibold hover:bg-sky-600 transition-colors">
                    <i class="fas fa-redo mr-2"></i>Reset Filter
                </a>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($beritas->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="bg-white rounded-full shadow-lg px-4 py-2">
                {{ $beritas->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter CTA -->
<section class="py-16 bg-gradient-to-r from-sky-600 to-blue-700 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center text-white animate-fade-in-up">
            <i class="fas fa-bell text-5xl mb-4 animate-bounce"></i>
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Jangan Lewatkan Update Terbaru!</h2>
            <p class="text-xl mb-8 text-white/90">Dapatkan informasi seputar PPDB dan kegiatan sekolah langsung di email Anda</p>
            <a href="{{ route('ppdb.token') }}" 
               class="inline-flex items-center px-10 py-4 bg-white text-sky-600 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-user-plus mr-2"></i>Daftar PPDB Sekarang
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Animations */
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, -50px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(1); }
        75% { transform: translate(50px, -20px) scale(0.9); }
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
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes scroll {
        0% { transform: translateY(0); }
        100% { transform: translateY(8px); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out both;
    }
    
    .animate-float {
        animation: float 4s ease-in-out infinite;
    }
    
    .animate-scroll {
        animation: scroll 1.5s ease-in-out infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
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
    
    /* Custom shadow */
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
    
    /* Pagination Custom */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination a, .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        transition: all 0.3s;
    }
    
    .pagination .active {
        background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
        color: white;
    }
    
    .pagination a:hover {
        background: #F3F4F6;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endpush
@endsection