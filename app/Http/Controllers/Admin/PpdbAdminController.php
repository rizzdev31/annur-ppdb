<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Token;
use App\Models\Gelombang;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PpdbAdminController extends Controller
{
    /**
     * Display listing of PPDB registrations
     */
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['gelombang', 'tahunAjaran']);

        // Filter by tahun ajaran
        if ($request->tahun_ajaran) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        // Filter by gelombang
        if ($request->gelombang) {
            $query->where('gelombang_id', $request->gelombang);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Search by name or NISN
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $pendaftarans = $query->latest()->paginate(20);
        $tahunAjarans = TahunAjaran::all();
        $gelombangs = Gelombang::all();

        return view('admin.ppdb.index', compact('pendaftarans', 'tahunAjarans', 'gelombangs'));
    }

    /**
     * Show detail of a registration
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['gelombang', 'tahunAjaran'])->findOrFail($id);
        return view('admin.ppdb.show', compact('pendaftaran'));
    }

    /**
     * Update registration status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,seleksi,diterima,ditolak'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $oldStatus = $pendaftaran->status;
        $pendaftaran->update(['status' => $request->status]);

        // Log activity (optional)
        activity()
            ->performedOn($pendaftaran)
            ->withProperties([
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ])
            ->log('Status pendaftaran diupdate');

        // Send notification if accepted
        if ($request->status == 'diterima' && $oldStatus != 'diterima') {
            $this->sendAcceptanceNotification($pendaftaran);
        }

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    /**
     * Generate new tokens for registration
     */
    public function generateTokens(Request $request)
    {
        $request->validate([
            'gelombang_id' => 'required|exists:gelombangs,id',
            'jumlah' => 'required|integer|min:1|max:100'
        ]);

        DB::beginTransaction();
        try {
            $tokens = [];
            $generatedTokens = [];
            
            for ($i = 0; $i < $request->jumlah; $i++) {
                $token = $this->generateUniqueToken();
                $tokens[] = [
                    'token' => $token,
                    'gelombang_id' => $request->gelombang_id,
                    'is_used' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $generatedTokens[] = $token;
            }

            Token::insert($tokens);
            DB::commit();

            // Store tokens in session for display
            session()->flash('generated_tokens', $generatedTokens);

            return back()->with('success', "Berhasil generate {$request->jumlah} token!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal generate token: ' . $e->getMessage());
        }
    }

    /**
     * Export WhatsApp numbers
     */
    public function exportWhatsApp(Request $request)
    {
        $query = Pendaftaran::query();
        
        // Filter only accepted if specified
        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'diterima');
        }

        $pendaftarans = $query->select('nama_lengkap', 'no_whatsapp')->get();
        
        // Format numbers for WhatsApp
        $numbers = $pendaftarans->map(function($p) {
            $number = preg_replace('/[^0-9]/', '', $p->no_whatsapp);
            if (substr($number, 0, 1) === '0') {
                $number = '62' . substr($number, 1);
            }
            return [
                'nama' => $p->nama_lengkap,
                'nomor' => $number
            ];
        });

        // Return as download
        $content = $numbers->map(function($item) {
            return $item['nomor'] . ' - ' . $item['nama'];
        })->implode("\n");

        return response($content, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="whatsapp-numbers-' . date('Y-m-d') . '.txt"');
    }

    /**
     * Delete a registration (optional)
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        // Delete bukti pembayaran file if exists
        if ($pendaftaran->bukti_pembayaran) {
            Storage::delete($pendaftaran->bukti_pembayaran);
        }
        
        $pendaftaran->delete();
        
        return redirect()->route('admin.ppdb.index')
            ->with('success', 'Data pendaftaran berhasil dihapus');
    }

    /**
     * Generate unique token
     */
    private function generateUniqueToken()
    {
        do {
            $token = strtoupper(Str::random(8));
        } while (Token::where('token', $token)->exists());
        
        return $token;
    }

    /**
     * Send acceptance notification
     */
    private function sendAcceptanceNotification($pendaftaran)
    {
        // Implement your notification logic here
        // Example: Send WhatsApp, Email, etc.
        
        // For now, just log
        \Log::info('Acceptance notification should be sent to: ' . $pendaftaran->no_whatsapp);
    }
}