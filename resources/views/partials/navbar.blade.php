<!-- resources/views/partials/navbar.blade.php -->
<!-- Navigation Component -->
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
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('home') }}#fasilitas" class="text-gray-700 hover:text-blue-600 transition">
                    Fasilitas
                </a>
                <a href="{{ route('home') }}#program" class="text-gray-700 hover:text-blue-600 transition">
                    Program
                </a>
                <a href="{{ route('home') }}#informasi" class="text-gray-700 hover:text-blue-600 transition">
                    Informasi
                </a>
                
                @if(Auth::guard('pendaftaran')->check())
                    @php
                        $user = Auth::guard('pendaftaran')->user();
                    @endphp
                    <!-- User Menu Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" 
                                class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ Str::limit($user->nama_lengkap, 15) }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1"
                             @click.away="open = false">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm text-gray-500">Logged in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">NISN: {{ $user->nisn }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <a href="{{ route('santri.dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <i class="fas fa-tachometer-alt mr-2 w-4"></i>Dashboard
                            </a>
                            <a href="{{ route('santri.profile') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <i class="fas fa-user mr-2 w-4"></i>Profil Saya
                            </a>
                            
                            <!-- Status Badge -->
                            <div class="px-4 py-2 border-t">
                                <span class="text-xs text-gray-500">Status:</span>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'seleksi' => 'bg-blue-100 text-blue-800',
                                        'diterima' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusText = [
                                        'pending' => 'Menunggu',
                                        'seleksi' => 'Seleksi',
                                        'diterima' => 'Diterima',
                                        'ditolak' => 'Ditolak'
                                    ];
                                    $color = $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $color }}">
                                    {{ $statusText[$user->status] ?? 'Unknown' }}
                                </span>
                            </div>
                            
                            <!-- Logout -->
                            <div class="border-t">
                                <form action="{{ route('santri.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt mr-2 w-4"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('ppdb.token') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition transform hover:scale-105">
                        Daftar
                    </a>
                    <a href="{{ route('santri.login') }}" 
                       class="flex items-center text-gray-700 hover:text-blue-600 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                @endif
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
                <a href="{{ route('home') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('home') ? 'bg-gray-100 font-semibold' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('home') }}#fasilitas" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                    Fasilitas
                </a>
                <a href="{{ route('home') }}#program" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                    Program
                </a>
                <a href="{{ route('home') }}#informasi" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                    Informasi
                </a>
                
                @if(Auth::guard('pendaftaran')->check())
                    @php
                        $user = Auth::guard('pendaftaran')->user();
                    @endphp
                    <!-- Mobile User Info -->
                    <div class="border-t pt-3 mt-3">
                        <div class="px-4 py-2 bg-gray-50 rounded-lg mb-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500">NISN: {{ $user->nisn }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('santri.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('santri.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                            <i class="fas fa-user mr-2"></i>Profil Saya
                        </a>
                        
                        <form action="{{ route('santri.logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t pt-3 mt-3 space-y-2">
                        <a href="{{ route('ppdb.token') }}" 
                           class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('santri.login') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded text-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Script -->
<script>
    // Mobile menu toggle
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

<!-- Alpine.js for dropdown (add to layout) -->
<script src="//unpkg.com/alpinejs" defer></script>