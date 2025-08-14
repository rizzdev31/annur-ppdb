@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h2 class="text-3xl font-bold text-white text-center">
                    Login Santri
                </h2>
                <p class="mt-2 text-center text-blue-100">
                    Masuk ke dashboard PPDB
                </p>
            </div>

            <!-- Form -->
            <div class="px-8 py-6">
                @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('santri.login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- NISN -->
                    <div>
                        <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-id-card mr-1 text-blue-500"></i> NISN
                        </label>
                        <input type="text" 
                               name="nisn" 
                               id="nisn"
                               value="{{ old('nisn') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nisn') border-red-500 @enderror"
                               placeholder="Masukkan NISN Anda"
                               required
                               autofocus>
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1 text-blue-500"></i> Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Masukkan Password"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </button>
                    </div>
                </form>

                <!-- Info -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Gunakan NISN dan password yang diberikan saat pendaftaran.
                    </p>
                </div>

                <!-- Back Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection