@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard Santri</h1>
                    {{-- Pastikan Anda mengirimkan variabel user yang sedang login dari controller --}}
                    <p class="text-gray-600">Selamat datang, {{ $pendaftaran->nama_lengkap ?? 'Calon Santri' }}!</p>
                </div>
                <div>
                    {{-- Route logout disesuaikan menjadi 'santri.logout' --}}
                    <a href="{{ route('santri.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="btn-secondary">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Status Pendaftaran -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Status Pendaftaran Anda</h2>
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => '<svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'],
                            'seleksi' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => '<svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'],
                            'diterima' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => '<svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'],
                            'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => '<svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'],
                        ];
                        $statusInfo = $statusColors[$pendaftaran->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => ''];
                    @endphp
                    <div class="flex items-center p-4 rounded-lg {{ $statusInfo['bg'] }} {{ $statusInfo['text'] }}">
                        {!! $statusInfo['icon'] !!}
                        <div>
                            <p class="font-bold text-2xl">{{ ucfirst($pendaftaran->status) }}</p>
                            <p class="text-sm">Status pendaftaran Anda saat ini. Kami akan memberitahu Anda jika ada pembaruan.</p>
                        </div>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Pengumuman Penting</h2>
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-800 rounded-r-lg">
                            <h4 class="font-bold">Jadwal Ujian Seleksi</h4>
                            <p>Ujian seleksi akan dilaksanakan pada tanggal <strong>25 Agustus 2025</strong>. Informasi detail mengenai ruangan dan sesi akan diumumkan lebih lanjut.</p>
                        </div>
                         <div class="p-4 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 rounded-r-lg">
                            <h4 class="font-bold">Kelengkapan Berkas</h4>
                            <p>Pastikan Anda telah mengunggah semua berkas yang diperlukan sebelum tanggal <strong>20 Agustus 2025</strong>. Kekurangan berkas dapat mempengaruhi proses seleksi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 text-center">
                    <img src="https://placehold.co/100x100/E2E8F0/4A5568?text=Foto" alt="Foto Profil" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow">
                    <h3 class="text-lg font-bold text-gray-800">{{ $pendaftaran->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-500">NISN: {{ $pendaftaran->nisn }}</p>
                    {{-- Route profile sudah sesuai dengan 'santri.profile' --}}
                    <a href="{{ route('profile') }}" class="btn-primary w-full mt-4">
                        Lihat Profil Lengkap
                    </a>
                </div>

                <!-- Langkah Selanjutnya -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Langkah Selanjutnya</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-semibold">Pendaftaran Selesai</p>
                                <p class="text-sm text-gray-500">Anda telah berhasil mengirimkan formulir.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                             <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3 font-bold text-xs">2</div>
                            <div>
                                <p class="font-semibold">Menunggu Verifikasi</p>
                                <p class="text-sm text-gray-500">Panitia akan memeriksa data dan berkas Anda.</p>
                            </div>
                        </li>
                        <li class="flex items-start opacity-50">
                             <div class="flex-shrink-0 w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white mr-3 font-bold text-xs">3</div>
                            <div>
                                <p class="font-semibold">Ujian Seleksi</p>
                                <p class="text-sm text-gray-500">Ikuti ujian sesuai jadwal yang ditentukan.</p>
                            </div>
                        </li>
                        <li class="flex items-start opacity-50">
                             <div class="flex-shrink-0 w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white mr-3 font-bold text-xs">4</div>
                            <div>
                                <p class="font-semibold">Pengumuman Hasil</p>
                                <p class="text-sm text-gray-500">Lihat hasil kelulusan di dashboard ini.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary {
        display: inline-block;
        background-color: #2563EB;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-align: center;
        transition: background-color 0.3s;
        border: none;
    }
    .btn-primary:hover {
        background-color: #1D4ED8;
    }
    .btn-secondary {
        display: inline-block;
        background-color: #E5E7EB;
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: background-color 0.3s;
        border: none;
    }
    .btn-secondary:hover {
        background-color: #D1D5DB;
    }
</style>
@endsection
