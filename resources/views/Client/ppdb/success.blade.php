@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-600 to-teal-700 flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-6">
                <div class="mx-auto h-24 w-24 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h2>
                <p class="text-gray-600">Selamat, pendaftaran Anda telah berhasil disimpan</p>
            </div>

            @if(session('registration_success'))
                @php
                    $data = session('registration_success');
                @endphp
                
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Login Anda</h3>
                    
                    <div class="bg-white rounded p-4 space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold text-gray-800">{{ $data['nama'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Username (NISN)</p>
                            <p class="font-mono text-lg font-bold text-blue-600">{{ $data['nisn'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Password Sementara</p>
                            <p class="font-mono text-lg font-bold text-red-600">{{ $data['password'] }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                        <p class="text-sm text-yellow-800">
                            <strong>PENTING:</strong> Simpan informasi login ini dengan baik. Password akan dikirimkan juga melalui WhatsApp yang Anda daftarkan.
                        </p>
                    </div>
                </div>
            @endif

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Langkah Selanjutnya:</h3>
                <ol class="space-y-2 text-gray-600">
                    <li class="flex">
                        <span class="font-bold mr-2">1.</span>
                        <span>Tunggu konfirmasi dari panitia melalui WhatsApp</span>
                    </li>
                    <li class="flex">
                        <span class="font-bold mr-2">2.</span>
                        <span>Login menggunakan NISN dan password yang telah diberikan</span>
                    </li>
                    <li class="flex">
                        <span class="font-bold mr-2">3.</span>
                        <span>Pantau status pendaftaran Anda secara berkala</span>
                    </li>
                    <li class="flex">
                        <span class="font-bold mr-2">4.</span>
                        <span>Ikuti pengumuman selanjutnya dari panitia</span>
                    </li>
                </ol>
            </div>

            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('santri.login') }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Login Sekarang
                </a>
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection