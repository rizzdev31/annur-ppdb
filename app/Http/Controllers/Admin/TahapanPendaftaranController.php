<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahapanPendaftaran;
use Illuminate\Http\Request;

class TahapanPendaftaranController extends Controller
{
    public function index()
    {
        $tahapans = TahapanPendaftaran::orderBy('urutan')->paginate(10);
        return view('admin.tahapan.index', compact('tahapans'));
    }

    public function create()
    {
        return view('admin.tahapan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $request->urutan ?? 0;

        TahapanPendaftaran::create($validated);

        return redirect()->route('admin.tahapan.index')
            ->with('success', 'Tahapan pendaftaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tahapan = TahapanPendaftaran::findOrFail($id);
        return view('admin.tahapan.edit', compact('tahapan'));
    }

    public function update(Request $request, $id)
    {
        $tahapan = TahapanPendaftaran::findOrFail($id);
        
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $tahapan->update($validated);

        return redirect()->route('admin.tahapan.index')
            ->with('success', 'Tahapan pendaftaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tahapan = TahapanPendaftaran::findOrFail($id);
        $tahapan->delete();

        return redirect()->route('admin.tahapan.index')
            ->with('success', 'Tahapan pendaftaran berhasil dihapus');
    }
}