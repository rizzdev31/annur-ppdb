<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JenjangPendidikanController extends Controller
{
    public function index()
    {
        $jenjangs = JenjangPendidikan::orderBy('urutan')->paginate(10);
        return view('admin.jenjang.index', compact('jenjangs'));
    }

    public function create()
    {
        return view('admin.jenjang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'durasi' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('jenjang', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $request->urutan ?? 0;

        JenjangPendidikan::create($validated);

        return redirect()->route('admin.jenjang.index')
            ->with('success', 'Jenjang pendidikan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenjang = JenjangPendidikan::findOrFail($id);
        return view('admin.jenjang.edit', compact('jenjang'));
    }

    public function update(Request $request, $id)
    {
        $jenjang = JenjangPendidikan::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'durasi' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($jenjang->foto) {
                Storage::disk('public')->delete($jenjang->foto);
            }
            $validated['foto'] = $request->file('foto')->store('jenjang', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $jenjang->update($validated);

        return redirect()->route('admin.jenjang.index')
            ->with('success', 'Jenjang pendidikan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenjang = JenjangPendidikan::findOrFail($id);
        
        if ($jenjang->foto) {
            Storage::disk('public')->delete($jenjang->foto);
        }
        
        $jenjang->delete();

        return redirect()->route('admin.jenjang.index')
            ->with('success', 'Jenjang pendidikan berhasil dihapus');
    }
}