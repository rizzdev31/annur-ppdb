@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Profil</h1>
                    <p class="text-gray-600">Lengkapi dan perbarui data Anda</p>
                </div>
                <a href="{{ route('santri.dashboard') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Alert Incomplete Data -->
            @if(count($incompleteFields) > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg">
                <p class="text-yellow-800 font-medium">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Ada {{ count($incompleteFields) }} data yang belum lengkap
                </p>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('santri.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Data Diri -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-user text-blue-500 mr-2"></i> Data Diri
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                NISN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" value="{{ $pendaftaran->nisn }}" 
                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir->format('Y-m-d')) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Jenjang
                            </label>
                            <input type="text" value="{{ $pendaftaran->jenjang }}" 
                                   class="w-full px-3 py-2 border rounded-lg bg-gray-100"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Asal Sekolah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Anak Ke <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke', $pendaftaran->anak_ke) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   min="1" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Jumlah Saudara <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $pendaftaran->jumlah_saudara) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   min="0" required>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-users text-green-500 mr-2"></i> Data Orang Tua
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Pekerjaan Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Pekerjaan Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Pendidikan Ayah <span class="text-red-500">*</span>
                            </label>
                            <select name="pendidikan_ayah" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                                <option value="SD" {{ $pendaftaran->pendidikan_ayah == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ $pendaftaran->pendidikan_ayah == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ $pendaftaran->pendidikan_ayah == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D3" {{ $pendaftaran->pendidikan_ayah == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ $pendaftaran->pendidikan_ayah == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ $pendaftaran->pendidikan_ayah == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ $pendaftaran->pendidikan_ayah == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Pendidikan Ibu <span class="text-red-500">*</span>
                            </label>
                            <select name="pendidikan_ibu" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                                <option value="SD" {{ $pendaftaran->pendidikan_ibu == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ $pendaftaran->pendidikan_ibu == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ $pendaftaran->pendidikan_ibu == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="D3" {{ $pendaftaran->pendidikan_ibu == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ $pendaftaran->pendidikan_ibu == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ $pendaftaran->pendidikan_ibu == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ $pendaftaran->pendidikan_ibu == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Alamat & Kontak -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i> Alamat & Kontak
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="provinsi" value="{{ old('provinsi', $pendaftaran->provinsi) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kota" value="{{ old('kota', $pendaftaran->kota) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $pendaftaran->kecamatan) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat_lengkap" rows="3" 
                                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                      required>{{ old('alamat_lengkap', $pendaftaran->alamat_lengkap) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $pendaftaran->no_whatsapp) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-file-upload text-purple-500 mr-2"></i> Upload Dokumen (Opsional)
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            'ijazah' => 'Ijazah',
                            'surat_keterangan_lulus' => 'Surat Keterangan Lulus',
                            'akta_kelahiran' => 'Akta Kelahiran',
                            'kartu_keluarga' => 'Kartu Keluarga'
                        ] as $field => $label)
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">{{ $label }}</label>
                            @if($pendaftaran->$field)
                                <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded">
                                    <p class="text-sm text-green-700">
                                        <i class="fas fa-check-circle"></i> File sudah diupload
                                        <a href="{{ asset('uploads/' . $pendaftaran->$field) }}" target="_blank"
                                           class="text-blue-600 hover:underline ml-2">Lihat</a>
                                    </p>
                                </div>
                            @endif
                            <input type="file" name="{{ $field }}" 
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Max: 2MB)</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between">
                    <a href="{{ route('santri.dashboard') }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection