<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Program;
use App\Models\Berita;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use Illuminate\Http\Request;

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
            
        $beritas = Berita::where('is_published', true)
            ->whereNotNull('published_at')
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
            
        return view('client.landing', compact(
            'fasilitas', 
            'programs', 
            'beritas',
            'tahunAjaranAktif',
            'gelombangAktif'
        ));
    }

    public function beritaIndex(Request $request)
    {
        $query = Berita::where('is_published', true)
            ->whereNotNull('published_at');
            
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('konten', 'like', '%' . $request->search . '%');
            });
        }
        
        $beritas = $query->orderBy('published_at', 'desc')
            ->paginate(9);
            
        return view('client.berita.index', compact('beritas'));
    }

    public function beritaShow($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
            
        $beritaTerkait = Berita::where('is_published', true)
            ->where('id', '!=', $berita->id)
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        return view('client.berita.show', compact('berita', 'beritaTerkait'));
    }
}