@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Data Pendaftar</h1>
            <p class="text-gray-600">Perbarui data pendaftar PPDB</p>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Data Diri Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b flex items-center">
                <i class="fas fa-user text-blue-500 mr-2"></i> Data Diri
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        NISN <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                    @error('nisn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select name="jenjang" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="SD" {{ $user->jenjang == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $user->jenjang == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $user->jenjang == 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir->format('Y-m-d')) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Asal Sekolah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $user->asal_sekolah) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Anak Ke <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="anak_ke" value="{{ old('anak_ke', $user->anak_ke) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           min="1" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jumlah Saudara <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $user->jumlah_saudara) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           min="0" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="seleksi" {{ $user->status == 'seleksi' ? 'selected' : '' }}>Seleksi</option>
                        <option value="diterima" {{ $user->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $user->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b flex items-center">
                <i class="fas fa-users text-green-500 mr-2"></i> Data Orang Tua
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Nama Ayah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $user->nama_ayah) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Nama Ibu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $user->nama_ibu) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Pekerjaan Ayah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $user->pekerjaan_ayah) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Pekerjaan Ibu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $user->pekerjaan_ibu) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Pendidikan Ayah <span class="text-red-500">*</span>
                    </label>
                    <select name="pendidikan_ayah" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="SD" {{ $user->pendidikan_ayah == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $user->pendidikan_ayah == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $user->pendidikan_ayah == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ $user->pendidikan_ayah == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ $user->pendidikan_ayah == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ $user->pendidikan_ayah == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ $user->pendidikan_ayah == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Pendidikan Ibu <span class="text-red-500">*</span>
                    </label>
                    <select name="pendidikan_ibu" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                        <option value="SD" {{ $user->pendidikan_ibu == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ $user->pendidikan_ibu == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ $user->pendidikan_ibu == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="D3" {{ $user->pendidikan_ibu == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ $user->pendidikan_ibu == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ $user->pendidikan_ibu == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ $user->pendidikan_ibu == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Alamat & Kontak Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b flex items-center">
                <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i> Alamat & Kontak
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Provinsi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Kota/Kabupaten <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kota" value="{{ old('kota', $user->kota) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Kecamatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat_lengkap" rows="3" 
                              class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                              required>{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        No. WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $user->no_whatsapp) }}" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b flex items-center">
                <i class="fas fa-lock text-red-500 mr-2"></i> Ganti Password (Opsional)
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Password Baru
                    </label>
                    <input type="password" name="password" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Kosongkan jika tidak ingin mengubah">
                    <p class="text-xs text-gray-500 mt-1">Min. 6 karakter</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        <!-- Upload Dokumen Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h2 class="text-xl font-bold mb-4 pb-2 border-b flex items-center">
                <i class="fas fa-file-upload text-purple-500 mr-2"></i> Upload/Update Dokumen
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bukti Pembayaran -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Bukti Pembayaran
                    </label>
                    @if($user->bukti_pembayaran)
                        <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700">
                                <i class="fas fa-check-circle"></i> File sudah diupload
                                <a href="{{ asset('uploads/' . $user->bukti_pembayaran) }}" target="_blank"
                                   class="text-blue-600 hover:underline ml-2">Lihat</a>
                            </p>
                        </div>
                    @endif
                    <input type="file" name="bukti_pembayaran" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </div>

                <!-- Ijazah -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Ijazah (Opsional)
                    </label>
                    @if($user->ijazah)
                        <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700">
                                <i class="fas fa-check-circle"></i> File sudah diupload
                                <a href="{{ asset('uploads/' . $user->ijazah) }}" target="_blank"
                                   class="text-blue-600 hover:underline ml-2">Lihat</a>
                            </p>
                        </div>
                    @endif
                    <input type="file" name="ijazah" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </div>

                <!-- Surat Keterangan Lulus -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Surat Keterangan Lulus (Opsional)
                    </label>
                    @if($user->surat_keterangan_lulus)
                        <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700">
                                <i class="fas fa-check-circle"></i> File sudah diupload
                                <a href="{{ asset('uploads/' . $user->surat_keterangan_lulus) }}" target="_blank"
                                   class="text-blue-600 hover:underline ml-2">Lihat</a>
                            </p>
                        </div>
                    @endif
                    <input type="file" name="surat_keterangan_lulus" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </div>

                <!-- Akta Kelahiran -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Akta Kelahiran (Opsional)
                    </label>
                    @if($user->akta_kelahiran)
                        <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700">
                                <i class="fas fa-check-circle"></i> File sudah diupload
                                <a href="{{ asset('uploads/' . $user->akta_kelahiran) }}" target="_blank"
                                   class="text-blue-600 hover:underline ml-2">Lihat</a>
                            </p>
                        </div>
                    @endif
                    <input type="file" name="akta_kelahiran" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </div>

                <!-- Kartu Keluarga -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Kartu Keluarga (Opsional)
                    </label>
                    @if($user->kartu_keluarga)
                        <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                            <p class="text-sm text-green-700">
                                <i class="fas fa-check-circle"></i> File sudah diupload
                                <a href="{{ asset('uploads/' . $user->kartu_keluarga) }}" target="_blank"
                                   class="text-blue-600 hover:underline ml-2">Lihat</a>
                            </p>
                        </div>
                    @endif
                    <input type="file" name="kartu_keluarga" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <a href="{{ route('admin.users.index') }}" 
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