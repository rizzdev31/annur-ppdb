@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 max-w-4xl">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Data Client</h1>
            <p class="text-gray-600">Update informasi client/santri</p>
        </div>
        <a href="{{ route('admin.accounts.client.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.accounts.client.update', $client->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Account Info -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-user-circle text-blue-500 mr-2"></i> Informasi Akun
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        NISN (Username) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn', $client->nisn) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('nisn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="pending" {{ $client->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="seleksi" {{ $client->status == 'seleksi' ? 'selected' : '' }}>Seleksi</option>
                        <option value="diterima" {{ $client->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $client->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Password Baru (Kosongkan jika tidak ingin mengubah)
                    </label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Min. 6 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        <!-- Personal Info -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-id-card text-green-500 mr-2"></i> Data Pribadi
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $client->nama_lengkap) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select name="jenjang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="SD" {{ $client->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $client->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $client->jenjang == 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $client->tempat_lahir) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $client->tanggal_lahir->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Asal Sekolah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $client->asal_sekolah) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        No. WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $client->no_whatsapp) }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>
            </div>
        </div>

        <!-- Gelombang & Tahun Ajaran -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-calendar-alt text-purple-500 mr-2"></i> Gelombang & Tahun Ajaran
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Gelombang <span class="text-red-500">*</span>
                    </label>
                    <select name="gelombang_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($gelombangs as $gelombang)
                            <option value="{{ $gelombang->id }}" {{ $client->gelombang_id == $gelombang->id ? 'selected' : '' }}>
                                {{ $gelombang->nama_gelombang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_ajaran_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach($tahunAjarans as $tahun)
                            <option value="{{ $tahun->id }}" {{ $client->tahun_ajaran_id == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <a href="{{ route('admin.accounts.client.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-300">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection