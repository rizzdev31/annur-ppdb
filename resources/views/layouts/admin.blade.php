<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - PPDB MUBOSTA</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Active sidebar link */
        .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border-left: 3px solid #3b82f6;
        }
        
        /* Error input styling */
        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }
        
        .input-error:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 left-0 z-50 w-64 h-full bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="flex items-center">
                <i class="fas fa-graduation-cap text-white text-2xl mr-3"></i>
                <span class="text-white text-xl font-bold">PPDB Admin</span>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- User Info -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                         alt="Avatar" 
                         class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                @endif
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@ppdb.com' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-6 px-3 pb-6 overflow-y-auto" style="max-height: calc(100vh - 200px);">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- PPDB Management -->
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase">PPDB Management</p>
                
                <a href="{{ route('admin.ppdb.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate w-5 mr-3"></i>
                    <span>Data Pendaftar</span>
                </a>
                
                <a href="{{ route('admin.token.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.token.*') ? 'active' : '' }}">
                    <i class="fas fa-key w-5 mr-3"></i>
                    <span>Token Pendaftaran</span>
                </a>
                
                <a href="{{ route('admin.tahun-ajaran.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i>
                    <span>Tahun Ajaran</span>
                </a>
                
                <a href="{{ route('admin.gelombang.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.gelombang.*') ? 'active' : '' }}">
                    <i class="fas fa-wave-square w-5 mr-3"></i>
                    <span>Gelombang</span>
                </a>
            </div>
            
            <!-- CMS -->
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase">Content Management</p>
                
                <a href="{{ route('admin.fasilitas.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
                    <i class="fas fa-building w-5 mr-3"></i>
                    <span>Fasilitas</span>
                </a>
                
                <a href="{{ route('admin.program.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.program.*') ? 'active' : '' }}">
                    <i class="fas fa-star w-5 mr-3"></i>
                    <span>Program Unggulan</span>
                </a>
                
                <a href="{{ route('admin.ekstrakurikuler.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>Ekstrakurikuler</span>
                </a>
                
                <a href="{{ route('admin.tahapan.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.tahapan.*') ? 'active' : '' }}">
                    <i class="fas fa-list-ol w-5 mr-3"></i>
                    <span>Tahapan Pendaftaran</span>
                </a>
                
                <a href="{{ route('admin.jenjang.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.jenjang.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-5 mr-3"></i>
                    <span>Jenjang Pendidikan</span>
                </a>
                
                <a href="{{ route('admin.berita.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper w-5 mr-3"></i>
                    <span>Berita & Informasi</span>
                </a>
            </div>
            
            <!-- User Management -->
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase">User Management</p>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog w-5 mr-3"></i>
                    <span>Kelola Santri</span>
                </a>
                
                <a href="{{ route('admin.accounts.dashboard') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield w-5 mr-3"></i>
                    <span>Kelola Admin</span>
                </a>
            </div>
            
            <!-- Settings & Profile -->
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase">Pengaturan</p>
                
                <a href="{{ route('admin.profile.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle w-5 mr-3"></i>
                    <span>Profile Saya</span>
                </a>
                
                <a href="{{ route('admin.settings.index') }}" 
                   class="sidebar-link flex items-center px-3 py-2 mb-1 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span>Pengaturan Sistem</span>
                </a>
            </div>
            
        </nav>
        
        <!-- Logout Button -->
        <div class="absolute bottom-0 w-full p-4 border-t border-gray-200 bg-white">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="flex items-center justify-center w-full px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-600">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Page Title -->
                <h1 class="text-xl font-semibold text-gray-800">
                    @yield('title', 'Dashboard')
                </h1>
                
                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- Visit Site -->
                    <a href="{{ route('home') }}" target="_blank" 
                       class="text-gray-600 hover:text-gray-900" title="Lihat Website">
                        <i class="fas fa-external-link-alt text-xl"></i>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                class="flex items-center text-gray-600 hover:text-gray-900">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                     alt="Avatar" 
                                     class="w-8 h-8 rounded-full object-cover mr-2">
                            @else
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-2">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="{{ route('admin.profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content Area -->
        <main class="min-h-screen">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4 px-6 mt-auto">
            <div class="text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} PPDB MUBOSTA. All rights reserved.
            </div>
        </footer>
    </div>
    
    <!-- Toast Notification (Optional) -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>