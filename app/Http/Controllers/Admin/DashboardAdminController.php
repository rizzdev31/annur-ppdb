<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Statistik Pendaftaran
        $totalPendaftar = Pendaftaran::count();
        $pendaftarPending = Pendaftaran::where('status', 'pending')->count();
        $pendaftarDiterima = Pendaftaran::where('status', 'diterima')->count();
        $pendaftarDitolak = Pendaftaran::where('status', 'ditolak')->count();
        
        // Pendaftar Terbaru
        $pendaftarTerbaru = Pendaftaran::with(['gelombang', 'tahunAjaran'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Chart Data - Pendaftar per Bulan
        $chartData = Pendaftaran::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();
        
        // Fill missing months with 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $chartData[$i] ?? 0;
        }
        
        // Gelombang Aktif
        $gelombangAktif = Gelombang::where('is_active', true)->first();
        
        // Tahun Ajaran Aktif
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        
        return view('admin.dashboard', compact(
            'totalPendaftar',
            'pendaftarPending',
            'pendaftarDiterima',
            'pendaftarDitolak',
            'pendaftarTerbaru',
            'monthlyData',
            'gelombangAktif',
            'tahunAjaranAktif'
        ));
    }
}