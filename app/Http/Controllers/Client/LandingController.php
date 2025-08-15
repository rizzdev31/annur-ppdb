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
            
        // Get published beritas with new structure
        $beritas = Berita::published()
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();
            
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        
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
            
        return view('client.landing', compact(
            'fasilitas', 
            'programs',
            'ekstrakurikulers',
            'tahapans',
            'jenjangs',
            'beritas',
            'tahunAjaranAktif',
            'gelombangAktif',
            'isLoggedIn',
            'user'
        ));
    }

    public function beritaIndex(Request $request)
    {
        $query = Berita::published();
            
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        $beritas = $query->orderBy('published_at', 'desc')
            ->paginate(9);
            
        return view('client.berita.index', compact('beritas'));
    }

    public function beritaShow($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
            
        // Increment views
        $berita->incrementViews();
        
        // Get related beritas
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