@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Admin</h1>
            <p class="text-gray-600">Daftar semua akun administrator</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.accounts.dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.accounts.admin.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus"></i> Tambah Admin
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.accounts.admin.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, email, phone..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <select name="role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Semua Role</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                </select>
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Admin
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Phone
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Login
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($admins as $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($admin->avatar)
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $admin->avatar) }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $admin->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($admin->role == 'super_admin')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Super Admin
                                </span>
                            @elseif($admin->role == 'admin')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Admin
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Operator
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $admin->phone ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           class="sr-only peer"
                                           {{ $admin->is_active ? 'checked' : '' }}
                                           onchange="toggleAdminStatus({{ $admin->id }})"
                                           {{ $admin->role == 'super_admin' || $admin->id == auth()->id() ? 'disabled' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                                <span class="ml-2 text-sm text-gray-600" id="status-text-{{ $admin->id }}">
                                    {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($admin->last_login)
                                {{ Carbon\Carbon::parse($admin->last_login)->diffForHumans() }}
                                <br>
                                <span class="text-xs">IP: {{ $admin->last_login_ip }}</span>
                            @else
                                Never
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.accounts.admin.show', $admin->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.accounts.admin.edit', $admin->id) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($admin->role != 'super_admin' && $admin->id != auth()->id())
                                <form action="{{ route('admin.accounts.admin.destroy', $admin->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus admin {{ $admin->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($admins->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleAdminStatus(adminId) {
    fetch(`/admin/accounts/admin/${adminId}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const statusText = document.getElementById(`status-text-${adminId}`);
            statusText.textContent = data.is_active ? 'Aktif' : 'Nonaktif';
        } else {
            alert(data.message);
            location.reload();
        }
    });
}
</script>
@endpush
@endsection