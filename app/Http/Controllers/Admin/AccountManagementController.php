<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\ActivityLog;
use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;


class AccountManagementController extends Controller
{
    public function dashboard()
    {
        // Statistics
        $stats = [
            'total_admins' => User::count(),
            'active_admins' => User::where('is_active', true)->count(),
            'total_clients' => Pendaftaran::count(),
            'clients_today' => Pendaftaran::whereDate('created_at', today())->count(),
            'recent_activities' => ActivityLog::latest()->take(10)->get(),
        ];

        // Admin by role
        $adminsByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        // Client by status
        $clientsByStatus = Pendaftaran::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Recent logins
        $recentLogins = User::whereNotNull('last_login')
            ->orderBy('last_login', 'desc')
            ->take(5)
            ->get();

        return view('admin.accounts.dashboard', compact('stats', 'adminsByRole', 'clientsByStatus', 'recentLogins'));
    }

    // === ADMIN MANAGEMENT ===
    
    public function adminIndex(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.accounts.admin-index', compact('admins'));
    }

    public function adminCreate()
    {
        return view('admin.accounts.admin-create');
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:super_admin,admin,operator',
            'is_active' => 'boolean'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        $admin = User::create($validated);

        ActivityLog::log('create_admin', "Created admin account: {$admin->name}");

        return redirect()->route('admin.accounts.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function adminEdit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.accounts.admin-edit', compact('admin'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,operator',
            'is_active' => 'boolean'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $admin->update($validated);

        ActivityLog::log('update_admin', "Updated admin account: {$admin->name}");

        return redirect()->route('admin.accounts.admin.show', $id)
            ->with('success', 'Admin berhasil diperbarui');
    }

    public function adminShow($id)
    {
        $admin = User::findOrFail($id);
        $activities = ActivityLog::where('user_type', 'admin')
            ->where('user_id', $id)
            ->latest()
            ->take(20)
            ->get();

        return view('admin.accounts.admin-show', compact('admin', 'activities'));
    }

    public function adminDestroy($id)
    {
        $admin = User::findOrFail($id);
        
        // Prevent deleting super admin or self
        if ($admin->role === 'super_admin' || $admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun ini');
        }

        $adminName = $admin->name;
        $admin->delete();

        ActivityLog::log('delete_admin', "Deleted admin account: {$adminName}");

        return redirect()->route('admin.accounts.admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }

    public function adminToggleStatus($id)
    {
        $admin = User::findOrFail($id);
        
        // Prevent deactivating super admin or self
        if ($admin->role === 'super_admin' || $admin->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat mengubah status akun ini']);
        }

        $admin->is_active = !$admin->is_active;
        $admin->save();

        $status = $admin->is_active ? 'activated' : 'deactivated';
        ActivityLog::log('toggle_admin_status', "Admin {$admin->name} {$status}");

        return response()->json([
            'success' => true,
            'is_active' => $admin->is_active,
            'message' => 'Status berhasil diubah'
        ]);
    }

    // === CLIENT MANAGEMENT ===

    public function clientIndex(Request $request)
    {
        $query = Pendaftaran::with(['gelombang', 'tahunAjaran']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenjang') && $request->jenjang != '') {
            $query->where('jenjang', $request->jenjang);
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(10);

        // Decrypt passwords for display
        foreach ($clients as $client) {
            if (!$client->password_changed && $client->original_password) {
                try {
                    $client->decrypted_password = Crypt::decryptString($client->original_password);
                } catch (\Exception $e) {
                    $client->decrypted_password = 'Password tidak tersedia';
                }
            } else {
                $client->decrypted_password = 'Password sudah diganti';
            }
        }

        return view('admin.accounts.client-index', compact('clients'));
    }

    public function clientShow($id)
    {
        $client = Pendaftaran::with(['gelombang', 'tahunAjaran'])->findOrFail($id);
        
        // Decrypt password if available
        if (!$client->password_changed && $client->original_password) {
            try {
                $client->decrypted_password = Crypt::decryptString($client->original_password);
            } catch (\Exception $e) {
                $client->decrypted_password = null;
            }
        }

        $activities = ActivityLog::where('user_type', 'client')
            ->where('user_id', $id)
            ->latest()
            ->take(20)
            ->get();

        return view('admin.accounts.client-show', compact('client', 'activities'));
    }

    public function clientEdit($id)
    {
        $client = Pendaftaran::findOrFail($id);
        $gelombangs = Gelombang::all();
        $tahunAjarans = TahunAjaran::all();
        
        return view('admin.accounts.client-edit', compact('client', 'gelombangs', 'tahunAjarans'));
    }

    public function clientUpdate(Request $request, $id)
    {
        $client = Pendaftaran::findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'asal_sekolah' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'status' => 'required|in:pending,seleksi,diterima,ditolak',
            'gelombang_id' => 'required|exists:gelombangs,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ];

        // Validate NISN unique if changed
        if ($request->nisn != $client->nisn) {
            $rules['nisn'] = 'required|string|unique:pendaftarans,nisn';
        } else {
            $rules['nisn'] = 'required|string';
        }

        // Validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules);

        // Handle password change
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            $validated['original_password'] = Crypt::encryptString($request->password);
            $validated['password_changed'] = false; // Reset to false so new password can be seen
        }

        $client->update($validated);

        ActivityLog::log('update_client', "Updated client account: {$client->nama_lengkap}");

        return redirect()->route('admin.accounts.client.show', $id)
            ->with('success', 'Data client berhasil diperbarui');
    }

    public function clientDestroy($id)
    {
        $client = Pendaftaran::findOrFail($id);
        $clientName = $client->nama_lengkap;
        
        // Delete uploaded files
        $files = ['bukti_pembayaran', 'ijazah', 'surat_keterangan_lulus', 'akta_kelahiran', 'kartu_keluarga'];
        foreach ($files as $file) {
            if ($client->$file && file_exists(public_path('uploads/' . $client->$file))) {
                unlink(public_path('uploads/' . $client->$file));
            }
        }
        
        $client->delete();

        ActivityLog::log('delete_client', "Deleted client account: {$clientName}");

        return redirect()->route('admin.accounts.client.index')
            ->with('success', 'Client berhasil dihapus');
    }

    public function clientResetPassword($id)
    {
        $client = Pendaftaran::findOrFail($id);
        
        $newPassword = 'PPDB' . date('Y') . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
        
        $client->password = Hash::make($newPassword);
        $client->original_password = Crypt::encryptString($newPassword);
        $client->password_changed = false;
        $client->save();

        ActivityLog::log('reset_client_password', "Reset password for client: {$client->nama_lengkap}");

        return response()->json([
            'success' => true,
            'password' => $newPassword,
            'message' => 'Password berhasil direset'
        ]);
    }

    public function clientShowPassword($id)
    {
        $client = Pendaftaran::findOrFail($id);
        
        $password = 'Password sudah diganti atau tidak tersedia';
        if (!$client->password_changed && $client->original_password) {
            try {
                $password = Crypt::decryptString($client->original_password);
            } catch (\Exception $e) {
                $password = 'Error decrypt password';
            }
        }

        return response()->json([
            'success' => true,
            'nisn' => $client->nisn,
            'password' => $password
        ]);
    }

    // === ACTIVITY LOGS ===

    public function activityLogs(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->has('user_type') && $request->user_type != '') {
            $query->where('user_type', $request->user_type);
        }

        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->paginate(20);

        // Get unique actions for filter
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.accounts.activity-logs', compact('logs', 'actions'));
    }

       /**
     * Export Client Data to Excel (HTML Table Method)
     */
    public function clientExport(Request $request)
    {
        // Query data dengan filter jika ada
        $query = Pendaftaran::with(['gelombang', 'tahunAjaran']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenjang') && $request->jenjang != '') {
            $query->where('jenjang', $request->jenjang);
        }

        $clients = $query->orderBy('created_at', 'desc')->get();

        // Process passwords
        foreach ($clients as $client) {
            if (!$client->password_changed && $client->original_password) {
                try {
                    $client->decrypted_password = Crypt::decryptString($client->original_password);
                } catch (\Exception $e) {
                    $client->decrypted_password = 'Tidak tersedia';
                }
            } else {
                $client->decrypted_password = 'Password sudah diganti';
            }
        }

        // Generate filename
        $filename = 'Data_Client_PPDB_' . date('Y-m-d_His') . '.xls';

        // Set headers for Excel download
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        // Generate Excel content using view
        $content = view('admin.exports.client-excel', compact('clients'))->render();

        return Response::make($content, 200, $headers);
    }

    /**
     * Alternative: Export to CSV
     */
    public function clientExportCSV(Request $request)
    {
        // Query data dengan filter
        $query = Pendaftaran::with(['gelombang', 'tahunAjaran']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenjang') && $request->jenjang != '') {
            $query->where('jenjang', $request->jenjang);
        }

        $clients = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Data_Client_PPDB_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = [
            'No',
            'NISN',
            'Password',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenjang',
            'Asal Sekolah',
            'Nama Ayah',
            'Nama Ibu',
            'Pekerjaan Ayah',
            'Pekerjaan Ibu',
            'No WhatsApp',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Alamat',
            'Status',
            'Gelombang',
            'Tahun Ajaran',
            'Tanggal Daftar'
        ];

        $callback = function() use($clients, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, $columns);

            $no = 1;
            foreach($clients as $client) {
                // Decrypt password
                $password = 'Password sudah diganti';
                if (!$client->password_changed && $client->original_password) {
                    try {
                        $password = Crypt::decryptString($client->original_password);
                    } catch (\Exception $e) {
                        $password = 'Tidak tersedia';
                    }
                }

                fputcsv($file, [
                    $no,
                    $client->nisn,
                    $password,
                    $client->nama_lengkap,
                    $client->tempat_lahir,
                    $client->tanggal_lahir->format('d/m/Y'),
                    $client->jenjang,
                    $client->asal_sekolah,
                    $client->nama_ayah,
                    $client->nama_ibu,
                    $client->pekerjaan_ayah,
                    $client->pekerjaan_ibu,
                    $client->no_whatsapp,
                    $client->provinsi,
                    $client->kota,
                    $client->kecamatan,
                    $client->alamat_lengkap,
                    ucfirst($client->status),
                    $client->gelombang->nama_gelombang ?? '-',
                    $client->tahunAjaran->tahun ?? '-',
                    $client->created_at->format('d/m/Y H:i')
                ]);
                $no++;
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}