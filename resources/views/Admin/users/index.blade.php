@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen User Pendaftar</h1>
        <p class="text-gray-600">Kelola semua data user pendaftar PPDB</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, NISN, atau WhatsApp..."
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="seleksi" {{ request('status') == 'seleksi' ? 'selected' : '' }}>Seleksi</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <select name="jenjang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">Semua Jenjang</option>
                    <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NISN
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama Lengkap
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jenjang
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        WhatsApp
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kredensial
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->nisn }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->nama_lengkap }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                            {{ $user->jenjang }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->no_whatsapp }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($user->status == 'seleksi')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Seleksi
                            </span>
                        @elseif($user->status == 'diterima')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Diterima
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_credentials_sent)
                            <span class="text-green-600">
                                <i class="fas fa-check-circle"></i> Terkirim
                            </span>
                        @else
                            <button onclick="sendCredentials({{ $user->id }})" 
                                    class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.users.show', $user->id) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="deleteUser({{ $user->id }})" 
                                class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendCredentials(userId) {
    if (confirm('Kirim kredensial login ke user ini via WhatsApp?')) {
        fetch(`/admin/users/${userId}/send-credentials`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Kredensial berhasil dikirim!\n\nUsername: ${data.data.nisn}\nPassword: ${data.data.password}`);
                location.reload();
            }
        });
    }
}

function deleteUser(userId) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(() => {
            location.reload();
        });
    }
}
</script>
@endpush
@endsection