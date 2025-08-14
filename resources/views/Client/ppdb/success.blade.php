@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-600 to-teal-700 flex items-center justify-center py-12 px-4">
    <div class="max-w-3xl w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header Success -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
                <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center mb-4">
                    <svg class="h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Pendaftaran Berhasil!</h2>
                <p class="text-green-100">Selamat! Pendaftaran Anda telah berhasil disimpan dalam sistem kami</p>
            </div>

            @if(session('registration_success'))
                @php
                    $data = session('registration_success');
                @endphp
                
                <!-- Info Login Section -->
                <div class="p-8">
                    <!-- Alert Penting -->
                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-red-800">PENTING! Simpan Informasi Login Ini</h3>
                                <p class="mt-2 text-sm text-red-700">
                                    Informasi login di bawah ini hanya ditampilkan SEKALI. 
                                    Silakan simpan atau screenshot halaman ini untuk referensi Anda.
                                    Password ini akan dikirimkan juga ke WhatsApp yang terdaftar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Info Login -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-key text-blue-600 mr-2"></i> Informasi Login Anda
                        </h3>
                        
                        <div class="bg-white rounded-lg p-6 space-y-4">
                            <!-- Nama -->
                            <div class="pb-3 border-b border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $data['nama'] }}</p>
                            </div>

                            <!-- Username/NISN -->
                            <div class="pb-3 border-b border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Username (NISN)</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-mono text-2xl font-bold text-blue-600">{{ $data['nisn'] }}</p>
                                    <button onclick="copyToClipboard('{{ $data['nisn'] }}', 'username')" 
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg text-sm transition duration-300">
                                        <i class="fas fa-copy"></i> Salin
                                    </button>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="pb-3 border-b border-gray-200">
                                <p class="text-sm text-gray-500 mb-1">Password Sementara</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-mono text-2xl font-bold text-red-600" id="password-text">{{ $data['password'] }}</p>
                                    <div class="flex space-x-2">
                                        <button onclick="togglePassword()" 
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-sm transition duration-300">
                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                        </button>
                                        <button onclick="copyToClipboard('{{ $data['password'] }}', 'password')" 
                                                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-lg text-sm transition duration-300">
                                            <i class="fas fa-copy"></i> Salin
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <p class="text-sm text-gray-500 mb-1">WhatsApp Terdaftar</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    <i class="fab fa-whatsapp text-green-500"></i> {{ $data['whatsapp'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Catatan:</strong> Password ini bersifat sementara. 
                                Anda dapat mengubahnya setelah login pertama kali untuk keamanan akun Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Langkah Selanjutnya -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            <i class="fas fa-list-ol text-gray-600 mr-2"></i> Langkah Selanjutnya
                        </h3>
                        <ol class="space-y-3">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                                <div class="ml-3">
                                    <p class="text-gray-700">Simpan atau screenshot informasi login di atas</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                                <div class="ml-3">
                                    <p class="text-gray-700">Cek WhatsApp Anda untuk informasi login yang dikirimkan</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                <div class="ml-3">
                                    <p class="text-gray-700">Login menggunakan NISN dan password yang diberikan</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                                <div class="ml-3">
                                    <p class="text-gray-700">Tunggu pengumuman hasil seleksi melalui dashboard</p>
                                </div>
                            </li>
                        </ol>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('santri.login') }}" 
                           class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login Sekarang
                        </a>
                        <button onclick="window.print()" 
                                class="flex-1 bg-gray-600 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-lg">
                            <i class="fas fa-print mr-2"></i> Cetak Halaman
                        </button>
                    </div>
                </div>
            @else
                <!-- Jika tidak ada data session -->
                <div class="p-8 text-center">
                    <p class="text-gray-600 mb-4">Pendaftaran Anda telah berhasil disimpan.</p>
                    <a href="{{ route('santri.login') }}" 
                       class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Ke Halaman Login
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer Info -->
        <div class="mt-6 text-center text-white">
            <p class="text-sm">
                Butuh bantuan? Hubungi kami di 
                <a href="https://wa.me/628123456789" class="underline">WhatsApp</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
let passwordVisible = true;

function togglePassword() {
    const passwordText = document.getElementById('password-text');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (passwordVisible) {
        passwordText.textContent = '••••••••';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordText.textContent = '{{ session("registration_success")["password"] ?? "" }}';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
    passwordVisible = !passwordVisible;
}

function copyToClipboard(text, type) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast notification
        showToast(`${type === 'username' ? 'Username' : 'Password'} berhasil disalin!`);
    }, function(err) {
        console.error('Error copying text: ', err);
    });
}

function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
    toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;
    
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

@media print {
    .bg-gradient-to-br {
        background: white !important;
    }
    button {
        display: none !important;
    }
}
</style>
@endpush
@endsection