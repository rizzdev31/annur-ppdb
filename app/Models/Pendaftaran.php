<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pendaftaran extends Authenticatable
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'token',
        'nisn',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'anak_ke',
        'jumlah_saudara',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'provinsi',
        'kota',
        'kecamatan',
        'alamat_lengkap',
        'asal_sekolah',
        'no_whatsapp',
        'bukti_pembayaran',
        'password',
        'status',
        'gelombang_id',
        'tahun_ajaran_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anak_ke' => 'integer',
        'jumlah_saudara' => 'integer'
    ];

    // Relasi dengan gelombang
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    // Relasi dengan tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Scope untuk status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSeleksi($query)
    {
        return $query->where('status', 'seleksi');
    }

    public function scopeDiterima($query)
    {
        return $query->where('status', 'diterima');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    // Status helpers
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSeleksi()
    {
        return $this->status === 'seleksi';
    }

    public function isDiterima()
    {
        return $this->status === 'diterima';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    // Update status
    public function updateStatus($status)
    {
        $validStatuses = ['pending', 'seleksi', 'diterima', 'ditolak'];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        return $this->update(['status' => $status]);
    }

    // For authentication
    public function getAuthIdentifierName()
    {
        return 'nisn';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    // Format nomor WhatsApp
    public function getFormattedWhatsappAttribute()
    {
        $number = preg_replace('/[^0-9]/', '', $this->no_whatsapp);
        
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }
        
        return $number;
    }
}