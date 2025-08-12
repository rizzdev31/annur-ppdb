@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Santri</h1>
            <p class="text-gray-600">Selamat datang, {{ $pendaftaran->nama_lengkap }}!</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Status Pendaftaran</h2>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-gray-600">Status Anda saat ini:</p>
                            @php
                                $statusColors = [
                                    'pending' => 'yellow',
                                    'seleksi' => 'blue',
                                    'diterima' => 'green',
                                    'ditolak' => 'red'
                                ];
                                $color = $statusColors[$pendaftaran->status] ?? 'gray';
                                $statusText = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'seleksi' => 'Dalam Proses Seleksi',
                                    'diterima' => 'DITERIMA',
                                    'ditolak' => 'Tidak Diterima'
                                ];
                            @endphp
                            <span class="text-2xl font-bold text-{{ $color }}-600">
                                {{ $statusText[$pendaftaran->status] ?? 'Pending' }}
                            </span>
                        </div>
                        <div class="text-center">
                            @if($pendaftaran->status == 'pending')
                                <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($pendaftaran->status == 'seleksi')
                                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 100 4h2a2 2 0 100 4h-.586l-.707.707A1 1 0 0010 15h.586l.707-.707A1 1 0 0012 13V7a2 2 0 100-4V3a1 1 0 000 2h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($pendaftaran->status == 'diterima')
                                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Progress Pendaftaran</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold">Pendaftaran</p>
                                    <p class="text-sm text-gray-500">Selesai pada {{ $pendaftaran->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 {{ in_array($pendaftaran->status, ['pending', 'seleksi', 'diterima']) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                    @if(in_array($pendaftaran->status, ['pending', 'seleksi', 'diterima']))
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold">Verifikasi Data</p>
                                    <p class="text-sm text-gray-500">
                                        @if(in_array($pendaftaran->status, ['seleksi', 'diterima']))
                                            Data telah diverifikasi
                                        @else
                                            Menunggu verifikasi
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 {{ in_array($pendaftaran->status, ['seleksi', 'diterima']) ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                    @if($pendaftaran->status == 'seleksi')
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    @elseif($pendaftaran->status == 'diterima')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold">Proses Seleksi</p>
                                    <p class="text-sm text-gray-500">
                                        @if($pendaftaran->status == 'seleksi')
                                            Sedang berlangsung
                                        @elseif($pendaftaran->status == 'diterima')
                                            Selesai
                                        @else
                                            Belum dimulai
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="w-8 h-8 {{ $pendaftaran->status == 'diterima' ? 'bg-green-500' : ($pendaftaran->status == 'ditolak' ? 'bg-red-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center">
                                    @if($pendaftaran->status == 'diterima' || $pendaftaran->status == 'ditolak')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold">Pengumuman</p>
                                    <p class="text-sm text-gray-500">
                                        @if($pendaftaran->status == 'diterima')
                                            SELAMAT! Anda diterima
                                        @elseif($pendaftaran->status == 'ditolak')
                                            Maaf, Anda belum diterima
                                        @else
                                            Menunggu pengumuman
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Diri -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Data Diri</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">NISN</p>
                            <p class="font-semibold">{{ $pendaftaran->nisn }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold">{{ $pendaftaran->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-semibold">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Asal Sekolah</p>
                            <p class="font-semibold">{{ $pendaftaran->asal_sekolah }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. WhatsApp</p>
                            <p class="font-semibold">{{ $pendaftaran->no_whatsapp }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-semibold">{{ $pendaftaran->alamat_lengkap }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Pendaftaran -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pendaftaran</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Gelombang</p>
                            <p class="font-semibold">{{ $pendaftaran->gelombang->nama_gelombang }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tahun Ajaran</p>
                            <p class="font-semibold">{{ $pendaftaran->tahunAjaran->tahun }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Daftar</p>
                            <p class="font-semibold">{{ $pendaftaran->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Token</p>
                            <p class="font-mono font-semibold">{{ $pendaftaran->token }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Menu</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('santri.profile') }}" 
                           class="block w-full text-left px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">
                            Lihat Profil Lengkap
                        </a>
                        
                        @if($pendaftaran->status == 'diterima')
                        <button class="block w-full text-left px-4 py-2 bg-green-100 text-green-700 rounded hover:bg-green-200">
                            Download Surat Penerimaan
                        </button>
                        @endif
                        
                        <form action="{{ route('santri.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Help -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-900 mb-2">Butuh Bantuan?</h4>
                    <p class="text-sm text-blue-700 mb-2">Hubungi panitia PPDB:</p>
                    <p class="text-sm text-blue-700">
                        <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        0812-3456-7890
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection