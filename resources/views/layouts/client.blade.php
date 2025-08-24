<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB Online') - MUBOSTA MA eMAS</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        /* Loading animation */
        .loader {
            border-top-color: #3b82f6;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }
        
        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Button hover effect */
        .btn-hover {
            position: relative;
            overflow: hidden;
        }
        
        .btn-hover::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-hover:hover::before {
            width: 300px;
            height: 300px;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center">
        <div class="text-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4 mx-auto"></div>
            <p class="text-gray-600">Loading...</p>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50" x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="font-bold text-lg text-gray-900">PPDB MUBOSTA</h1>
                            <p class="text-xs text-gray-600">MA eMAS {{ date('Y') }}</p>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Beranda
                    </a>
                    <a href="{{ url('/#tahapan') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Tahapan
                    </a>
                    <a href="{{ url('/#jenjang') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Jenjang
                    </a>
                    <a href="{{ url('/#fasilitas') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Fasilitas
                    </a>
                    <a href="{{ url('/#program') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Program
                    </a>
                    <a href="{{ url('/#ekstrakurikuler') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Ekstrakurikuler
                    </a>
                    <a href="{{ route('berita.index') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition">
                        Berita
                    </a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    @if(Auth::guard('pendaftaran')->check())
                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen" 
                                    @click.away="profileOpen = false"
                                    class="flex items-center space-x-3 px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-300 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-sky-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(Auth::guard('pendaftaran')->user()->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-semibold text-gray-900">{{ Str::limit(Auth::guard('pendaftaran')->user()->nama_lengkap, 20) }}</p>
                                    <p class="text-xs text-gray-500">NISN: {{ Auth::guard('pendaftaran')->user()->nisn }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                                     :class="profileOpen ? 'rotate-180' : ''" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="profileOpen" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::guard('pendaftaran')->user()->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::guard('pendaftaran')->user()->nisn }}</p>
                                </div>
                                
                                <!-- Menu Items -->
                                <a href="{{ route('santri.dashboard') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 transition-colors">
                                    <i class="fas fa-tachometer-alt w-4 mr-3 text-center"></i>
                                    Dashboard
                                </a>
                                <a href="{{ route('santri.profile') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 transition-colors">
                                    <i class="fas fa-user w-4 mr-3 text-center"></i>
                                    Profil Saya
                                </a>
                                <a href="#" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 transition-colors">
                                    <i class="fas fa-key w-4 mr-3 text-center"></i>
                                    Ubah Password
                                </a>
                                
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form action="{{ route('santri.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <i class="fas fa-sign-out-alt w-4 mr-3 text-center"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <a href="{{ route('santri.dashboard') }}" 
                           class="px-4 py-2 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('ppdb.token') }}" 
                           class="px-4 py-2 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 btn-hover">
                            <i class="fas fa-user-plus mr-2"></i>Daftar
                        </a>
                        <a href="{{ route('santri.login') }}" 
                           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endif
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-cloak
                 @click.away="mobileMenuOpen = false"
                 class="md:hidden absolute top-16 left-0 right-0 bg-white shadow-lg">
                <div class="px-4 py-3 space-y-3">
                    <a href="{{ route('home') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
                    <a href="{{ url('/#tahapan') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Tahapan</a>
                    <a href="{{ url('/#jenjang') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Jenjang</a>
                    <a href="{{ url('/#fasilitas') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Fasilitas</a>
                    <a href="{{ url('/#program') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Program</a>
                    <a href="{{ url('/#ekstrakurikuler') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Ekstrakurikuler</a>
                    <a href="{{ route('berita.index') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Berita</a>
                    
                    <div class="pt-3 border-t border-gray-200">
                        @if(Auth::guard('pendaftaran')->check())
                            <!-- User Info Card Mobile -->
                            <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-lg p-3 mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr(Auth::guard('pendaftaran')->user()->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ Auth::guard('pendaftaran')->user()->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500">NISN: {{ Auth::guard('pendaftaran')->user()->nisn }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Mobile Menu Actions -->
                            <a href="{{ route('santri.dashboard') }}" 
                               class="block w-full px-4 py-2 bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center rounded-lg mb-2">
                                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('santri.profile') }}" 
                               class="block w-full px-4 py-2 bg-white border border-gray-300 text-gray-700 text-center rounded-lg mb-2">
                                <i class="fas fa-user mr-2"></i>Profil Saya
                            </a>
                            <form action="{{ route('santri.logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="block w-full px-4 py-2 bg-red-50 border border-red-200 text-red-600 text-center rounded-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('ppdb.token') }}" 
                               class="block w-full px-4 py-2 bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center rounded-lg mb-2">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                            <a href="{{ route('santri.login') }}" 
                               class="block w-full px-4 py-2 border border-gray-300 text-gray-700 text-center rounded-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="mt-16">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in-right">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in-right">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
                <p class="font-bold">Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif
        
        @if(session('warning'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in-right">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-lg">
                <p class="font-bold">Perhatian!</p>
                <p>{{ session('warning') }}</p>
            </div>
        </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4">PPDB MUBOSTA</h3>
                    <p class="text-gray-400 text-sm">
                        Penerimaan Peserta Didik Baru Smp 9 Boarding School Tanggulangin dan Madrasah Aliyah eMAS. 
                        Mencetak generasi yang berakhlak mulia dan berprestasi.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="https://www.facebook.com/profile.php?id=100073844180312&locale=id_ID" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/ppmannursidoarjoofficial/" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://www.youtube.com/@ppm.an-nursidoarjoofficial6323" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="https://wa.me/6282141731633?text=Halo%20Admin,%20saya%20butuh%20bantuan%20PPDB"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        @if(Auth::guard('pendaftaran')->check())
                            <li><a href="{{ route('santri.dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                            <li><a href="{{ route('santri.profile') }}" class="text-gray-400 hover:text-white transition">Profil Saya</a></li>
                        @else
                            <li><a href="{{ route('ppdb.token') }}" class="text-gray-400 hover:text-white transition">Pendaftaran</a></li>
                            <li><a href="{{ route('santri.login') }}" class="text-gray-400 hover:text-white transition">Login Santri</a></li>
                        @endif
                        <li><a href="{{ route('berita.index') }}" class="text-gray-400 hover:text-white transition">Berita</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Panduan PPDB</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                            <span>Jalan KH Ahmad Dahlan, Sangangewu, Penatarsewu, Kec. Tanggulangin, Kabupaten Sidoarjo, Jawa Timur</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+62 821-4173-1633</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>ponpesannursidoarjo@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fab fa-whatsapp mr-2"></i>
                            <span>+62 821-4173-1633</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-4">
                        Dapatkan informasi terbaru seputar PPDB dan kegiatan sekolah.
                    </p>
                    <form class="flex flex-col space-y-2">
                        <input type="email" 
                               placeholder="Email Anda" 
                               class="px-4 py-2 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg hover:shadow-lg transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} PPDB MUBOSTA MA eMAS. All rights reserved.</p>
                <p class="mt-2">
                    Developed by Mubosta Dev
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="backToTop" 
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all hover:shadow-xl transform hover:scale-110 z-40">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script>
        // Loading screen
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading-screen').style.display = 'none';
            }, 500);
        });
        
        // Back to top button
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });
        
        // Auto hide flash messages
        setTimeout(function() {
            const flashMessages = document.querySelectorAll('.animate-fade-in-right');
            flashMessages.forEach(function(msg) {
                msg.style.display = 'none';
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>