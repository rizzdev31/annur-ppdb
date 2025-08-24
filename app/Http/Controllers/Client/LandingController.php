<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Program;
use App\Models\Berita;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\Ekstrakurikuler;
use App\Models\TahapanPendaftaran;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display the landing page
     */
    public function index()
    {
        // Get active data from database
        $fasilitas = Fasilitas::where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $programs = Program::where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $ekstrakurikulers = Ekstrakurikuler::where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $tahapans = TahapanPendaftaran::where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        $jenjangs = JenjangPendidikan::where('is_active', true)
            ->orderBy('urutan')
            ->get();
            
        // Get highlighted berita for hero section
        $highlightedBerita = Berita::published()
            ->where('is_highlighted', true)
            ->first();
            
        // Get published beritas (exclude highlighted from list)
        $beritas = Berita::published()
            ->where('is_highlighted', false)
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();
            
        // Get active tahun ajaran
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        
        // Get active gelombang
        $gelombangAktif = Gelombang::where('is_active', true)
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->withCount('pendaftarans')
            ->first();
            
        if ($gelombangAktif) {
            $gelombangAktif->sisa_kuota = $gelombangAktif->kuota - $gelombangAktif->pendaftarans_count;
        }
        
        // Check if user is logged in
        $isLoggedIn = Auth::guard('pendaftaran')->check();
        $user = null;
        
        if ($isLoggedIn) {
            $user = Auth::guard('pendaftaran')->user();
        }
            
        // Pass all variables to view (INCLUDING highlightedBerita!)
        return view('client.landing', compact(
            'fasilitas', 
            'programs',
            'ekstrakurikulers',
            'tahapans',
            'jenjangs',
            'beritas',
            'highlightedBerita',  // <-- IMPORTANT: This was missing!
            'tahunAjaranAktif',
            'gelombangAktif',
            'isLoggedIn',
            'user'
        ));
    }

    /**
     * Display the berita index page
     */
    public function beritaIndex(Request $request)
    {
        $query = Berita::published();
            
        // Search functionality
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        // Paginate results
        $beritas = $query->orderBy('published_at', 'desc')
            ->paginate(9);
            
        return view('client.berita.index', compact('beritas'));
    }

    /**
     * Display single berita
     */
    public function beritaShow($slug)
    {
        // Find berita by slug
        $berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
            
        // Increment views counter
        $berita->incrementViews();
        
        // Get related beritas (same category if exists)
        $beritaTerkait = Berita::published()
            ->where('id', '!=', $berita->id)
            ->when($berita->kategori, function($query) use ($berita) {
                return $query->where('kategori', $berita->kategori);
            })
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        return view('client.berita.show', compact('berita', 'beritaTerkait'));
    }
}