@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Pendaftaran</h1>
                <p class="text-gray-600">Informasi lengkap calon santri</p>
            </div>
            <a href="{{ route('admin.ppdb.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Pribadi -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Pribadi</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">NISN</p>
                        <p class="font-semibold">{{ $pendaftaran->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold">{{ $pendaftaran->nama_lengkap ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold">
                            {{ $pendaftaran->tempat_lahir ?? '-' }}, 
                            {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Anak Ke / Jumlah Saudara</p>
                        <p class="font-semibold">{{ $pendaftaran->anak_ke ?? '-' }} / {{ $pendaftaran->jumlah_saudara ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Orang Tua</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Ayah</p>
                        <p class="font-semibold">{{ $pendaftaran->nama_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nama Ibu</p>
                        <p class="font-semibold">{{ $pendaftaran->nama_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pekerjaan Ayah</p>
                        <p class="font-semibold">{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pekerjaan Ibu</p>
                        <p class="font-semibold">{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendidikan Ayah</p>
                        <p class="font-semibold">{{ $pendaftaran->pendidikan_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendidikan Ibu</p>
                        <p class="font-semibold">{{ $pendaftaran->pendidikan_ibu ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Alamat -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Data Alamat & Kontak</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Asal Sekolah</p>
                        <p class="font-semibold">{{ $pendaftaran->asal_sekolah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. WhatsApp</p>
                        <p class="font-semibold">{{ $pendaftaran->no_whatsapp ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Alamat Lengkap</p>
                        <p class="font-semibold">
                            {{ $pendaftaran->alamat_lengkap ?? '-' }}<br>
                            Kec. {{ $pendaftaran->kecamatan ?? '-' }}, 
                            {{ $pendaftaran->kota ?? '-' }}, 
                            {{ $pendaftaran->provinsi ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Info -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pendaftaran</h3>
                
                <div class="mb-4">
                    @php
                        $statusColors = [
                            'pending' => 'yellow',
                            'seleksi' => 'blue',
                            'diterima' => 'green',
                            'ditolak' => 'red'
                        ];
                        $color = $statusColors[$pendaftaran->status ?? 'pending'] ?? 'gray';
                    @endphp
                    <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                        {{ ucfirst($pendaftaran->status ?? 'pending') }}
                    </span>
                </div>

                <form action="{{ route('admin.ppdb.update-status', $pendaftaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Update Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="pending" {{ $pendaftaran->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="seleksi" {{ $pendaftaran->status == 'seleksi' ? 'selected' : '' }}>Seleksi</option>
                            <option value="diterima" {{ $pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Info Pendaftaran -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pendaftaran</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Gelombang</p>
                        <p class="font-semibold">{{ $pendaftaran->gelombang->nama_gelombang ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tahun Ajaran</p>
                        <p class="font-semibold">{{ $pendaftaran->tahunAjaran->tahun ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Daftar</p>
                        <p class="font-semibold">{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d M Y H:i') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Token</p>
                        <p class="font-semibold">{{ $pendaftaran->token ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bukti Pembayaran</h3>
                @if($pendaftaran->bukti_pembayaran)
                    <img src="{{ Storage::url($pendaftaran->bukti_pembayaran) }}" 
                         alt="Bukti Pembayaran" 
                         class="w-full rounded-lg cursor-pointer"
                         onclick="window.open('{{ Storage::url($pendaftaran->bukti_pembayaran) }}', '_blank')">
                    <button onclick="window.open('{{ Storage::url($pendaftaran->bukti_pembayaran) }}', '_blank')"
                            class="mt-3 w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700">
                        Lihat Full Size
                    </button>
                @else
                    <p class="text-gray-500">Tidak ada bukti pembayaran</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                <div class="space-y-2">
                    <button onclick="window.print()" 
                            class="w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700">
                        Print
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftaran->no_whatsapp ?? '') }}" 
                       target="_blank"
                       class="block w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 text-center">
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection