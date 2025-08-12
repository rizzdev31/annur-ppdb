<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombangs';

    protected $fillable = [
        'tahun_ajaran_id',
        'nama_gelombang',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota',
        'is_active'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'kuota' => 'integer',
        'is_active' => 'boolean'
    ];

    // Relasi dengan tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    // Relasi dengan token
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    // Relasi dengan pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Scope untuk gelombang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk gelombang yang sedang berjalan
    public function scopeOngoing($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('tanggal_mulai', '<=', now())
                     ->whereDate('tanggal_selesai', '>=', now());
    }

    // Check apakah gelombang sedang berjalan
    public function isOngoing()
    {
        return $this->is_active && 
               $this->tanggal_mulai <= now() && 
               $this->tanggal_selesai >= now();
    }

    // Get jumlah pendaftar
    public function getJumlahPendaftarAttribute()
    {
        return $this->pendaftarans()->count();
    }

    // Get sisa kuota
    public function getSisaKuotaAttribute()
    {
        return max(0, $this->kuota - $this->jumlah_pendaftar);
    }

    // Set active gelombang
    public function setActive()
    {
        // Deactivate all gelombang in same tahun ajaran
        static::where('tahun_ajaran_id', $this->tahun_ajaran_id)
              ->where('is_active', true)
              ->update(['is_active' => false]);
        
        // Activate this
        $this->update(['is_active' => true]);
    }
}