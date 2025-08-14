<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

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
            'nisn' => 'required|string',
            'password' => 'required|string'
        ]);

        // Attempt login dengan guard pendaftaran
        if (Auth::guard('pendaftaran')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::guard('pendaftaran')->user();
            
            // Log activity (optional - comment jika belum ada tabel activity_logs)
            if (\Schema::hasTable('activity_logs')) {
                ActivityLog::create([
                    'user_type' => 'client',
                    'user_id' => $user->id,
                    'action' => 'client_login',
                    'description' => "Client {$user->nama_lengkap} logged in",
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
            }
            
            return redirect()->intended(route('santri.dashboard'))
                ->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah',
        ])->onlyInput('nisn');
    }

    public function logout(Request $request)
    {
        // Log activity before logout (optional)
        if (Auth::guard('pendaftaran')->check()) {
            $user = Auth::guard('pendaftaran')->user();
            
            if (\Schema::hasTable('activity_logs')) {
                ActivityLog::create([
                    'user_type' => 'client',
                    'user_id' => $user->id,
                    'action' => 'client_logout',
                    'description' => "Client {$user->nama_lengkap} logged out",
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
            }
        }
        
        Auth::guard('pendaftaran')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('santri.login')
            ->with('success', 'Anda berhasil logout');
    }
}