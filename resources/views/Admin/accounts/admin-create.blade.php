@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 max-w-3xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Admin Baru</h1>
        <p class="text-gray-600">Buat akun administrator baru</p>
    </div>

    <form action="{{ route('admin.accounts.admin.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Phone
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Role</option>
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
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
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                       required>
            </div>

            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-gray-700">Aktifkan akun ini</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('admin.accounts.admin.index') }}" 
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection