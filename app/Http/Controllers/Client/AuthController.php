<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('pendaftaran')->check()) {
            return redirect()->route('santri.dashboard');
        }
        
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('pendaftaran')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('santri.dashboard'));
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('pendaftaran')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('santri.login')
            ->with('success', 'Anda berhasil logout.');
    }
}