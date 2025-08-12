@extends('layouts.client')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-800 p-6">
                    <h2 class="text-3xl font-bold text-white">Formulir Pendaftaran Santri Baru</h2>
                </div>

                <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <!-- Data Pribadi -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Data Pribadi Calon Santri</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">NISN <span class="text-red-500">*</span></label>
                                <input type="text" name="nisn" value="{{ old('nisn') }}" class="form-input @error('nisn') !border-red-500 @enderror" placeholder="Masukkan NISN">
                                @error('nisn')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="form-input @error('nama_lengkap') !border-red-500 @enderror" placeholder="Masukkan nama lengkap">
                                @error('nama_lengkap')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-input @error('tempat_lahir') !border-red-500 @enderror" placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-input @error('tanggal_lahir') !border-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                             <div>
                                <label class="form-label">Anak Ke- <span class="text-red-500">*</span></label>
                                <input type="number" name="anak_ke" value="{{ old('anak_ke') }}" class="form-input @error('anak_ke') !border-red-500 @enderror" placeholder="Contoh: 1">
                                @error('anak_ke')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">Jumlah Saudara <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" class="form-input @error('jumlah_saudara') !border-red-500 @enderror" placeholder="Contoh: 3">
                                @error('jumlah_saudara')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                             <div>
                                <label class="form-label">Asal Sekolah <span class="text-red-500">*</span></label>
                                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" class="form-input @error('asal_sekolah') !border-red-500 @enderror" placeholder="Contoh: SMPN 1 Jakarta">
                                @error('asal_sekolah')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label">No. WhatsApp Aktif <span class="text-red-500">*</span></label>
                                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}" class="form-input @error('no_whatsapp') !border-red-500 @enderror" placeholder="Contoh: 081234567890">
                                @error('no_whatsapp')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Data Orang Tua</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ayah -->
                            <div>
                                <label class="form-label">Nama Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="form-input @error('nama_ayah') !border-red-500 @enderror" placeholder="Nama lengkap ayah">
                                @error('nama_ayah')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="form-input @error('pekerjaan_ayah') !border-red-500 @enderror" placeholder="Contoh: Wiraswasta">
                                @error('pekerjaan_ayah')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Pendidikan Terakhir Ayah <span class="text-red-500">*</span></label>
                                <input type="text" name="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}" class="form-input @error('pendidikan_ayah') !border-red-500 @enderror" placeholder="Contoh: S1">
                                @error('pendidikan_ayah')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div></div> <!-- Spacer -->

                            <!-- Ibu -->
                             <div>
                                <label class="form-label">Nama Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="form-input @error('nama_ibu') !border-red-500 @enderror" placeholder="Nama lengkap ibu">
                                @error('nama_ibu')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" class="form-input @error('pekerjaan_ibu') !border-red-500 @enderror" placeholder="Contoh: Ibu Rumah Tangga">
                                @error('pekerjaan_ibu')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                             <div>
                                <label class="form-label">Pendidikan Terakhir Ibu <span class="text-red-500">*</span></label>
                                <input type="text" name="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}" class="form-input @error('pendidikan_ibu') !border-red-500 @enderror" placeholder="Contoh: SMA">
                                @error('pendidikan_ibu')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Alamat Lengkap</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="form-label">Provinsi <span class="text-red-500">*</span></label>
                                <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="form-input @error('provinsi') !border-red-500 @enderror" placeholder="Contoh: Jawa Barat">
                                @error('provinsi')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                <input type="text" name="kota" value="{{ old('kota') }}" class="form-input @error('kota') !border-red-500 @enderror" placeholder="Contoh: Bandung">
                                @error('kota')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                                <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="form-input @error('kecamatan') !border-red-500 @enderror" placeholder="Contoh: Coblong">
                                @error('kecamatan')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6">
                            <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat_lengkap" rows="3" class="form-input @error('alamat_lengkap') !border-red-500 @enderror" placeholder="Masukkan nama jalan, nomor rumah, RT/RW, kelurahan, dan kode pos">{{ old('alamat_lengkap') }}</textarea>
                            @error('alamat_lengkap')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Upload Berkas</h3>
                        <div>
                            <label class="form-label">Bukti Pembayaran <span class="text-red-500">*</span></label>
                            <input type="file" name="bukti_pembayaran" class="form-input @error('bukti_pembayaran') !border-red-500 @enderror">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                            @error('bukti_pembayaran')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('ppdb.token') }}" class="btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        transition: border-color 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2563EB;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }
    .form-error {
        color: #EF4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .btn-primary {
        background-color: #2563EB;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #1D4ED8;
    }
    .btn-secondary {
        background-color: #E5E7EB;
        color: #374151;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background-color: #D1D5DB;
    }
</style>
@endsection
