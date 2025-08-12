<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajarans';

    protected $fillable = [
        'tahun',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Relasi dengan gelombang
    public function gelombangs()
    {
        return $this->hasMany(Gelombang::class);
    }

    // Relasi dengan pendaftaran
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Scope untuk tahun ajaran aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Set active tahun ajaran
    public function setActive()
    {
        // Deactivate all
        static::where('is_active', true)->update(['is_active' => false]);
        
        // Activate this
        $this->update(['is_active' => true]);
    }
}