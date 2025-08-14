<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function showTokenForm()
    {
        return view('client.ppdb.token');
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $token = Token::where('token', $request->token)
            ->where('is_used', false)
            ->first();

        if (!$token) {
            return back()->with('error', 'Token tidak valid atau sudah digunakan');
        }

        session(['ppdb_token' => $request->token]);
        return redirect()->route('ppdb.form');
    }

    public function showForm()
    {
        if (!session('ppdb_token')) {
            return redirect()->route('ppdb.token');
        }

        return view('client.ppdb.form');
    }

    public function store(Request $request)
    {
        if (!session('ppdb_token')) {
            return redirect()->route('ppdb.token');
        }

        $validated = $request->validate([
            'nisn' => 'required|string|unique:pendaftarans,nisn',
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
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // Dokumen opsional
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get token data
        $token = Token::where('token', session('ppdb_token'))->first();

        // Generate password SEKALI untuk user ini
        $generatedPassword = 'PPDB' . date('Y') . Str::random(4);
        
        // Simpan password terenkripsi dan password asli (dienkripsi untuk keamanan)
        $validated['password'] = Hash::make($generatedPassword);
        $validated['original_password'] = Crypt::encryptString($generatedPassword);
        $validated['password_changed'] = false;
        
        $validated['token'] = session('ppdb_token');
        $validated['gelombang_id'] = $token->gelombang_id;
        $validated['tahun_ajaran_id'] = $token->gelombang->tahun_ajaran_id;

        // Handle file uploads
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_bukti_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $validated['bukti_pembayaran'] = $filename;
        }

        // Handle optional documents
        $optionalDocs = ['ijazah', 'surat_keterangan_lulus', 'akta_kelahiran', 'kartu_keluarga'];
        foreach ($optionalDocs as $doc) {
            if ($request->hasFile($doc)) {
                $file = $request->file($doc);
                $filename = time() . '_' . $doc . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $validated[$doc] = $filename;
            }
        }

        // Create pendaftaran
        $pendaftaran = Pendaftaran::create($validated);

        // Mark token as used
        $token->update([
            'is_used' => true,
            'used_at' => now()
        ]);

        // Clear session
        session()->forget('ppdb_token');

        // Store registration data for success page
        session()->flash('registration_success', [
            'nama' => $pendaftaran->nama_lengkap,
            'nisn' => $pendaftaran->nisn,
            'password' => $generatedPassword, // Password asli untuk ditampilkan SEKALI
            'whatsapp' => $pendaftaran->no_whatsapp
        ]);

        return redirect()->route('ppdb.success');
    }

    public function success()
    {
        if (!session('registration_success')) {
            return redirect()->route('ppdb.token');
        }

        return view('client.ppdb.success');
    }
}