<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::orderBy('urutan')->paginate(10);
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $request->urutan ?? 0;

        Ekstrakurikuler::create($validated);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function update(Request $request, $id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($ekstrakurikuler->foto) {
                Storage::disk('public')->delete($ekstrakurikuler->foto);
            }
            $validated['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $ekstrakurikuler->update($validated);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        
        if ($ekstrakurikuler->foto) {
            Storage::disk('public')->delete($ekstrakurikuler->foto);
        }
        
        $ekstrakurikuler->delete();

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}