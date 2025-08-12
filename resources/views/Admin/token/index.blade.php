@extends('layouts.admin')

@section('title', 'Kelola Token')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Token PPDB</h1>
            <p class="text-gray-600">Generate dan manage token untuk pendaftaran</p>
        </div>
        <button onclick="openGenerateModal()" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Generate Token
        </button>
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

    @if(session('generated_tokens'))
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
            <h4 class="font-bold mb-2">Token Berhasil Digenerate:</h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2">
                @foreach(session('generated_tokens') as $token)
                    <span class="font-mono bg-white px-2 py-1 rounded border">{{ $token }}</span>
                @endforeach
            </div>
            <p class="text-sm mt-2">Silakan copy dan bagikan token kepada calon pendaftar</p>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $totalTokens = isset($tokens) ? $tokens->total() : 0;
            $unusedTokens = isset($tokens) ? collect($tokens->items())->where('is_used', false)->count() : 0;
            $usedTokens = isset($tokens) ? collect($tokens->items())->where('is_used', true)->count() : 0;
        @endphp
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Token</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalTokens }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Belum Digunakan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $unusedTokens }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Sudah Digunakan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $usedTokens }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <button onclick="exportTokens()" class="w-full flex items-center hover:bg-gray-50 rounded p-2">
                <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4 text-left">
                    <p class="text-sm text-gray-500">Export</p>
                    <p class="text-lg font-bold text-gray-800">CSV</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4">
            <form method="GET" action="{{ route('admin.token.index') }}" class="flex flex-wrap gap-4">
                <select name="gelombang_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Gelombang</option>
                    @if(isset($gelombangs))
                        @foreach($gelombangs as $gel)
                            <option value="{{ $gel->id }}" {{ request('gelombang_id') == $gel->id ? 'selected' : '' }}>
                                {{ $gel->nama_gelombang }} - {{ $gel->tahunAjaran->tahun ?? '' }}
                            </option>
                        @endforeach
                    @endif
                </select>

                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="unused" {{ request('status') == 'unused' ? 'selected' : '' }}>Belum Digunakan</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Sudah Digunakan</option>
                </select>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Filter
                </button>

                <a href="{{ route('admin.token.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gelombang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Digunakan Pada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Buat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($tokens) && count($tokens) > 0)
                        @foreach($tokens as $token)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $loop->iteration + ($tokens->currentPage() - 1) * $tokens->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-lg font-bold {{ $token->is_used ? 'text-gray-400' : 'text-blue-600' }}">
                                    {{ $token->token }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $token->gelombang->nama_gelombang ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($token->is_used)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Sudah Digunakan
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $token->used_at ? $token->used_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $token->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$token->is_used)
                                    <button onclick="copyToken('{{ $token->token }}')" 
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                        Copy
                                    </button>
                                    <form action="{{ route('admin.token.destroy', $token->id) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus token ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                <p class="mt-2">Belum ada token</p>
                                <button onclick="openGenerateModal()" class="mt-3 text-blue-600 hover:text-blue-800">
                                    Generate token pertama
                                </button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(isset($tokens) && $tokens->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $tokens->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Generate Token -->
<div id="generateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Generate Token PPDB</h3>
        <form action="{{ route('admin.token.generate') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Gelombang <span class="text-red-500">*</span></label>
                <select name="gelombang_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="">-- Pilih Gelombang --</option>
                    @if(isset($gelombangs))
                        @foreach($gelombangs as $gel)
                            <option value="{{ $gel->id }}">
                                {{ $gel->nama_gelombang }} - {{ $gel->tahunAjaran->tahun ?? '' }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Token <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" min="1" max="100" value="10" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                <p class="text-gray-500 text-sm mt-1">Maksimal 100 token per generate</p>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeGenerateModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Generate
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openGenerateModal() {
    document.getElementById('generateModal').classList.remove('hidden');
}

function closeGenerateModal() {
    document.getElementById('generateModal').classList.add('hidden');
}

function copyToken(token) {
    navigator.clipboard.writeText(token).then(function() {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
        toast.textContent = 'Token ' + token + ' berhasil dicopy!';
        document.body.appendChild(toast);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}

function exportTokens() {
    window.location.href = '{{ route("admin.token.export") }}';
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target == document.getElementById('generateModal')) {
        closeGenerateModal();
    }
}
</script>
@endpush
@endsection