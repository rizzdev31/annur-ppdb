<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class GelombangController extends Controller
{
    public function index()
    {
        $gelombangs = Gelombang::with('tahunAjaran')
            ->withCount(['pendaftarans', 'tokens'])
            ->latest()
            ->paginate(10);
        return view('admin.gelombang.index', compact('gelombangs'));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('admin.gelombang.create', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama_gelombang' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_active']) {
            Gelombang::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        Gelombang::create($validated);

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $gelombang = Gelombang::findOrFail($id);
        $tahunAjarans = TahunAjaran::all();
        return view('admin.gelombang.edit', compact('gelombang', 'tahunAjarans'));
    }

    public function update(Request $request, $id)
    {
        $gelombang = Gelombang::findOrFail($id);
        
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'nama_gelombang' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_active']) {
            Gelombang::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
                ->where('is_active', true)
                ->where('id', '!=', $id)
                ->update(['is_active' => false]);
        }

        $gelombang->update($validated);

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $gelombang = Gelombang::findOrFail($id);
        
        if ($gelombang->pendaftarans()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar');
        }
        
        $gelombang->delete();

        return redirect()->route('admin.gelombang.index')
            ->with('success', 'Gelombang berhasil dihapus');
    }
}