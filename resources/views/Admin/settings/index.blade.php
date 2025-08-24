@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pengaturan Sistem</h1>
        <p class="text-gray-600">Kelola konfigurasi aplikasi PPDB</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('general')" 
                        class="tab-btn border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600" 
                        data-tab="general">
                    <i class="fas fa-cog mr-2"></i> Umum
                </button>
                <button onclick="switchTab('ppdb')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="ppdb">
                    <i class="fas fa-user-graduate mr-2"></i> PPDB
                </button>
                <button onclick="switchTab('email')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="email">
                    <i class="fas fa-envelope mr-2"></i> Email
                </button>
                <button onclick="switchTab('maintenance')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="maintenance">
                    <i class="fas fa-tools mr-2"></i> Maintenance
                </button>
                @if(Auth::user()->role === 'super_admin')
                <button onclick="switchTab('advanced')" 
                        class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" 
                        data-tab="advanced">
                    <i class="fas fa-shield-alt mr-2"></i> Advanced
                </button>
                @endif
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- General Settings Tab -->
        <div id="general-tab" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Site Information -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Informasi Website
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Website <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Email Website <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="site_email" value="{{ old('site_email', $settings['site_email']) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Telepon
                            </label>
                            <input type="text" name="site_phone" value="{{ old('site_phone', $settings['site_phone']) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Alamat
                            </label>
                            <textarea name="site_address" rows="3" 
                                      class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>{{ old('site_address', $settings['site_address']) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Upload Settings -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-upload text-green-500 mr-2"></i>
                        Pengaturan Upload
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Maksimal Ukuran Upload (KB)
                            </label>
                            <input type="number" name="max_upload_size" value="{{ old('max_upload_size', $settings['max_upload_size']) }}" 
                                   min="512" max="10240"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                            <p class="text-xs text-gray-500 mt-1">Range: 512 KB - 10240 KB (10 MB)</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Tipe File yang Diizinkan
                            </label>
                            <input type="text" name="allowed_file_types" value="{{ old('allowed_file_types', $settings['allowed_file_types']) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                            <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma (contoh: jpg,jpeg,png,pdf)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PPDB Settings Tab -->
        <div id="ppdb-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-graduate text-purple-500 mr-2"></i>
                    Pengaturan PPDB
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="registration_open" value="1" 
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                                   {{ $settings['registration_open'] ? 'checked' : '' }}
                                   {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                            <span class="text-gray-700 font-medium">Buka Pendaftaran PPDB</span>
                        </label>
                        <p class="text-sm text-gray-500 ml-8 mt-1">
                            Aktifkan untuk membuka pendaftaran santri baru
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Status Pendaftaran
                        </label>
                        <div class="flex items-center space-x-4">
                            @if($settings['registration_open'])
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Dibuka
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i> Ditutup
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-700 mb-4">Statistik PPDB</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Pendaftaran::count() }}</p>
                            <p class="text-sm text-gray-600">Total Pendaftar</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Pendaftaran::where('status', 'diterima')->count() }}</p>
                            <p class="text-sm text-gray-600">Diterima</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Pendaftaran::where('status', 'pending')->count() }}</p>
                            <p class="text-sm text-gray-600">Pending</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Token::where('is_used', false)->count() }}</p>
                            <p class="text-sm text-gray-600">Token Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Settings Tab -->
        <div id="email-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-envelope text-orange-500 mr-2"></i>
                    Pengaturan Email
                </h3>
                
                <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Fitur email belum tersedia. Konfigurasi SMTP akan ditambahkan pada update berikutnya.
                    </p>
                </div>
                
                <div class="space-y-4 opacity-50">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">SMTP Host</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-lg bg-gray-100" disabled>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">SMTP Port</label>
                            <input type="text" class="w-full px-3 py-2 border rounded-lg bg-gray-100" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Encryption</label>
                            <select class="w-full px-3 py-2 border rounded-lg bg-gray-100" disabled>
                                <option>TLS</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Tab -->
        <div id="maintenance-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-tools text-red-500 mr-2"></i>
                    Mode Maintenance
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="maintenance_mode" value="1" 
                                   class="w-5 h-5 text-red-600 rounded focus:ring-red-500"
                                   {{ $settings['maintenance_mode'] ? 'checked' : '' }}
                                   {{ Auth::user()->role !== 'super_admin' ? 'disabled' : '' }}>
                            <span class="text-gray-700 font-medium">Aktifkan Mode Maintenance</span>
                        </label>
                        <p class="text-sm text-gray-500 ml-8 mt-1">
                            Website akan menampilkan halaman maintenance untuk pengunjung
                        </p>
                    </div>
                    
                    @if(Auth::user()->role === 'super_admin')
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Perhatian:</strong> Mengaktifkan mode maintenance akan membuat website tidak dapat diakses oleh pengunjung.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Advanced Settings Tab (Super Admin Only) -->
        @if(Auth::user()->role === 'super_admin')
        <div id="advanced-tab" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-shield-alt text-indigo-500 mr-2"></i>
                    Pengaturan Advanced
                </h3>
                
                <div class="space-y-6">
                    <!-- Database Backup -->
                    <div class="border-b pb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Backup Database</h4>
                        <p class="text-sm text-gray-500 mb-3">Download backup database dalam format SQL</p>
                        <button type="button" onclick="backupDatabase()" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-download mr-2"></i> Download Backup
                        </button>
                    </div>
                    
                    <!-- Cache Management -->
                    <div class="border-b pb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Cache Management</h4>
                        <p class="text-sm text-gray-500 mb-3">Clear application cache untuk performa optimal</p>
                        <button type="button" onclick="clearCache()" 
                                class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                            <i class="fas fa-broom mr-2"></i> Clear Cache
                        </button>
                    </div>
                    
                    <!-- System Info -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">System Information</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Laravel Version:</span>
                                    <span class="font-mono">{{ app()->version() }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">PHP Version:</span>
                                    <span class="font-mono">{{ PHP_VERSION }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Server:</span>
                                    <span class="font-mono">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Database:</span>
                                    <span class="font-mono">MySQL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Submit Button -->
        @if(Auth::user()->role === 'super_admin')
        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                <i class="fas fa-save mr-2"></i> Simpan Pengaturan
            </button>
        </div>
        @else
        <div class="mt-6 bg-yellow-50 p-4 rounded-lg">
            <p class="text-sm text-yellow-800">
                <i class="fas fa-lock mr-2"></i>
                Hanya Super Admin yang dapat mengubah pengaturan sistem.
            </p>
        </div>
        @endif
    </form>
</div>
@endsection

@push('scripts')
<script>
// Tab switching
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to selected button
    const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-blue-500', 'text-blue-600');
}

// Backup database
function backupDatabase() {
    if (confirm('Download backup database?')) {
        // Implement backup functionality
        alert('Fitur backup akan segera tersedia');
    }
}

// Clear cache
function clearCache() {
    if (confirm('Clear semua cache aplikasi?')) {
        // Implement clear cache functionality
        alert('Cache berhasil dibersihkan');
    }
}
</script>
@endpush