@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pendaftar</h1>
            <p class="text-gray-600">Informasi lengkap pendaftar PPDB</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button onclick="sendCredentials({{ $user->id }})" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-paper-plane"></i> Kirim Kredensial
            </button>
            <button onclick="resetPassword({{ $user->id }})" 
                    class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                <i class="fas fa-key"></i> Reset Password
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Diri -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Data Diri</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">NISN</p>
                        <p class="font-semibold">{{ $user->nisn }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold">{{ $user->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold">{{ $user->tempat_lahir }}, {{ $user->tanggal_lahir->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jenjang</p>
                        <p class="font-semibold">{{ $user->jenjang }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Asal Sekolah</p>
                        <p class="font-semibold">{{ $user->asal_sekolah }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Anak Ke / Jumlah Saudara</p>
                        <p class="font-semibold">{{ $user->anak_ke }} / {{ $user->jumlah_saudara }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Data Orang Tua</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Ayah</p>
                        <p class="font-semibold">{{ $user->nama_ayah }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nama Ibu</p>
                        <p class="font-semibold">{{ $user->nama_ibu }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pekerjaan Ayah</p>
                        <p class="font-semibold">{{ $user->pekerjaan_ayah }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pekerjaan Ibu</p>
                        <p class="font-semibold">{{ $user->pekerjaan_ibu }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendidikan Ayah</p>
                        <p class="font-semibold">{{ $user->pendidikan_ayah }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pendidikan Ibu</p>
                        <p class="font-semibold">{{ $user->pendidikan_ibu }}</p>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Alamat & Kontak</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Alamat Lengkap</p>
                        <p class="font-semibold">{{ $user->alamat_lengkap }}</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Provinsi</p>
                            <p class="font-semibold">{{ $user->provinsi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kota/Kabupaten</p>
                            <p class="font-semibold">{{ $user->kota }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kecamatan</p>
                            <p class="font-semibold">{{ $user->kecamatan }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. WhatsApp</p>
                        <p class="font-semibold">{{ $user->no_whatsapp }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">Status</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Status Pendaftaran</p>
                        @if($user->status == 'pending')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($user->status == 'seleksi')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Seleksi
                            </span>
                        @elseif($user->status == 'diterima')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Diterima
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kredensial</p>
                        @if($user->is_credentials_sent)
                            <p class="text-green-600">
                                <i class="fas fa-check-circle"></i> Sudah dikirim
                            </p>
                            <p class="text-xs text-gray-500">{{ $user->credentials_sent_at->format('d M Y H:i') }}</p>
                        @else
                            <p class="text-yellow-600">
                                <i class="fas fa-clock"></i> Belum dikirim
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">Dokumen</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Bukti Pembayaran</span>
                        @if($user->bukti_pembayaran)
                            <a href="{{ asset('uploads/' . $user->bukti_pembayaran) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Lihat
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Ijazah</span>
                        @if($user->ijazah)
                            <a href="{{ asset('uploads/' . $user->ijazah) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Belum diupload</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Surat Keterangan Lulus</span>
                        @if($user->surat_keterangan_lulus)
                            <a href="{{ asset('uploads/' . $user->surat_keterangan_lulus) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Belum diupload</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Akta Kelahiran</span>
                        @if($user->akta_kelahiran)
                            <a href="{{ asset('uploads/' . $user->akta_kelahiran) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Belum diupload</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Kartu Keluarga</span>
                        @if($user->kartu_keluarga)
                            <a href="{{ asset('uploads/' . $user->kartu_keluarga) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Belum diupload</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Pendaftaran -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">Info Pendaftaran</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Gelombang</p>
                        <p class="font-semibold">{{ $user->gelombang->nama_gelombang ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tahun Ajaran</p>
                        <p class="font-semibold">{{ $user->tahunAjaran->tahun ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Token</p>
                        <p class="font-mono text-sm">{{ $user->token }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Daftar</p>
                        <p class="font-semibold">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kirim Kredensial -->
<div id="credentialsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Kredensial Login</h3>
        <div id="credentialsContent"></div>
        <div class="mt-4">
            <button onclick="closeModal()" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendCredentials(userId) {
    if (confirm('Kirim kredensial login ke user ini?')) {
        fetch(`/admin/users/${userId}/send-credentials`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('credentialsContent').innerHTML = `
                    <div class="bg-green-50 p-4 rounded">
                        <p class="text-sm text-gray-600">Kredensial berhasil dikirim!</p>
                        <div class="mt-3 space-y-2">
                            <div>
                                <p class="text-xs text-gray-500">Username (NISN)</p>
                                <p class="font-mono font-bold">${data.data.nisn}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Password</p>
                                <p class="font-mono font-bold">${data.data.password}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">WhatsApp</p>
                                <p class="font-mono">${data.data.whatsapp}</p>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('credentialsModal').classList.remove('hidden');
                setTimeout(() => location.reload(), 3000);
            }
        });
    }
}

function resetPassword(userId) {
    if (confirm('Reset password untuk user ini?')) {
        fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Password berhasil direset!\n\nPassword baru: ${data.password}`);
            }
        });
    }
}

function closeModal() {
    document.getElementById('credentialsModal').classList.add('hidden');
}
</script>
@endpush
@endsection