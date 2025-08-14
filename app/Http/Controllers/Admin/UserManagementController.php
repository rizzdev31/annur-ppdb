<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['gelombang', 'tahunAjaran']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by jenjang
        if ($request->has('jenjang') && $request->jenjang != '') {
            $query->where('jenjang', $request->jenjang);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = Pendaftaran::with(['gelombang', 'tahunAjaran'])->findOrFail($id);
        
        // Decrypt password asli jika belum pernah diganti
        $originalPassword = null;
        if (!$user->password_changed && $user->original_password) {
            try {
                $originalPassword = Crypt::decryptString($user->original_password);
            } catch (\Exception $e) {
                $originalPassword = null;
            }
        }
        
        return view('admin.users.show', compact('user', 'originalPassword'));
    }

    public function edit($id)
    {
        $user = Pendaftaran::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Pendaftaran::findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'pendidikan_ayah' => 'required|string|max:255',
            'pendidikan_ibu' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'asal_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'no_whatsapp' => 'required|string|max:20',
            'status' => 'required|in:pending,seleksi,diterima,ditolak',
            // Dokumen opsional
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Jika NISN berubah, validasi unique
        if ($request->nisn != $user->nisn) {
            $rules['nisn'] = 'required|string|unique:pendaftarans,nisn';
        } else {
            $rules['nisn'] = 'required|string';
        }

        // Jika password diubah
        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules);

        // Handle password change
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            $validated['password_changed'] = true;
            // Clear original password karena sudah diganti
            $validated['original_password'] = null;
        }

        // Handle file uploads
        $files = ['bukti_pembayaran', 'ijazah', 'surat_keterangan_lulus', 'akta_kelahiran', 'kartu_keluarga'];
        foreach ($files as $fileField) {
            if ($request->hasFile($fileField)) {
                // Delete old file if exists
                if ($user->$fileField && file_exists(public_path('uploads/' . $user->$fileField))) {
                    unlink(public_path('uploads/' . $user->$fileField));
                }
                
                $file = $request->file($fileField);
                $filename = time() . '_' . $fileField . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $validated[$fileField] = $filename;
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = Pendaftaran::findOrFail($id);
        
        // Delete uploaded files
        $files = ['bukti_pembayaran', 'ijazah', 'surat_keterangan_lulus', 'akta_kelahiran', 'kartu_keluarga'];
        foreach ($files as $file) {
            if ($user->$file && file_exists(public_path('uploads/' . $user->$file))) {
                unlink(public_path('uploads/' . $user->$file));
            }
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil dihapus');
    }

    public function sendLoginInfo($id)
    {
        $user = Pendaftaran::findOrFail($id);
        
        // Get password if not changed
        $password = 'Password sudah pernah diganti';
        if (!$user->password_changed && $user->original_password) {
            try {
                $password = Crypt::decryptString($user->original_password);
            } catch (\Exception $e) {
                $password = 'Password tidak tersedia';
            }
        }

        // Here you would integrate with WhatsApp API
        // For now, we'll just return the info
        
        $message = "Informasi Login PPDB\n\n";
        $message .= "Nama: {$user->nama_lengkap}\n";
        $message .= "Username/NISN: {$user->nisn}\n";
        $message .= "Password: {$password}\n\n";
        $message .= "Login di: " . url('/santri/login');

        // Mark as sent
        $user->update([
            'is_credentials_sent' => true,
            'credentials_sent_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'nisn' => $user->nisn,
                'nama' => $user->nama_lengkap,
                'password' => $password,
                'whatsapp' => $user->no_whatsapp,
                'message' => $message
            ],
            'message' => 'Informasi login berhasil dikirim'
        ]);
    }
}