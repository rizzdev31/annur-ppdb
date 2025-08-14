@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Akun</h1>
        <p class="text-gray-600">Dashboard management akun Admin dan Client</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Admin -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-xl border border-blue-200 p-6 text-black flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-900 text-sm font-semibold">Total Admin</p>
                    <p class="text-4xl font-extrabold mt-2 text-black">{{ $stats['total_admins'] }}</p>
                </div>
                <div class="bg-white/30 rounded-full p-4 flex items-center justify-center">
                    <i class="fas fa-user-shield text-3xl text-blue-700"></i>
                </div>
            </div>
            <div class="mt-6">
                <span class="text-sm font-medium flex items-center gap-2 text-black">
                    <i class="fas fa-check-circle text-blue-700"></i>
                    {{ $stats['active_admins'] }} Aktif
                </span>
            </div>
        </div>

        <!-- Total Client -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-xl border border-green-200 p-6 text-black flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-900 text-sm font-semibold">Total Client</p>
                    <p class="text-4xl font-extrabold mt-2 text-black">{{ $stats['total_clients'] }}</p>
                </div>
                <div class="bg-white/30 rounded-full p-4 flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-green-700"></i>
                </div>
            </div>
            <div class="mt-6">
                <span class="text-sm font-medium flex items-center gap-2 text-black">
                    <i class="fas fa-user-plus text-green-700"></i>
                    +{{ $stats['clients_today'] }} Hari ini
                </span>
            </div>
        </div>

        <!-- Admin by Role -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col justify-between">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Admin by Role</h3>
            <div class="space-y-2">
                @foreach($adminsByRole as $role)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $role->role)) }}</span>
                    <span class="font-bold text-gray-800">{{ $role->total }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Client by Status -->
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col justify-between">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Client by Status</h3>
            <div class="space-y-2">
                @foreach($clientsByStatus as $status)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ ucfirst($status->status) }}</span>
                    <span class="font-bold text-gray-800">{{ $status->total }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Admin Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-user-shield text-blue-500 mr-2"></i> Admin Management
            </h3>
            <div class="space-y-3">
                <a href="{{ route('admin.accounts.admin.index') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex items-center">
                        <i class="fas fa-list text-gray-600 mr-3"></i>
                        Lihat Semua Admin
                    </span>
                    <i class="fas fa-arrow-right text-gray-400"></i>
                </a>
                <a href="{{ route('admin.accounts.admin.create') }}" 
                   class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <span class="flex items-center">
                        <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                        Tambah Admin Baru
                    </span>
                    <i class="fas fa-arrow-right text-blue-400"></i>
                </a>
            </div>
        </div>

        <!-- Client Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-users text-green-500 mr-2"></i> Client Management
            </h3>
            <div class="space-y-3">
                <a href="{{ route('admin.accounts.client.index') }}" 
                   class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span class="flex items-center">
                        <i class="fas fa-list text-gray-600 mr-3"></i>
                        Lihat Semua Client
                    </span>
                    <i class="fas fa-arrow-right text-gray-400"></i>
                </a>
                <a href="{{ route('admin.accounts.logs') }}" 
                   class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <span class="flex items-center">
                        <i class="fas fa-history text-green-600 mr-3"></i>
                        Activity Logs
                    </span>
                    <i class="fas fa-arrow-right text-green-400"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Recent Logins -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-clock text-orange-500 mr-2"></i> Aktivitas Terbaru
            </h3>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @foreach($stats['recent_activities'] as $activity)
                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0">
                        @if($activity->user_type == 'admin')
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-shield text-blue-600 text-sm"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-600 text-sm"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">{{ $activity->user_name }}</p>
                        <p class="text-xs text-gray-600">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            <i class="far fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Admin Logins -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-sign-in-alt text-purple-500 mr-2"></i> Login Admin Terbaru
            </h3>
            <div class="space-y-3">
                @foreach($recentLogins as $admin)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $admin->name }}</p>
                            <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-600">{{ $admin->last_login ? Carbon\Carbon::parse($admin->last_login)->diffForHumans() : 'Never' }}</p>
                        @if($admin->last_login_ip)
                            <p class="text-xs text-gray-400">IP: {{ $admin->last_login_ip }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection