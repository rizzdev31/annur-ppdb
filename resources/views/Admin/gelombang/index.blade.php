@extends('layouts.admin')

@section('title', 'Kelola Gelombang')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Gelombang Pendaftaran</h1>
            <p class="text-gray-600">Manage gelombang pendaftaran PPDB</p>
        </div>
        <a href="{{ route('admin.gelombang.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Tambah Gelombang
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Gelombang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun Ajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuota</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pendaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Token</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($gelombangs as $gel)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $gel->nama_gelombang }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $gel->tahunAjaran->tahun ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $gel->tanggal_mulai->format('d M Y') }} - {{ $gel->tanggal_selesai->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $gel->kuota }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="font-semibold">{{ $gel->pendaftarans_count ?? 0 }}</span> / {{ $gel->kuota }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $gel->tokens_count ?? 0 }} token</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($gel->is_active)
                                @if($gel->tanggal_mulai <= now() && $gel->tanggal_selesai >= now())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Berjalan
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Aktif
                                    </span>
                                @endif
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.gelombang.edit', $gel->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.gelombang.destroy', $gel->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            Belum ada gelombang pendaftaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($gelombangs->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $gelombangs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection