<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PPDB Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts dengan Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold text-blue-600">
                        PPDB Online
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">Beranda</a>
                    <a href="{{ route('home') }}#fasilitas" class="text-gray-700 hover:text-blue-600 transition">Fasilitas</a>
                    <a href="{{ route('home') }}#program" class="text-gray-700 hover:text-blue-600 transition">Program</a>
                    <a href="{{ route('home') }}#informasi" class="text-gray-700 hover:text-blue-600 transition">Informasi</a>
                    <a href="{{ route('ppdb.token') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Daftar</a>
                    <a href="{{ route('santri.login') }}" class="text-gray-700 hover:text-blue-600 transition">Login</a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-open">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-close">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t">
                <div class="pt-4 space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Beranda</a>
                    <a href="{{ route('home') }}#fasilitas" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Fasilitas</a>
                    <a href="{{ route('home') }}#program" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Program</a>
                    <a href="{{ route('home') }}#informasi" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Informasi</a>
                    <a href="{{ route('ppdb.token') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2">Daftar Sekarang</a>
                    <a href="{{ route('santri.login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-20">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} PPDB Online. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
    
    <script>
        // Mobile menu toggle with animation
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuOpen = document.getElementById('menu-open');
        const menuClose = document.getElementById('menu-close');
        
        mobileMenuButton?.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuOpen.classList.toggle('hidden');
            menuClose.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking on links
        const mobileMenuLinks = mobileMenu?.querySelectorAll('a');
        mobileMenuLinks?.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuOpen.classList.remove('hidden');
                menuClose.classList.add('hidden');
            });
        });
    </script>
</body>
</html>