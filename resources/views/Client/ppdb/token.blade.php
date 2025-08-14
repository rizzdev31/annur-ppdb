@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-indigo-800 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Logo/Title -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">PPDB Online</h1>
            <p class="text-blue-200">Masukkan token pendaftaran Anda</p>
        </div>

        <!-- Token Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Verifikasi Token</h2>
                <p class="text-gray-600 mt-2">Token dapat diperoleh dari panitia PPDB</p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('ppdb.verify-token') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Token Pendaftaran</label>
                    <input type="text" 
                           name="token" 
                           value="{{ old('token') }}"
                           class="w-full px-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl font-mono uppercase {{ $errors->has('token') ? 'border-red-500' : 'border-gray-300' }}"
                           placeholder="XXXXXXXX"
                           maxlength="8"
                           required
                           autofocus>
                    @error('token')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Verifikasi Token
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('santri.login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        Login di sini
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Help Section with WhatsApp Button -->
        <div class="mt-8 text-center">
            <p class="text-blue-200 mb-4">Belum punya token pendaftaran?</p>
            {{-- Replace the phone number with your admin's WhatsApp number --}}
            {{-- A pre-filled message is added to make it easier for users --}}
            <a href="https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20ingin%20meminta%20token%20pendaftaran%20PPDB." 
               target="_blank" 
               class="inline-flex items-center justify-center bg-green-500 text-white py-2 px-6 rounded-full font-semibold hover:bg-green-600 transition duration-300 shadow-lg">
                <i class="fab fa-whatsapp mr-2"></i> Minta Token via WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
