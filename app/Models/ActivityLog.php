<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'properties'
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public function getUserNameAttribute()
    {
        if ($this->user_type === 'admin') {
            $user = User::find($this->user_id);
            return $user ? $user->name : 'Unknown Admin';
        } else {
            $user = Pendaftaran::find($this->user_id);
            return $user ? $user->nama_lengkap : 'Unknown Client';
        }
    }

    public static function log($action, $description, $properties = null)
    {
        $userType = 'admin';
        $userId = auth()->id();
        
        if (auth()->guard('pendaftaran')->check()) {
            $userType = 'client';
            $userId = auth()->guard('pendaftaran')->id();
        }

        return self::create([
            'user_type' => $userType,
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'properties' => $properties
        ]);
    }
}