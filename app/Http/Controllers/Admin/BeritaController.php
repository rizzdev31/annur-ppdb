<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        $beritas = $query->latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:beritas,slug',
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'kategori' => 'nullable|string|max:50',
            'author' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255',
            'published_at' => 'nullable|date', // FIX: Changed from datetime to date
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Set is_featured
        $validated['is_featured'] = $request->has('is_featured');
        
        // Handle publish action
        if ($request->action === 'publish' || $validated['status'] === 'published') {
            $validated['status'] = 'published';
            if (empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        } else {
            $validated['status'] = 'draft';
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:beritas,slug,' . $id,
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'kategori' => 'nullable|string|max:50',
            'author' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255',
            'published_at' => 'nullable|date', // FIX: Changed from datetime to date
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Set is_featured
        $validated['is_featured'] = $request->has('is_featured');
        
        // Handle publish action
        if ($request->action === 'publish') {
            $validated['status'] = 'published';
            if (empty($validated['published_at']) && !$berita->published_at) {
                $validated['published_at'] = now();
            }
        }
        
        // Set published_at if status changed to published
        if ($validated['status'] === 'published' && !$berita->published_at) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Delete image if exists
        if ($berita->image) {
            Storage::disk('public')->delete($berita->image);
        }
        
        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus');
    }
    
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.show', compact('berita'));
    }
}
