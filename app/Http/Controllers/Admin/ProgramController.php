<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('urutan')->paginate(10);
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program.create');
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
            $validated['foto'] = $request->file('foto')->store('program', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $request->urutan ?? 0;

        Program::create($validated);

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil ditambahkan');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto')) {
            if ($program->foto) {
                Storage::disk('public')->delete($program->foto);
            }
            $validated['foto'] = $request->file('foto')->store('program', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil diperbarui');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        if ($program->foto) {
            Storage::disk('public')->delete($program->foto);
        }
        
        $program->delete();

        return redirect()->route('admin.program.index')
            ->with('success', 'Program berhasil dihapus');
    }
}