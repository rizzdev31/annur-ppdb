<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Show admin profile page
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($admin->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($admin->avatar && Storage::exists('public/' . $admin->avatar)) {
                Storage::delete('public/' . $admin->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $admin->update($validated);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        $admin = Auth::user();
        
        // Get system settings from database or use defaults
        $settings = [
            'site_name' => Setting::get('site_name', config('app.name', 'PPDB MUBOSTA')),
            'site_email' => Setting::get('site_email', 'admin@ppdb.com'),
            'site_phone' => Setting::get('site_phone', '(031) 123456'),
            'site_address' => Setting::get('site_address', 'Jl. Contoh No. 123, Sidoarjo'),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'registration_open' => Setting::get('registration_open', true),
            'max_upload_size' => Setting::get('max_upload_size', 2048),
            'allowed_file_types' => Setting::get('allowed_file_types', 'jpg,jpeg,png,pdf'),
        ];
        
        return view('admin.settings.index', compact('admin', 'settings'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        // Update password
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update system settings (for super admin only)
     */
    public function updateSettings(Request $request)
    {
        // Check if user is super admin
        if (Auth::user()->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah pengaturan sistem');
        }

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string',
            'maintenance_mode' => 'boolean',
            'registration_open' => 'boolean',
            'max_upload_size' => 'required|integer|min:512|max:10240',
            'allowed_file_types' => 'required|string',
        ]);

        // Check if settings table exists
        if (\Schema::hasTable('settings')) {
            // Save settings to database
            Setting::set('site_name', $validated['site_name']);
            Setting::set('site_email', $validated['site_email']);
            Setting::set('site_phone', $validated['site_phone']);
            Setting::set('site_address', $validated['site_address']);
            Setting::set('maintenance_mode', $request->has('maintenance_mode'), 'boolean');
            Setting::set('registration_open', $request->has('registration_open'), 'boolean');
            Setting::set('max_upload_size', $validated['max_upload_size'], 'number');
            Setting::set('allowed_file_types', $validated['allowed_file_types']);

            // Clear settings cache
            Setting::clearCache();
            
            return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Tabel settings belum tersedia. Silakan jalankan migration terlebih dahulu.');
        }
    }
}