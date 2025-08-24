<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $beritas = $query->orderBy('created_at', 'desc')->paginate(10);

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
            'slug' => 'nullable|string|max:255|unique:beritas',
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'kategori' => 'nullable|in:pengumuman,kegiatan,prestasi,artikel',
            'is_featured' => 'nullable|boolean',
            'is_highlighted' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        // Handle checkbox values (make sure they're boolean)
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_highlighted'] = $request->has('is_highlighted') ? true : false;

        // Set published_at if status is published and not provided
        if ($validated['status'] == 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Handle action buttons
        if ($request->action == 'draft') {
            $validated['status'] = 'draft';
        } elseif ($request->action == 'publish') {
            $validated['status'] = 'published';
            if (empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        }

        // If highlighted, remove highlight from other beritas
        if (isset($validated['is_highlighted']) && $validated['is_highlighted']) {
            Berita::where('is_highlighted', true)->update(['is_highlighted' => false]);
        }

        Berita::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'kategori' => 'nullable|in:pengumuman,kegiatan,prestasi,artikel',
            'is_featured' => 'nullable|boolean',
            'is_highlighted' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            $validated['image'] = $request->file('image')->store('berita', 'public');
        }

        // Handle checkbox values (make sure they're boolean)
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_highlighted'] = $request->has('is_highlighted') ? true : false;

        // Handle action buttons
        if ($request->action == 'publish') {
            $validated['status'] = 'published';
            if (empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        }

        // Set published_at if status is published and not provided
        if ($validated['status'] == 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // If highlighted, remove highlight from other beritas
        if (isset($validated['is_highlighted']) && $validated['is_highlighted']) {
            Berita::where('id', '!=', $id)
                  ->where('is_highlighted', true)
                  ->update(['is_highlighted' => false]);
        }

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
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
            ->with('success', 'Berita berhasil dihapus!');
    }

    // Quick toggle highlight via AJAX
    public function toggleHighlight($id)
    {
        $berita = Berita::findOrFail($id);
        
        if (!$berita->is_highlighted) {
            // Remove highlight from all other beritas
            Berita::where('is_highlighted', true)->update(['is_highlighted' => false]);
            
            // Set this berita as highlighted
            $berita->update(['is_highlighted' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dijadikan highlight',
                'is_highlighted' => true
            ]);
        } else {
            // Remove highlight
            $berita->update(['is_highlighted' => false]);
            
            return response()->json([
                'success' => true,
                'message' => 'Highlight berhasil dihapus',
                'is_highlighted' => false
            ]);
        }
    }
}