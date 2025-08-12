<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\Pendaftaran;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            ->whereHas('gelombang', function($q) {
                $q->where('is_active', true)
                    ->whereDate('tanggal_mulai', '<=', now())
                    ->whereDate('tanggal_selesai', '>=', now());
            })
            ->first();

        if (!$token) {
            return back()->with('error', 'Token tidak valid atau sudah digunakan!');
        }

        session(['ppdb_token' => $token->token]);
        return redirect()->route('ppdb.form');
    }

    public function showForm()
    {
        if (!session('ppdb_token')) {
            return redirect()->route('ppdb.token')
                ->with('error', 'Silakan masukkan token terlebih dahulu!');
        }

        $token = Token::where('token', session('ppdb_token'))->first();
        
        return view('client.ppdb.form', compact('token'));
    }

    public function store(Request $request)
    {
        if (!session('ppdb_token')) {
            return redirect()->route('ppdb.token')
                ->with('error', 'Token tidak valid!');
        }

        $validated = $request->validate([
            'nisn' => 'required|unique:pendaftarans,nisn',
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'pendidikan_ayah' => 'required|string',
            'pendidikan_ibu' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'asal_sekolah' => 'required|string',
            'no_whatsapp' => 'required|string',
            'bukti_pembayaran' => 'required|image|max:2048'
        ]);

        $token = Token::where('token', session('ppdb_token'))->first();
        
        if (!$token) {
            return redirect()->route('ppdb.token')
                ->with('error', 'Token tidak valid!');
        }

        // Upload bukti pembayaran
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        // Generate password
        $password = Str::random(8);

        // Create pendaftaran
        $pendaftaran = Pendaftaran::create([
            ...$validated,
            'bukti_pembayaran' => $buktiPath,
            'token' => $token->token,
            'password' => Hash::make($password),
            'gelombang_id' => $token->gelombang_id,
            'tahun_ajaran_id' => $token->gelombang->tahun_ajaran_id,
            'status' => 'pending'
        ]);

        // Mark token as used
        $token->update([
            'is_used' => true,
            'used_at' => now()
        ]);

        // Clear session
        session()->forget('ppdb_token');

        // Store credentials temporarily to show to user
        session()->flash('registration_success', [
            'nisn' => $pendaftaran->nisn,
            'password' => $password,
            'nama' => $pendaftaran->nama_lengkap
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