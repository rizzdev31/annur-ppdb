@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Client (Pendaftar)</h1>
            <p class="text-gray-600">Daftar semua akun client/santri dari database pendaftaran</p>
        </div>
        <div class="space-x-2 flex items-center">
            <a href="{{ route('admin.accounts.dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-150">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            
            <!-- Dropdown Export -->
            <div class="relative inline-block">
                <button type="button" 
                        onclick="toggleExportMenu()"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-150 flex items-center">
                    <i class="fas fa-download mr-2"></i> Export 
                    <i class="fas fa-caret-down ml-1"></i>
                </button>
                
                <div id="exportMenu" 
                     class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <a href="#" onclick="exportToExcel()" 
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-t-lg">
                        <i class="fas fa-file-excel text-green-600 mr-2"></i> Export Excel
                    </a>
                    <a href="#" onclick="exportToCSV()" 
                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-b-lg">
                        <i class="fas fa-file-csv text-blue-600 mr-2"></i> Export CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow border flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Client</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->total() }}</p>
            </div>
            <i class="fas fa-users text-3xl text-blue-500"></i>
        </div>
        <div class="bg-white rounded-lg p-4 shadow border flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Diterima</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->where('status', 'diterima')->count() }}</p>
            </div>
            <i class="fas fa-check-circle text-3xl text-green-500"></i>
        </div>
        <div class="bg-white rounded-lg p-4 shadow border flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->where('status', 'pending')->count() }}</p>
            </div>
            <i class="fas fa-clock text-3xl text-yellow-500"></i>
        </div>
        <div class="bg-white rounded-lg p-4 shadow border flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Ditolak</p>
                <p class="text-2xl font-bold text-gray-900">{{ $clients->where('status', 'ditolak')->count() }}</p>
            </div>
            <i class="fas fa-times-circle text-3xl text-red-500"></i>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.accounts.client.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, NISN, WhatsApp..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="seleksi" {{ request('status') == 'seleksi' ? 'selected' : '' }}>Seleksi</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <select name="jenjang" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Jenjang</option>
                    <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            NISN
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Password
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Nama Lengkap
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Jenjang
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            WhatsApp
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Gelombang
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clients as $index => $client)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $clients->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $client->nisn }}</div>
                                    <button onclick="copyToClipboard('{{ $client->nisn }}')" 
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div>
                                    <div class="font-mono text-sm" id="password-{{ $client->id }}">
                                        @if($client->decrypted_password == 'Password sudah diganti')
                                            <span class="text-gray-500 italic">{{ $client->decrypted_password }}</span>
                                        @elseif($client->decrypted_password == 'Password tidak tersedia')
                                            <span class="text-red-500 italic">{{ $client->decrypted_password }}</span>
                                        @else
                                            <span class="password-hidden" data-password="{{ $client->decrypted_password }}">••••••••</span>
                                        @endif
                                    </div>
                                    @if($client->decrypted_password != 'Password sudah diganti' && $client->decrypted_password != 'Password tidak tersedia')
                                    <div class="flex space-x-1 mt-1">
                                        <button onclick="togglePassword('{{ $client->id }}', '{{ $client->decrypted_password }}')" 
                                                class="text-xs text-gray-600 hover:text-gray-800">
                                            <i class="fas fa-eye"></i> Show
                                        </button>
                                        <button onclick="copyToClipboard('{{ $client->decrypted_password }}')" 
                                                class="text-xs text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $client->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $client->tempat_lahir }}, {{ $client->tanggal_lahir->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $client->jenjang }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $client->no_whatsapp) }}" 
                               target="_blank"
                               class="text-green-600 hover:text-green-800">
                                <i class="fab fa-whatsapp"></i> {{ $client->no_whatsapp }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($client->status == 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> Pending
                                </span>
                            @elseif($client->status == 'seleksi')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-user-check mr-1"></i> Seleksi
                                </span>
                            @elseif($client->status == 'diterima')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Diterima
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $client->gelombang->nama_gelombang ?? '-' }}
                            <br>
                            <span class="text-xs text-gray-500">{{ $client->tahunAjaran->tahun ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-1">
                                <!-- Tombol View - Arahkan ke Manajemen User Show -->
                                <a href="{{ route('admin.users.show', $client->id) }}" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs"
                                title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <!-- Tombol Edit - Arahkan ke Manajemen User Edit -->
                                <a href="{{ route('admin.users.edit', $client->id) }}" 
                                class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs"
                                title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Tombol Reset Password - Tetap di sini -->
                                <button onclick="resetPassword({{ $client->id }})" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs"
                                        title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>
                                
                                <!-- Tombol Delete - Gunakan route manajemen user -->
                                <form action="{{ route('admin.users.destroy', $client->id) }}" 
                                    method="POST" 
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus client {{ $client->nama_lengkap }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-gray-300 text-5xl mb-3"></i>
                                <p class="text-gray-500 text-lg">Belum ada data client</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($clients->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $clients->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Reset Password -->
<div id="resetPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <i class="fas fa-key text-green-600"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Password Berhasil Direset!</h3>
            <div id="resetPasswordContent" class="mb-4"></div>
            <button onclick="closeResetModal()" 
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let passwordsVisible = {};

function togglePassword(clientId, password) {
    const passwordEl = document.querySelector(`#password-${clientId} span`);
    
    if (passwordsVisible[clientId]) {
        passwordEl.textContent = '••••••••';
        passwordsVisible[clientId] = false;
    } else {
        passwordEl.textContent = password;
        passwordsVisible[clientId] = true;
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast notification
        showToast('Berhasil disalin!');
    }, function(err) {
        console.error('Error copying text: ', err);
    });
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${message}`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function resetPassword(clientId) {
    if (confirm('Reset password untuk client ini?')) {
        fetch(`/admin/accounts/client/${clientId}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('resetPasswordContent').innerHTML = `
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-3">Password baru telah dibuat:</p>
                        <p class="font-mono font-bold text-xl text-red-600 mb-3">${data.password}</p>
                        <button onclick="copyToClipboard('${data.password}')" 
                                class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                            <i class="fas fa-copy"></i> Copy Password
                        </button>
                    </div>
                `;
                document.getElementById('resetPasswordModal').classList.remove('hidden');
                setTimeout(() => location.reload(), 5000);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error);
        });
    }
}

function closeResetModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
    location.reload();
}

function toggleExportMenu() {
    const menu = document.getElementById('exportMenu');
    menu.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const exportMenu = document.getElementById('exportMenu');
    const exportButton = event.target.closest('button');
    
    if (!exportButton && !event.target.closest('#exportMenu')) {
        exportMenu.classList.add('hidden');
    }
});

function exportToExcel() {
    const params = new URLSearchParams({
        search: '{{ request("search") }}',
        status: '{{ request("status") }}',
        jenjang: '{{ request("jenjang") }}'
    });
    
    window.location.href = '{{ route("admin.accounts.client.export") }}?' + params.toString();
}

function exportToCSV() {
    const params = new URLSearchParams({
        search: '{{ request("search") }}',
        status: '{{ request("status") }}',
        jenjang: '{{ request("jenjang") }}'
    });
    
    window.location.href = '{{ route("admin.accounts.client.export.csv") }}?' + params.toString();
}
</script>
@endpush
@endsection