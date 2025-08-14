<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin PPDB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Desktop -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow bg-gray-800 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <h2 class="text-2xl font-bold text-white">PPDB Admin</h2>
                    </div>
                    
                    <nav class="mt-8 flex-1 px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase">PPDB</p>
                        </div>
                        
                        <a href="{{ route('admin.ppdb.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.ppdb.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Data Pendaftar
                        </a>
                        
                        <a href="{{ route('admin.tahun-ajaran.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.tahun-ajaran.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tahun Ajaran
                        </a>
                        
                        <a href="{{ route('admin.gelombang.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.gelombang.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Gelombang
                        </a>
                        
                        <a href="{{ route('admin.token.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.tokens.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Token
                        </a>
                        
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase">CMS</p>
                        </div>
                        
                        <a href="{{ route('admin.fasilitas.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.fasilitas.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Fasilitas
                        </a>
                        
                        <a href="{{ route('admin.program.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.program.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Program
                        </a>
                        
                        <a href="{{ route('admin.berita.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.berita.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            Berita
                        </a>
                        <!-- Tambahkan menu Manajemen User di bawah ini -->
                        <a href="{{ route('admin.users.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-900' : '' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 3.87v-2a4 4 0 00-3-3.87m6 3.87a4 4 0 00-3-3.87m0 0a4 4 0 00-3 3.87"></path>
                            </svg>
                            Manajemen User
                        </a>
                        <!-- Menu Kelola Akun -->
                        <a href="{{ route('admin.accounts.dashboard') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-white hover:bg-gray-700 {{ request()->routeIs('admin.accounts.*') ? 'bg-gray-900' : '' }}">
                            <i class="fas fa-user-cog mr-3 h-6 w-6"></i>
                            Kelola Akun
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="md:hidden">
            <div class="fixed inset-0 z-40 flex" id="mobile-sidebar" style="display: none;">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="toggleMobileSidebar()"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button onclick="toggleMobileSidebar()" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <h2 class="text-2xl font-bold text-white">PPDB Admin</h2>
                        </div>
                        <!-- Same navigation as desktop -->
                        <nav class="mt-5 px-2 space-y-1">
                            <!-- Copy same nav items from desktop -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto focus:outline-none">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <!-- Mobile menu button -->
                        <button onclick="toggleMobileSidebar()" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <h3 class="text-xl font-semibold text-gray-800">
                            @yield('title', 'Dashboard')
                        </h3>
                        
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600 hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <span class="hidden sm:inline">Logout</span>
                                    <svg class="h-5 w-5 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar.style.display === 'none' || sidebar.style.display === '') {
                sidebar.style.display = 'flex';
            } else {
                sidebar.style.display = 'none';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>