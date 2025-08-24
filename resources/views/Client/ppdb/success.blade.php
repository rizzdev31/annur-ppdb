@extends('layouts.client')

@section('content')
<!-- Success Page dengan Modern Design -->
<section class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 relative overflow-hidden flex items-center justify-center py-12 px-4">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 -left-40 w-80 h-80 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-40 w-80 h-80 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-20 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Confetti Animation -->
    <div class="confetti-container absolute inset-0 pointer-events-none overflow-hidden">
        @for($i = 0; $i < 50; $i++)
        <div class="confetti" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 3000) / 1000 }}s;"></div>
        @endfor
    </div>
    
    <div class="max-w-4xl w-full relative z-10">
        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fade-in-up">
            <!-- Header Success -->
            <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-green-600 p-8 sm:p-12 text-center relative overflow-hidden">
                <!-- Pattern Background -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23FFFFFF" fill-opacity="1"%3E%3Cpath d="M0 40L40 0H20L0 20M40 40V20L20 40"/%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                
                <!-- Success Icon -->
                <div class="relative">
                    <div class="mx-auto w-32 h-32 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-6 animate-bounce-slow">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3">
                        Pendaftaran Berhasil! 🎉
                    </h1>
                    <p class="text-lg sm:text-xl text-green-100">
                        Selamat! Anda telah berhasil terdaftar dalam sistem PPDB kami
                    </p>
                </div>
            </div>

            @if(session('registration_success'))
                @php
                    $data = session('registration_success');
                @endphp
                
                <div class="p-6 sm:p-8 lg:p-12">
                    <!-- Important Alert -->
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-2xl p-6 mb-8 animate-pulse-slow">
                        <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
                                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-red-800 mb-2">
                                    ⚠️ PENTING! Simpan Informasi Ini
                                </h3>
                                <p class="text-red-700 leading-relaxed">
                                    Informasi login di bawah ini <strong>HANYA DITAMPILKAN SEKALI</strong>. 
                                    Silakan simpan atau screenshot halaman ini. Password juga akan dikirim ke WhatsApp Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Login Credentials Card -->
                    <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-2xl p-6 sm:p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-600 rounded-xl flex items-center justify-center text-white mr-3">
                                <i class="fas fa-key"></i>
                            </div>
                            Informasi Login Anda
                        </h2>
                        
                        <div class="bg-white rounded-xl p-6 space-y-6 shadow-inner">
                            <!-- Nama -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="text-sm text-gray-500 font-medium">Nama Lengkap</label>
                                <p class="text-xl font-bold text-gray-800 mt-1">{{ $data['nama'] }}</p>
                            </div>

                            <!-- NISN -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="text-sm text-gray-500 font-medium">Username (NISN)</label>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0 mt-1">
                                    <p class="font-mono text-2xl sm:text-3xl font-bold text-sky-600">
                                        {{ $data['nisn'] }}
                                    </p>
                                    <button onclick="copyToClipboard('{{ $data['nisn'] }}', 'NISN')" 
                                            class="px-4 py-2 bg-sky-100 hover:bg-sky-200 text-sky-700 rounded-lg font-medium transition-colors duration-300 flex items-center justify-center">
                                        <i class="fas fa-copy mr-2"></i>Salin
                                    </button>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="text-sm text-gray-500 font-medium">Password Sementara</label>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0 mt-1">
                                    <p class="font-mono text-2xl sm:text-3xl font-bold text-red-600" id="password-text">
                                        {{ $data['password'] }}
                                    </p>
                                    <div class="flex space-x-2">
                                        <button onclick="togglePassword()" 
                                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors duration-300">
                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                        </button>
                                        <button onclick="copyToClipboard('{{ $data['password'] }}', 'Password')" 
                                                class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-colors duration-300 flex items-center">
                                            <i class="fas fa-copy mr-2"></i>Salin
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label class="text-sm text-gray-500 font-medium">WhatsApp Terdaftar</label>
                                <p class="text-xl font-semibold text-gray-800 mt-1">
                                    <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                                    {{ $data['whatsapp'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <p class="text-sm text-yellow-800 flex items-start">
                                <i class="fas fa-info-circle mt-0.5 mr-2 flex-shrink-0"></i>
                                <span><strong>Catatan:</strong> Password ini bersifat sementara. Anda wajib mengubahnya saat login pertama kali demi keamanan akun.</span>
                            </p>
                        </div>
                    </div>

                    <!-- WhatsApp Group CTA -->
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl p-6 mb-8 text-white">
                        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-bounce">
                                    <i class="fab fa-whatsapp text-4xl text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-xl font-bold mb-1">Wajib Bergabung Grup WhatsApp!</h3>
                                <p class="text-green-100">Dapatkan informasi terbaru dan pengumuman penting</p>
                            </div>
                            <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                               target="_blank"
                               class="px-6 py-3 bg-white text-green-600 rounded-xl font-bold hover:bg-green-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fab fa-whatsapp mr-2"></i>Gabung Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="bg-gray-50 rounded-2xl p-6 sm:p-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center text-white mr-3">
                                <i class="fas fa-list-ol text-sm"></i>
                            </div>
                            Langkah Selanjutnya
                        </h3>
                        
                        <div class="space-y-4">
                            @php
                                $steps = [
                                    ['icon' => 'fa-save', 'color' => 'blue', 'text' => 'Simpan atau screenshot informasi login di atas'],
                                    ['icon' => 'fa-mobile-alt', 'color' => 'green', 'text' => 'Cek WhatsApp untuk informasi login yang dikirimkan'],
                                    ['icon' => 'fa-users', 'color' => 'purple', 'text' => 'Bergabung ke grup WhatsApp resmi PPDB'],
                                    ['icon' => 'fa-sign-in-alt', 'color' => 'indigo', 'text' => 'Login dengan NISN dan password yang diberikan'],
                                    ['icon' => 'fa-bell', 'color' => 'yellow', 'text' => 'Pantau pengumuman melalui dashboard'],
                                ];
                            @endphp
                            
                            @foreach($steps as $index => $step)
                            <div class="flex items-start space-x-4 animate-fade-in-up" style="animation-delay: {{ ($index + 1) * 100 }}ms">
                                <div class="flex-shrink-0 w-10 h-10 bg-{{ $step['color'] }}-500 text-white rounded-full flex items-center justify-center font-bold shadow-lg">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-700 leading-relaxed">{{ $step['text'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('santri.login') }}" 
                           class="px-6 py-4 bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center rounded-xl font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login Sekarang
                        </a>
                        <a href="{{ route('home') }}" 
                           class="px-6 py-4 bg-white border-2 border-gray-300 text-gray-700 text-center rounded-xl font-bold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Ke Beranda
                        </a>
                    </div>
                </div>
            @else
                <!-- Fallback Content -->
                <div class="p-8 text-center">
                    <p class="text-gray-600 mb-6">Pendaftaran Anda telah berhasil disimpan dalam sistem.</p>
                    <a href="{{ route('santri.login') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl font-bold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Ke Halaman Login
                    </a>
                </div>
            @endif
        </div>

        <!-- Help Footer -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Butuh bantuan? Hubungi kami di 
                <a href="https://wa.me/6281234567890" target="_blank" class="text-green-600 hover:text-green-700 font-semibold">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </p>
        </div>
    </div>
</section>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl transform translate-y-full transition-transform duration-300 z-50 flex items-center">
    <i class="fas fa-check-circle mr-3 text-xl"></i>
    <span id="toast-message">Berhasil disalin!</span>
</div>

@push('styles')
<style>
    /* Animations */
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, -50px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(1); }
        75% { transform: translate(50px, -20px) scale(0.9); }
    }
    
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    @keyframes confetti-fall {
        0% {
            transform: translateY(-100vh) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out both;
    }
    
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Confetti */
    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24, #f0932b, #eb4d4b, #6ab04c);
        animation: confetti-fall 3s linear infinite;
    }
    
    /* Toast Animation */
    .toast-show {
        transform: translateY(0) !important;
    }
    
    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }
        
        .bg-gradient-to-br {
            background: white !important;
        }
        
        button {
            display: none !important;
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 640px) {
        .confetti {
            width: 6px;
            height: 6px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
let passwordVisible = true;

function togglePassword() {
    const passwordText = document.getElementById('password-text');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (passwordVisible) {
        passwordText.textContent = '••••••••••';
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
        showToast(`${type} berhasil disalin!`);
    }, function(err) {
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast(`${type} berhasil disalin!`);
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    toastMessage.textContent = message;
    toast.classList.add('toast-show');
    
    setTimeout(() => {
        toast.classList.remove('toast-show');
    }, 3000);
}

// Auto-hide confetti after animation
setTimeout(() => {
    const confettiContainer = document.querySelector('.confetti-container');
    if (confettiContainer) {
        confettiContainer.style.display = 'none';
    }
}, 5000);
</script>
@endpush
@endsection