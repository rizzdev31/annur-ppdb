<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens';

    protected $fillable = [
        'token',
        'gelombang_id',
        'is_used',
        'used_at'
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime'
    ];

    // Relasi dengan gelombang
    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    // Scope untuk token yang belum digunakan
    public function scopeUnused($query)
    {
        return $query->where('is_used', false);
    }

    // Scope untuk token yang sudah digunakan
    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    // Mark token as used
    public function markAsUsed()
    {
        $this->update([
            'is_used' => true,
            'used_at' => now()
        ]);
    }

    // Check if token is valid
    public function isValid()
    {
        if ($this->is_used) {
            return false;
        }

        if (!$this->gelombang) {
            return false;
        }

        return $this->gelombang->isOngoing();
    }
}