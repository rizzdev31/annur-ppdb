@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
    <!-- Header Section dengan Gradient -->
    <div class="bg-gradient-to-r from-sky-500 to-blue-600 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23FFFFFF" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 py-8 relative z-10">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="text-white">
                    <h1 class="text-3xl sm:text-4xl font-bold mb-2 animate-fade-in">Dashboard Santri</h1>
                    <p class="text-sky-100 text-lg animate-fade-in-up">
                        Selamat datang kembali, <span class="font-semibold">{{ $pendaftaran->nama_lengkap }}</span>!
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- WhatsApp Group Button -->
                    <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center animate-pulse">
                        <i class="fab fa-whatsapp mr-2 text-xl"></i>
                        <span class="hidden sm:inline">Grup WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 -mt-12 relative z-20">
            <!-- Status Card -->
            @php
                $statusInfo = [
                    'pending' => ['bg' => 'from-yellow-400 to-amber-500', 'icon' => 'fa-clock', 'text' => 'Menunggu'],
                    'seleksi' => ['bg' => 'from-blue-400 to-blue-600', 'icon' => 'fa-clipboard-check', 'text' => 'Seleksi'],
                    'diterima' => ['bg' => 'from-green-400 to-green-600', 'icon' => 'fa-check-circle', 'text' => 'Diterima'],
                    'ditolak' => ['bg' => 'from-red-400 to-red-600', 'icon' => 'fa-times-circle', 'text' => 'Ditolak'],
                ][$pendaftaran->status] ?? ['bg' => 'from-gray-400 to-gray-600', 'icon' => 'fa-question-circle', 'text' => 'Unknown'];
            @endphp
            
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 100ms">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br {{ $statusInfo['bg'] }} rounded-xl flex items-center justify-center text-white">
                        <i class="fas {{ $statusInfo['icon'] }} text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">Status</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $statusInfo['text'] }}</h3>
                <p class="text-sm text-gray-500 mt-1">Status pendaftaran saat ini</p>
            </div>
            
            <!-- NISN Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 200ms">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">NISN</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 font-mono">{{ $pendaftaran->nisn }}</h3>
                <p class="text-sm text-gray-500 mt-1">Nomor induk siswa</p>
            </div>
            
            <!-- Gelombang Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 300ms">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-wave-square text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">Gelombang</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $pendaftaran->gelombang->nama_gelombang ?? 'N/A' }}</h3>
                <p class="text-sm text-gray-500 mt-1">Periode pendaftaran</p>
            </div>
            
            <!-- Tahun Ajaran Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 animate-fade-in-up" style="animation-delay: 400ms">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">Tahun</span>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ $pendaftaran->tahunAjaran->tahun ?? date('Y') }}</h3>
                <p class="text-sm text-gray-500 mt-1">Tahun ajaran</p>
            </div>
        </div>

        <!-- WhatsApp Group CTA Section - Full Width -->
        <div class="mb-8 animate-fade-in">
            <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-green-600 rounded-3xl shadow-2xl overflow-hidden relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23FFFFFF" fill-opacity="1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                
                <div class="relative p-6 sm:p-8 lg:p-10">
                    <div class="flex flex-col lg:flex-row items-center justify-between space-y-6 lg:space-y-0">
                        <!-- Content Section -->
                        <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 flex-1">
                            <!-- Animated Icon -->
                            <div class="relative">
                                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center animate-bounce">
                                    <i class="fab fa-whatsapp text-5xl text-white"></i>
                                </div>
                                <!-- Pulse Ring -->
                                <div class="absolute inset-0 rounded-full bg-white/20 animate-ping"></div>
                            </div>
                            
                            <!-- Text Content -->
                            <div class="text-center sm:text-left text-white">
                                <h2 class="text-2xl sm:text-3xl font-bold mb-2">
                                    🎯 Wajib Gabung Grup WhatsApp!
                                </h2>
                                <p class="text-green-100 text-lg">
                                    Dapatkan informasi terbaru, pengumuman penting, dan jadwal ujian langsung di WhatsApp Anda
                                </p>
                                <div class="mt-3 flex flex-wrap gap-2 text-sm">
                                    <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        <i class="fas fa-users mr-1"></i> 250+ Anggota
                                    </span>
                                    <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        <i class="fas fa-bell mr-1"></i> Update Realtime
                                    </span>
                                    <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                        <i class="fas fa-shield-alt mr-1"></i> Grup Resmi
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA Button -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                               target="_blank"
                               class="group relative inline-flex items-center justify-center px-8 py-4 bg-white text-green-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                                <!-- Button Shimmer Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <i class="fab fa-whatsapp mr-3 text-2xl relative z-10"></i>
                                <span class="relative z-10">Gabung Sekarang</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform relative z-10"></i>
                            </a>
                            
                            <button onclick="shareToWhatsApp()" 
                                    class="inline-flex items-center justify-center px-6 py-4 bg-white/20 backdrop-blur-sm text-white border-2 border-white/30 rounded-2xl font-semibold hover:bg-white/30 transition-all duration-300">
                                <i class="fas fa-share-alt mr-2"></i>
                                <span class="hidden sm:inline">Bagikan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Status Timeline -->
                <div class="bg-white rounded-2xl shadow-xl p-6 animate-fade-in-up">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-600 rounded-xl flex items-center justify-center text-white mr-3">
                            <i class="fas fa-route"></i>
                        </div>
                        Tahapan Pendaftaran
                    </h2>
                    
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute left-6 top-8 bottom-8 w-0.5 bg-gray-200"></div>
                        <div class="absolute left-6 top-8 w-0.5 bg-gradient-to-b from-green-500 to-blue-500 transition-all duration-500" 
                             style="height: {{ $pendaftaran->status == 'diterima' ? '100%' : ($pendaftaran->status == 'seleksi' ? '33%' : '0%') }}"></div>
                        
                        <!-- Steps -->
                        <div class="relative space-y-8">
                            <!-- Step 1: Pendaftaran -->
                            <div class="flex items-start">
                                <div class="relative z-10 flex-shrink-0 w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="ml-6 flex-1">
                                    <h4 class="font-bold text-gray-900">Pendaftaran Selesai</h4>
                                    <p class="text-gray-600 text-sm mt-1">Formulir pendaftaran telah berhasil dikirim</p>
                                    <span class="text-xs text-gray-500">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            
                            <!-- Step 2: Verifikasi -->
                            <div class="flex items-start">
                                <div class="relative z-10 flex-shrink-0 w-12 h-12 {{ in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white shadow-lg transition-all duration-300">
                                    @if(in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']))
                                        <i class="fas fa-check"></i>
                                    @else
                                        <span class="font-bold">2</span>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <h4 class="font-bold {{ in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']) ? 'text-gray-900' : 'text-gray-400' }}">Verifikasi Berkas</h4>
                                    <p class="text-sm mt-1 {{ in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']) ? 'text-gray-600' : 'text-gray-400' }}">Panitia sedang memverifikasi kelengkapan berkas</p>
                                </div>
                            </div>
                            
                            <!-- Step 3: Seleksi -->
                            <div class="flex items-start">
                                <div class="relative z-10 flex-shrink-0 w-12 h-12 {{ $pendaftaran->status == 'seleksi' ? 'bg-blue-500 animate-pulse' : (in_array($pendaftaran->status, ['diterima', 'ditolak']) ? 'bg-blue-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center text-white shadow-lg transition-all duration-300">
                                    @if(in_array($pendaftaran->status, ['diterima', 'ditolak']))
                                        <i class="fas fa-check"></i>
                                    @else
                                        <span class="font-bold">3</span>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <h4 class="font-bold {{ in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']) ? 'text-gray-900' : 'text-gray-400' }}">Proses Seleksi</h4>
                                    <p class="text-sm mt-1 {{ in_array($pendaftaran->status, ['seleksi', 'diterima', 'ditolak']) ? 'text-gray-600' : 'text-gray-400' }}">Ujian seleksi dan penilaian</p>
                                </div>
                            </div>
                            
                            <!-- Step 4: Pengumuman -->
                            <div class="flex items-start">
                                <div class="relative z-10 flex-shrink-0 w-12 h-12 {{ $pendaftaran->status == 'diterima' ? 'bg-green-500' : ($pendaftaran->status == 'ditolak' ? 'bg-red-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center text-white shadow-lg transition-all duration-300">
                                    @if($pendaftaran->status == 'diterima')
                                        <i class="fas fa-check"></i>
                                    @elseif($pendaftaran->status == 'ditolak')
                                        <i class="fas fa-times"></i>
                                    @else
                                        <span class="font-bold">4</span>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <h4 class="font-bold {{ in_array($pendaftaran->status, ['diterima', 'ditolak']) ? 'text-gray-900' : 'text-gray-400' }}">Pengumuman Hasil</h4>
                                    <p class="text-sm mt-1 {{ in_array($pendaftaran->status, ['diterima', 'ditolak']) ? 'text-gray-600' : 'text-gray-400' }}">
                                        @if($pendaftaran->status == 'diterima')
                                            Selamat! Anda diterima
                                        @elseif($pendaftaran->status == 'ditolak')
                                            Maaf, Anda belum diterima
                                        @else
                                            Menunggu hasil seleksi
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="bg-white rounded-2xl shadow-xl p-6 animate-fade-in-up">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-600 rounded-xl flex items-center justify-center text-white mr-3">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        Pengumuman Terbaru
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-r-xl hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white mr-3">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">Jadwal Ujian Seleksi</h4>
                                    <p class="text-gray-600 text-sm mt-1">Ujian seleksi akan dilaksanakan pada tanggal <strong>25 Agustus 2025</strong>.</p>
                                    <span class="text-xs text-gray-500">2 hari yang lalu</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 rounded-r-xl hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-white mr-3">
                                    <i class="fas fa-file-alt text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">Kelengkapan Berkas</h4>
                                    <p class="text-gray-600 text-sm mt-1">Pastikan semua berkas sudah diunggah sebelum <strong>20 Agustus 2025</strong>.</p>
                                    <span class="text-xs text-gray-500">5 hari yang lalu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in-up">
                    <div class="bg-gradient-to-r from-sky-400 to-blue-600 p-6">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 shadow-xl flex items-center justify-center">
                                <span class="text-4xl font-bold text-sky-600">{{ substr($pendaftaran->nama_lengkap, 0, 1) }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-white">{{ $pendaftaran->nama_lengkap }}</h3>
                            <p class="text-sky-100">NISN: {{ $pendaftaran->nisn }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-school w-5 text-center mr-3 text-gray-400"></i>
                                <span class="text-sm">{{ $pendaftaran->asal_sekolah }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-5 text-center mr-3 text-gray-400"></i>
                                <span class="text-sm">{{ $pendaftaran->kota }}, {{ $pendaftaran->provinsi }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fab fa-whatsapp w-5 text-center mr-3 text-gray-400"></i>
                                <span class="text-sm">{{ $pendaftaran->no_whatsapp }}</span>
                            </div>
                        </div>
                        <a href="{{ route('santri.profile') }}" 
                           class="mt-6 w-full block text-center px-4 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-user mr-2"></i>Lihat Profil Lengkap
                        </a>
                    </div>
                </div>

                <!-- WhatsApp Group Info Card -->
                <div class="bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl shadow-xl p-6 text-white animate-fade-in-up">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold flex items-center">
                            <i class="fab fa-whatsapp text-2xl mr-2"></i>
                            Grup PPDB
                        </h3>
                        <span class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full text-xs animate-pulse">
                            AKTIF
                        </span>
                    </div>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-green-50">
                            <i class="fas fa-users w-5 text-center mr-3"></i>
                            <span class="text-sm">250+ Anggota Aktif</span>
                        </div>
                        <div class="flex items-center text-green-50">
                            <i class="fas fa-bell w-5 text-center mr-3"></i>
                            <span class="text-sm">Update Setiap Hari</span>
                        </div>
                        <div class="flex items-center text-green-50">
                            <i class="fas fa-info-circle w-5 text-center mr-3"></i>
                            <span class="text-sm">Info Ujian & Pengumuman</span>
                        </div>
                    </div>
                    
                    <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                       target="_blank"
                       class="w-full block text-center px-4 py-3 bg-white text-green-600 rounded-xl font-bold hover:bg-green-50 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i>Gabung Grup
                    </a>
                    
                    <p class="text-xs text-green-100 text-center mt-3">
                        *Wajib untuk semua pendaftar
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-xl p-6 animate-fade-in-up">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center text-white mr-3">
                            <i class="fas fa-link text-sm"></i>
                        </div>
                        Menu Cepat
                    </h3>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center p-3 bg-gray-50 hover:bg-sky-50 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-download w-5 text-center mr-3 text-gray-400 group-hover:text-sky-600"></i>
                            <span class="text-gray-700 group-hover:text-sky-600">Download Panduan</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-gray-50 hover:bg-sky-50 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-headset w-5 text-center mr-3 text-gray-400 group-hover:text-sky-600"></i>
                            <span class="text-gray-700 group-hover:text-sky-600">Hubungi Panitia</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-gray-50 hover:bg-sky-50 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-question-circle w-5 text-center mr-3 text-gray-400 group-hover:text-sky-600"></i>
                            <span class="text-gray-700 group-hover:text-sky-600">FAQ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating WhatsApp Button -->
<a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
   target="_blank"
   class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-2xl flex items-center justify-center transform hover:scale-110 transition-all duration-300 z-40 animate-bounce">
    <i class="fab fa-whatsapp text-3xl"></i>
    <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-xs font-bold animate-pulse">!</span>
</a>

<!-- Floating Help Text -->
<div class="fixed bottom-8 right-28 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-xl z-40 hidden lg:block animate-fade-in">
    <p class="text-sm font-semibold">Gabung Grup WhatsApp</p>
    <div class="absolute right-0 top-1/2 transform translate-x-1/2 -translate-y-1/2 rotate-45 w-2 h-2 bg-gray-800"></div>
</div>

<!-- WhatsApp Modal -->
<div id="whatsappModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl transform transition-all animate-modal-in">
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 rounded-t-3xl text-white text-center">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full mx-auto mb-4 flex items-center justify-center">
                <i class="fab fa-whatsapp text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold">Grup WhatsApp PPDB</h3>
            <p class="text-green-100 mt-2">Informasi Resmi & Pengumuman</p>
        </div>
        
        <div class="p-6">
            <div class="space-y-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <p class="text-gray-700">Pengumuman jadwal ujian</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <p class="text-gray-700">Info kelengkapan berkas</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <p class="text-gray-700">Hasil seleksi & pengumuman</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <p class="text-gray-700">Q&A dengan panitia</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                   target="_blank"
                   class="flex-1 px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold text-center transition-colors">
                    <i class="fab fa-whatsapp mr-2"></i>Gabung Sekarang
                </a>
                <button onclick="closeWhatsAppModal()" 
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-colors">
                    Nanti
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes fade-in-up {
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
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out both;
    }
    
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    // Share to WhatsApp function
    function shareToWhatsApp() {
        const text = "Ayo gabung grup WhatsApp PPDB MUBOSTA MA eMAS untuk mendapatkan informasi terbaru!";
        const url = "https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t";
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
        window.open(whatsappUrl, '_blank');
    }
    
    // WhatsApp Modal Functions
    function showWhatsAppModal() {
        document.getElementById('whatsappModal').classList.remove('hidden');
        document.getElementById('whatsappModal').classList.add('flex');
    }
    
    function closeWhatsAppModal() {
        document.getElementById('whatsappModal').classList.add('hidden');
        document.getElementById('whatsappModal').classList.remove('flex');
    }
    
    // Show modal on first visit
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('whatsapp_modal_shown')) {
            setTimeout(function() {
                showWhatsAppModal();
                localStorage.setItem('whatsapp_modal_shown', 'true');
            }, 5000);
        }
    });
    
    // Show notification reminder after 30 seconds
    setTimeout(function() {
        if (!localStorage.getItem('whatsapp_reminder_shown')) {
            showWhatsAppReminder();
            localStorage.setItem('whatsapp_reminder_shown', 'true');
        }
    }, 30000);
    
    function showWhatsAppReminder() {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-24 right-4 bg-green-500 text-white p-4 rounded-lg shadow-2xl z-50 animate-fade-in-up max-w-sm';
        notification.innerHTML = `
            <div class="flex items-start space-x-3">
                <i class="fab fa-whatsapp text-2xl"></i>
                <div class="flex-1">
                    <p class="font-semibold">Sudah gabung grup WhatsApp?</p>
                    <p class="text-sm text-green-100 mt-1">Jangan lewatkan info penting!</p>
                    <a href="https://chat.whatsapp.com/FOR34ULSJZvHmduOCOgDZS?mode=ac_t" 
                       target="_blank"
                       class="inline-block mt-2 text-xs bg-white text-green-600 px-3 py-1 rounded-full font-semibold hover:bg-green-50">
                        Gabung Sekarang
                    </a>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-200 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(notification);
        
        // Auto remove after 10 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 10000);
    }
    
    // Close modal when clicking outside
    document.getElementById('whatsappModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeWhatsAppModal();
        }
    });
</script>
@endpush
@endsection
