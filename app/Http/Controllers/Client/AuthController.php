<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLogin(Request $request)
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
            
            // Smart redirect logic
            $redirectTo = route('santri.dashboard'); // Default redirect
            
            // Check if there's a redirect_to parameter
            if ($request->has('redirect_to')) {
                $redirectTo = $request->redirect_to;
            }
            // Check if there's an intended URL in session
            elseif (session()->has('url.intended')) {
                $redirectTo = session('url.intended');
                session()->forget('url.intended');
            }
            // Check Laravel's intended URL
            elseif ($intended = redirect()->intended()->getTargetUrl()) {
                // Make sure it's not the login page itself
                if (!str_contains($intended, 'login')) {
                    $redirectTo = $intended;
                }
            }
            
            return redirect($redirectTo)
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
        
        // Redirect to home page after logout instead of login page
        return redirect()->route('home')
            ->with('success', 'Anda berhasil logout');
    }
}