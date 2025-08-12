@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-800 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Logo/Title -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Portal Santri</h1>
            <p class="text-blue-200">Login untuk melihat status pendaftaran</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Login Santri</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('santri.login') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">NISN</label>
                    <input type="text" 
                           name="nisn" 
                           value="{{ old('nisn') }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nisn') border-red-500 @enderror"
                           placeholder="Masukkan NISN"
                           required
                           autofocus>
                    @error('nisn')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" 
                           name="password"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           placeholder="••••••••"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('ppdb.token') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Daftar PPDB
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Help -->
        <div class="mt-8 text-center text-white">
            <p class="text-sm">Lupa password? Hubungi panitia PPDB</p>
        </div>
    </div>
</div>
@endsection