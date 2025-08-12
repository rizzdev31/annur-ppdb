<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Display token list
     */
    public function index(Request $request)
    {
        $query = Token::with('gelombang.tahunAjaran');
        
        if ($request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }
        
        if ($request->status == 'used') {
            $query->where('is_used', true);
        } elseif ($request->status == 'unused') {
            $query->where('is_used', false);
        }
        
        $tokens = $query->latest()->paginate(20);
        $gelombangs = Gelombang::with('tahunAjaran')->get();
        
        // Pastikan view path benar: admin.token.index (bukan tokens)
        return view('admin.token.index', compact('tokens', 'gelombangs'));
    }

    /**
     * Generate new tokens
     */
    public function generate(Request $request)
    {
        $request->validate([
            'gelombang_id' => 'required|exists:gelombangs,id',
            'jumlah' => 'required|integer|min:1|max:100'
        ]);

        DB::beginTransaction();
        try {
            $tokens = [];
            $tokenList = [];
            
            for ($i = 0; $i < $request->jumlah; $i++) {
                $token = $this->generateUniqueToken();
                $tokens[] = [
                    'token' => $token,
                    'gelombang_id' => $request->gelombang_id,
                    'is_used' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $tokenList[] = $token;
            }

            Token::insert($tokens);
            DB::commit();
            
            session()->flash('generated_tokens', $tokenList);
            
            return redirect()->route('admin.token.index')
                ->with('success', "Berhasil generate {$request->jumlah} token!");
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal generate token: ' . $e->getMessage());
        }
    }

    /**
     * Export tokens to CSV
     */
    public function export(Request $request)
    {
        $query = Token::with('gelombang');
        
        if ($request->gelombang_id) {
            $query->where('gelombang_id', $request->gelombang_id);
        }
        
        if ($request->unused_only) {
            $query->where('is_used', false);
        }
        
        $tokens = $query->get();
        
        $content = "TOKEN,GELOMBANG,STATUS,TANGGAL\n";
        foreach ($tokens as $token) {
            $status = $token->is_used ? 'USED' : 'AVAILABLE';
            $gelombang = $token->gelombang ? $token->gelombang->nama_gelombang : '-';
            $content .= "{$token->token},{$gelombang},{$status},{$token->created_at}\n";
        }
        
        return response($content, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="tokens-' . date('Y-m-d') . '.csv"');
    }

    /**
     * Delete token
     */
    public function destroy($id)
    {
        $token = Token::findOrFail($id);
        
        if ($token->is_used) {
            return back()->with('error', 'Token yang sudah digunakan tidak bisa dihapus!');
        }
        
        $token->delete();
        
        return back()->with('success', 'Token berhasil dihapus');
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
}