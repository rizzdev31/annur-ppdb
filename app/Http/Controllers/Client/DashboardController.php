<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pendaftaran = Auth::guard('pendaftaran')->user();
        $pendaftaran->load(['gelombang', 'tahunAjaran']);
        
        return view('client.dashboard', compact('pendaftaran'));
    }

    public function profile()
    {
        $pendaftaran = Auth::guard('pendaftaran')->user();
        $pendaftaran->load(['gelombang', 'tahunAjaran']);
        
        return view('client.profile', compact('pendaftaran'));
    }
}