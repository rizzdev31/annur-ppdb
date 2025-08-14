@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Dashboard Santri</h1>
                    <p class="text-blue-100 mt-1">Selamat datang, {{ $pendaftaran->nama_lengkap }}</p>
                </div>
                <div class="text-right">
                    <p class="text-white text-sm">NISN: {{ $pendaftaran->nisn }}</p>
                    <p class="text-blue-100 text-xs">{{ now()->format('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Alert for Incomplete Data -->
        @if(count($incompleteFields) > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Data Anda belum lengkap!</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Mohon lengkapi data berikut:</p>
                        <ul class="list-disc list-inside mt-1">
                            @foreach($incompleteFields as $key => $field)
                                @if($key !== 'docs')
                                    <li>{{ $field }}</li>
                                @endif
                            @endforeach
                        </ul>
                        <a href="{{ route('santri.profile') }}" 
                           class="inline-block mt-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                            <i class="fas fa-edit"></i> Lengkapi Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Seleksi Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-trophy mr-2"></i> Status Seleksi
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-8">
                            @if($pendaftaran->status == 'diterima')
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                                    <i class="fas fa-check-circle text-green-600 text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-green-600 mb-2">SELAMAT! ANDA DITERIMA</h3>
                                <p class="text-gray-600">Anda telah diterima di {{ $pendaftaran->gelombang->nama_gelombang ?? 'Gelombang' }} Tahun Ajaran {{ $pendaftaran->tahunAjaran->tahun ?? '' }}</p>
                            @elseif($pendaftaran->status == 'ditolak')
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-4">
                                    <i class="fas fa-times-circle text-red-600 text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-red-600 mb-2">MOHON MAAF</h3>
                                <p class="text-gray-600">Anda belum diterima pada seleksi kali ini. Tetap semangat dan coba lagi!</p>
                            @elseif($pendaftaran->status == 'seleksi')
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-4">
                                    <i class="fas fa-hourglass-half text-blue-600 text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-blue-600 mb-2">PROSES SELEKSI</h3>
                                <p class="text-gray-600">Data Anda sedang dalam proses seleksi. Mohon tunggu pengumuman selanjutnya.</p>
                            @else
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full mb-4">
                                    <i class="fas fa-clock text-yellow-600 text-5xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-yellow-600 mb-2">MENUNGGU VERIFIKASI</h3>
                                <p class="text-gray-600">Pendaftaran Anda sedang diverifikasi oleh tim kami. Harap bersabar.</p>
                            @endif
                        </div>
                        
                        <!-- Progress Bar Section (Fixed) -->
                        <div class="mt-8">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-medium text-gray-600">Progress Seleksi</span>
                                <span class="text-xs font-medium text-gray-600">
                                    @if($pendaftaran->status == 'pending') 25%
                                    @elseif($pendaftaran->status == 'seleksi') 50%
                                    @elseif($pendaftaran->status == 'diterima' || $pendaftaran->status == 'ditolak') 100%
                                    @endif
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                @if($pendaftaran->status == 'pending')
                                    <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 25%"></div>
                                @elseif($pendaftaran->status == 'seleksi')
                                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: 50%"></div>
                                @elseif($pendaftaran->status == 'diterima')
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                                @elseif($pendaftaran->status == 'ditolak')
                                    <div class="bg-red-500 h-2.5 rounded-full" style="width: 100%"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengumuman & Berita -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-bullhorn mr-2"></i> Pengumuman & Berita Terbaru
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($beritas->count() > 0)
                            <div class="space-y-4">
                                @foreach($beritas as $berita)
                                <article class="border-l-4 border-blue-500 pl-4 py-2 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 hover:text-blue-600">
                                                <a href="{{ route('berita.show', $berita->slug) }}" target="_blank">
                                                    {{ $berita->judul }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($berita->excerpt, 100) }}</p>
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $berita->created_at->format('d M Y') }}
                                                @if($berita->kategori)
                                                    <span class="mx-2">•</span>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                        {{ ucfirst($berita->kategori) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($berita->image)
                                        <img src="{{ asset('storage/' . $berita->image) }}" 
                                             alt="{{ $berita->judul }}"
                                             class="w-20 h-20 object-cover rounded-lg ml-4">
                                        @endif
                                    </div>
                                </article>
                                @endforeach
                            </div>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('berita.index') }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Lihat Semua Berita <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-newspaper text-gray-300 text-5xl mb-3"></i>
                                <p class="text-gray-500">Belum ada pengumuman atau berita</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-rocket mr-2"></i> Menu Cepat
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('santri.profile') }}" 
                           class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <span class="flex items-center">
                                <i class="fas fa-user-edit text-blue-600 mr-3"></i>
                                <span class="font-medium">Edit Profil</span>
                            </span>
                            <i class="fas fa-chevron-right text-blue-400"></i>
                        </a>
                        
                        <a href="#" onclick="showChangePasswordModal()" 
                           class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <span class="flex items-center">
                                <i class="fas fa-key text-purple-600 mr-3"></i>
                                <span class="font-medium">Ganti Password</span>
                            </span>
                            <i class="fas fa-chevron-right text-purple-400"></i>
                        </a>
                        
                        <a href="#" onclick="printCard()"
                           class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <span class="flex items-center">
                                <i class="fas fa-print text-green-600 mr-3"></i>
                                <span class="font-medium">Cetak Kartu</span>
                            </span>
                            <i class="fas fa-chevron-right text-green-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Profile Summary -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-id-card mr-2"></i> Info Akun
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-800">{{ $pendaftaran->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-600">{{ $pendaftaran->nisn }}</p>
                        </div>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenjang:</span>
                                <span class="font-medium">{{ $pendaftaran->jenjang }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Asal Sekolah:</span>
                                <span class="font-medium">{{ Str::limit($pendaftaran->asal_sekolah, 20) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">WhatsApp:</span>
                                <span class="font-medium">{{ $pendaftaran->no_whatsapp }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gelombang:</span>
                                <span class="font-medium">{{ $pendaftaran->gelombang->nama_gelombang ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Terdaftar:</span>
                                <span class="text-xs text-gray-600">{{ $pendaftaran->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Status -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fas fa-file-alt mr-2"></i> Status Dokumen
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Dokumen Wajib -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm">Bukti Pembayaran</span>
                                @if($pendaftaran->bukti_pembayaran)
                                    <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                @else
                                    <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                @endif
                            </div>
                            
                            <!-- Dokumen Opsional -->
                            <div class="pt-2 border-t">
                                <p class="text-xs text-gray-500 mb-2">Dokumen Opsional:</p>
                                
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm">Ijazah</span>
                                    @if($pendaftaran->ijazah)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-gray-400"><i class="fas fa-minus-circle"></i></span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm">SKL</span>
                                    @if($pendaftaran->surat_keterangan_lulus)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-gray-400"><i class="fas fa-minus-circle"></i></span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm">Akta Kelahiran</span>
                                    @if($pendaftaran->akta_kelahiran)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-gray-400"><i class="fas fa-minus-circle"></i></span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm">Kartu Keluarga</span>
                                    @if($pendaftaran->kartu_keluarga)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-gray-400"><i class="fas fa-minus-circle"></i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($incompleteFields['docs']) && count($incompleteFields['docs']) > 0)
                        <div class="mt-4">
                            <a href="{{ route('santri.profile') }}" 
                               class="w-full bg-indigo-600 text-white text-center py-2 rounded-lg hover:bg-indigo-700 transition block">
                                Upload Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Change Password -->
<div id="changePasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="text-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Ganti Password</h3>
        </div>
        
        <form action="{{ route('santri.change-password') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                    <input type="password" name="current_password" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mt-6 flex space-x-3">
                <button type="button" onclick="closeChangePasswordModal()"
                        class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.remove('hidden');
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
}

function printCard() {
    // Implement print card functionality
    window.print();
}
</script>
@endpush
@endsection