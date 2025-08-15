<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahapanPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'tahapan_pendaftarans';

    protected $fillable = [
        'icon',
        'nama',
        'deskripsi',
        'urutan',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer'
    ];

    // Scope untuk tahapan aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }
}