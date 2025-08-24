@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-6xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Profile Saya</h1>
        <p class="text-gray-600">Kelola informasi profile Anda</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center">
                    <!-- Avatar -->
                    <div class="mb-4">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" 
                                 alt="Avatar" 
                                 class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-blue-500">
                        @else
                            <div class="w-32 h-32 rounded-full mx-auto bg-blue-500 flex items-center justify-center text-white text-4xl font-bold">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Name & Role -->
                    <h3 class="text-xl font-bold text-gray-800">{{ $admin->name }}</h3>
                    <p class="text-gray-600">{{ $admin->email }}</p>
                    
                    <!-- Role Badge -->
                    <div class="mt-3">
                        @if($admin->role == 'super_admin')
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                                Super Admin
                            </span>
                        @elseif($admin->role == 'admin')
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                Admin
                            </span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">
                                {{ ucfirst($admin->role) }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ $admin->created_at ? $admin->created_at->diffInDays(now()) : 0 }}
                                </p>
                                <p class="text-xs text-gray-600">Hari Bergabung</p>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-green-600">
                                    @if($admin->last_login)
                                        {{ $admin->last_login->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </p>
                                <p class="text-xs text-gray-600">Login Terakhir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Form -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-edit text-blue-500 mr-2"></i>
                    Informasi Profile
                </h3>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                No. Telepon
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                                   placeholder="+62812xxxxx">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Foto Profile
                            </label>
                            <input type="file" name="avatar" accept="image/*"
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('avatar') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Max: 2MB (JPG, PNG)</p>
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lock text-yellow-500 mr-2"></i>
                    Ubah Password
                </h3>
                
                <form action="{{ route('admin.profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" 
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                               required>
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                   required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Password minimal 8 karakter. Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan yang lebih baik.
                        </p>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">
                            <i class="fas fa-key mr-2"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview avatar before upload
document.querySelector('input[name="avatar"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if needed
            console.log('Image selected:', file.name);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush