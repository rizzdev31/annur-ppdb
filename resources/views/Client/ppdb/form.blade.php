@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-3">
                    Form Pendaftaran Santri Baru
                </h1>
                <p class="text-gray-600">Isi data dengan lengkap dan benar untuk proses pendaftaran</p>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-full shadow-md p-2 mb-8">
                <div class="flex justify-between items-center px-4">
                    <div class="flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-sm font-bold">1</span>
                        <span class="ml-2 text-sm font-medium text-gray-700">Data Diri</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-3"></div>
                    <div class="flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-full text-sm font-bold">2</span>
                        <span class="ml-2 text-sm font-medium text-gray-700">Data Orang Tua</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-200 mx-3"></div>
                    <div class="flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full text-sm font-bold">3</span>
                        <span class="ml-2 text-sm font-medium text-gray-700">Dokumen</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Data Diri Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg mr-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Diri Calon Santri</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-id-card mr-1 text-blue-500"></i> NISN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   placeholder="Masukkan NISN" required>
                            @error('nisn')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-user-circle mr-1 text-blue-500"></i> Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   placeholder="Nama lengkap sesuai ijazah" required>
                            @error('nama_lengkap')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   placeholder="Kota tempat lahir" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-child mr-1 text-blue-500"></i> Anak Ke <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" min="1"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   placeholder="Contoh: 1" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-blue-600 transition duration-300">
                                <i class="fas fa-users mr-1 text-blue-500"></i> Jumlah Saudara <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" min="0"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300"
                                   placeholder="Contoh: 2" required>
                        </div>
                    </div>
                </div>

                <!-- Data Pendidikan Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-purple-500 to-purple-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg mr-3">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Pendidikan</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-purple-600 transition duration-300">
                                <i class="fas fa-school mr-1 text-purple-500"></i> Asal Sekolah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition duration-300"
                                   placeholder="Nama sekolah asal" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-purple-600 transition duration-300">
                                <i class="fas fa-layer-group mr-1 text-purple-500"></i> Jenjang Pendidikan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenjang" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition duration-300" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>Sekolah Dasar (SD)</option>
                                <option value="SMP" {{ old('jenjang') == 'SMP' ? 'selected' : '' }}>Sekolah Menengah Pertama (SMP)</option>
                                <option value="SMA" {{ old('jenjang') == 'SMA' ? 'selected' : '' }}>Sekolah Menengah Atas (SMA)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-green-500 to-green-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg mr-3">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Orang Tua</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-male mr-1 text-green-500"></i> Nama Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300"
                                   placeholder="Nama lengkap ayah" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-female mr-1 text-green-500"></i> Nama Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300"
                                   placeholder="Nama lengkap ibu" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-briefcase mr-1 text-green-500"></i> Pekerjaan Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300"
                                   placeholder="Contoh: Wiraswasta" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-briefcase mr-1 text-green-500"></i> Pekerjaan Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300"
                                   placeholder="Contoh: Ibu Rumah Tangga" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-graduation-cap mr-1 text-green-500"></i> Pendidikan Ayah <span class="text-red-500">*</span>
                            </label>
                            <select name="pendidikan_ayah" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300" required>
                                <option value="">-- Pilih Pendidikan --</option>
                                <option value="SD" {{ old('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ayah') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D3" {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-green-600 transition duration-300">
                                <i class="fas fa-graduation-cap mr-1 text-green-500"></i> Pendidikan Ibu <span class="text-red-500">*</span>
                            </label>
                            <select name="pendidikan_ibu" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition duration-300" required>
                                <option value="">-- Pilih Pendidikan --</option>
                                <option value="SD" {{ old('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ old('pendidikan_ibu') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D3" {{ old('pendidikan_ibu') == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('pendidikan_ibu') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('pendidikan_ibu') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Data Alamat Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-orange-500 to-orange-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg mr-3">
                            <i class="fas fa-home"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Alamat</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-orange-600 transition duration-300">
                                <i class="fas fa-map mr-1 text-orange-500"></i> Provinsi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="provinsi" value="{{ old('provinsi') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-300"
                                   placeholder="Nama provinsi" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-orange-600 transition duration-300">
                                <i class="fas fa-city mr-1 text-orange-500"></i> Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kota" value="{{ old('kota') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-300"
                                   placeholder="Nama kota/kabupaten" required>
                        </div>

                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-orange-600 transition duration-300">
                                <i class="fas fa-map-pin mr-1 text-orange-500"></i> Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" 
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-300"
                                   placeholder="Nama kecamatan" required>
                        </div>

                        <div class="md:col-span-3 group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-orange-600 transition duration-300">
                                <i class="fas fa-road mr-1 text-orange-500"></i> Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_lengkap" rows="3" 
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-300"
                                      placeholder="Jalan, RT/RW, Desa/Kelurahan" required>{{ old('alamat_lengkap') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Kontak Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-teal-500 to-teal-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg mr-3">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Kontak</h2>
                    </div>
                    
                    <div class="group">
                        <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-teal-600 transition duration-300">
                            <i class="fab fa-whatsapp mr-1 text-teal-500"></i> Nomor WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}" 
                               placeholder="Contoh: +628123456789"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition duration-300"
                               required>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle"></i> Pastikan nomor WhatsApp Wajib di awali dengan +62xxxxxx
                        </p>
                    </div>
                </div>

                <!-- Upload Dokumen Section -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-6 border-t-4 border-gradient-to-r from-pink-500 to-pink-600">
                    <div class="flex items-center mb-6">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg mr-3">
                            <i class="fas fa-file-upload"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Upload Dokumen</h2>
                    </div>
                    
                    <!-- Dokumen Wajib -->
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                        <h3 class="font-semibold text-red-800 mb-3">
                            <i class="fas fa-asterisk text-xs"></i> Dokumen Wajib
                        </h3>
                        <div class="group">
                            <label class="block text-gray-700 text-sm font-semibold mb-2 group-hover:text-pink-600 transition duration-300">
                                <i class="fas fa-receipt mr-1 text-pink-500"></i> Bukti Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="bukti_pembayaran" 
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100"
                                       required>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, PDF (Max: 2MB)</p>
                        </div>
                    </div>

                    <!-- Dokumen Opsional -->
                    <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-3">
                            <i class="fas fa-info-circle"></i> Dokumen Opsional (Tidak Wajib)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="group">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">
                                    <i class="fas fa-certificate mr-1 text-blue-500"></i> Ijazah
                                </label>
                                <input type="file" name="ijazah" 
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div class="group">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">
                                    <i class="fas fa-file-alt mr-1 text-blue-500"></i> Surat Keterangan Lulus
                                </label>
                                <input type="file" name="surat_keterangan_lulus" 
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div class="group">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">
                                    <i class="fas fa-baby mr-1 text-blue-500"></i> Akta Kelahiran
                                </label>
                                <input type="file" name="akta_kelahiran" 
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div class="group">
                                <label class="block text-gray-700 text-sm font-semibold mb-2">
                                    <i class="fas fa-id-card mr-1 text-blue-500"></i> Kartu Keluarga
                                </label>
                                <input type="file" name="kartu_keluarga" 
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">
                            <i class="fas fa-info-circle"></i> Format semua dokumen: JPG, PNG, PDF (Max: 2MB per file)
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-300 ease-in-out bg-gradient-to-r from-green-600 to-green-700 rounded-full hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Submit Pendaftaran
                        <span class="absolute top-0 right-0 -mt-2 -mr-2">
                            <span class="animate-ping absolute inline-flex h-4 w-4 rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-yellow-500"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-gradient-to-r {
        border-image: linear-gradient(to right, var(--tw-gradient-from), var(--tw-gradient-to)) 1;
    }
</style>
@endpush
@endsection