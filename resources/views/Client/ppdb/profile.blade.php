@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Profil Lengkap</h1>
                <p class="text-gray-600">Data lengkap pendaftaran PPDB</p>
            </div>

            <!-- Back Button -->
            <a href="{{ route('santri.dashboard') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>

            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <!-- Status Badge -->
                <div class="mb-6 pb-6 border-b">
                    @php
                        $statusColors = [
                            'pending' => 'yellow',
                            'seleksi' => 'blue',
                            'diterima' => 'green',
                            'ditolak' => 'red'
                        ];
                        $color = $statusColors[$pendaftaran->status] ?? 'gray';
                    @endphp
                    <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                        Status: {{ ucfirst($pendaftaran->status) }}
                    </span>
                </div>

                <!-- Data Sections -->
                <div class="space-y-8">
                    <!-- Data Pribadi -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Data Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">NISN</label>
                                <p class="font-semibold">{{ $pendaftaran->nisn }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Nama Lengkap</label>
                                <p class="font-semibold">{{ $pendaftaran->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Tempat Lahir</label>
                                <p class="font-semibold">{{ $pendaftaran->tempat_lahir }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Tanggal Lahir</label>
                                <p class="font-semibold">{{ $pendaftaran->tanggal_lahir->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Anak Ke</label>
                                <p class="font-semibold">{{ $pendaftaran->anak_ke }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Jumlah Saudara</label>
                                <p class="font-semibold">{{ $pendaftaran->jumlah_saudara }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Data Orang Tua</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Nama Ayah</label>
                                <p class="font-semibold">{{ $pendaftaran->nama_ayah }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Nama Ibu</label>
                                <p class="font-semibold">{{ $pendaftaran->nama_ibu }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Pekerjaan Ayah</label>
                                <p class="font-semibold">{{ $pendaftaran->pekerjaan_ayah }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Pekerjaan Ibu</label>
                                <p class="font-semibold">{{ $pendaftaran->pekerjaan_ibu }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Pendidikan Ayah</label>
                                <p class="font-semibold">{{ $pendaftaran->pendidikan_ayah }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Pendidikan Ibu</label>
                                <p class="font-semibold">{{ $pendaftaran->pendidikan_ibu }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Alamat -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Data Alamat & Kontak</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Provinsi</label>
                                <p class="font-semibold">{{ $pendaftaran->provinsi }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Kota/Kabupaten</label>
                                <p class="font-semibold">{{ $pendaftaran->kota }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Kecamatan</label>
                                <p class="font-semibold">{{ $pendaftaran->kecamatan }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Asal Sekolah</label>
                                <p class="font-semibold">{{ $pendaftaran->asal_sekolah }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-sm text-gray-500">Alamat Lengkap</label>
                                <p class="font-semibold">{{ $pendaftaran->alamat_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">No. WhatsApp</label>
                                <p class="font-semibold">{{ $pendaftaran->no_whatsapp }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pendaftaran -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Data Pendaftaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500">Token</label>
                                <p class="font-mono font-semibold">{{ $pendaftaran->token }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Gelombang</label>
                                <p class="font-semibold">{{ $pendaftaran->gelombang->nama_gelombang }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Tahun Ajaran</label>
                                <p class="font-semibold">{{ $pendaftaran->tahunAjaran->tahun }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Tanggal Daftar</label>
                                <p class="font-semibold">{{ $pendaftaran->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Bukti Pembayaran</h3>
                        @if($pendaftaran->bukti_pembayaran)
                            <img src="{{ Storage::url($pendaftaran->bukti_pembayaran) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="max-w-md rounded-lg shadow cursor-pointer"
                                 onclick="window.open('{{ Storage::url($pendaftaran->bukti_pembayaran) }}', '_blank')">
                        @else
                            <p class="text-gray-500">Tidak ada bukti pembayaran</p>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-8 border-t flex justify-end space-x-4">
                    <button onclick="window.print()" 
                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                    
                    @if($pendaftaran->status == 'diterima')
                    <button class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Surat Penerimaan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection