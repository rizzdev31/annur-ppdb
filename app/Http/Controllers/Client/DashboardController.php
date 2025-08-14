<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pendaftaran = Auth::guard('pendaftaran')->user();
        $pendaftaran->load(['gelombang', 'tahunAjaran']);
        
        // Get latest news/announcements - Check if status column exists
        $beritas = collect([]);
        
        if (Schema::hasTable('beritas')) {
            // Check if status column exists
            $columns = Schema::getColumnListing('beritas');
            
            if (in_array('status', $columns)) {
                // If status column exists
                $beritas = Berita::where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } else {
                // If status column doesn't exist, get all beritas
                $beritas = Berita::orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            }
        }
        
        // Check incomplete data
        $incompleteFields = $this->checkIncompleteData($pendaftaran);
        
        return view('client.dashboard', compact('pendaftaran', 'beritas', 'incompleteFields'));
    }

    public function profile()
    {
        $pendaftaran = Auth::guard('pendaftaran')->user();
        $pendaftaran->load(['gelombang', 'tahunAjaran']);
        
        $incompleteFields = $this->checkIncompleteData($pendaftaran);
        
        return view('client.profile', compact('pendaftaran', 'incompleteFields'));
    }

    public function updateProfile(Request $request)
    {
        $pendaftaran = Auth::guard('pendaftaran')->user();
        
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
            'no_whatsapp' => 'required|string|max:20',
            // Dokumen opsional
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Validate NISN if changed
        if ($request->nisn != $pendaftaran->nisn) {
            $rules['nisn'] = 'required|string|unique:pendaftarans,nisn';
        }

        $validated = $request->validate($rules);

        // Handle file uploads
        $files = ['ijazah', 'surat_keterangan_lulus', 'akta_kelahiran', 'kartu_keluarga'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                // Delete old file if exists
                if ($pendaftaran->$file && file_exists(public_path('uploads/' . $pendaftaran->$file))) {
                    unlink(public_path('uploads/' . $pendaftaran->$file));
                }
                
                $uploadedFile = $request->file($file);
                $filename = time() . '_' . $file . '_' . $uploadedFile->getClientOriginalName();
                $uploadedFile->move(public_path('uploads'), $filename);
                $validated[$file] = $filename;
            }
        }

        $pendaftaran->update($validated);

        return redirect()->route('santri.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $pendaftaran = Auth::guard('pendaftaran')->user();

        if (!Hash::check($request->current_password, $pendaftaran->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        $pendaftaran->update([
            'password' => Hash::make($request->password),
            'password_changed' => true,
            'original_password' => null // Clear original password after change
        ]);

        return redirect()->route('santri.dashboard')
            ->with('success', 'Password berhasil diubah');
    }

    private function checkIncompleteData($pendaftaran)
    {
        $incomplete = [];
        
        // Check required fields
        $requiredFields = [
            'nisn' => 'NISN',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'nama_ayah' => 'Nama Ayah',
            'nama_ibu' => 'Nama Ibu',
            'pekerjaan_ayah' => 'Pekerjaan Ayah',
            'pekerjaan_ibu' => 'Pekerjaan Ibu',
            'alamat_lengkap' => 'Alamat Lengkap',
            'no_whatsapp' => 'No. WhatsApp',
        ];

        foreach ($requiredFields as $field => $label) {
            if (empty($pendaftaran->$field)) {
                $incomplete[] = $label;
            }
        }

        // Check optional documents
        $optionalDocs = [
            'ijazah' => 'Ijazah',
            'surat_keterangan_lulus' => 'Surat Keterangan Lulus',
            'akta_kelahiran' => 'Akta Kelahiran',
            'kartu_keluarga' => 'Kartu Keluarga',
        ];

        foreach ($optionalDocs as $field => $label) {
            if (empty($pendaftaran->$field)) {
                $incomplete['docs'][] = $label;
            }
        }

        return $incomplete;
    }
}