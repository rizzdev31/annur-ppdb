<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'foto',
        'penulis',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
            
            // Check for duplicate slug
            $originalSlug = $berita->slug;
            $count = 1;
            while (static::where('slug', $berita->slug)->exists()) {
                $berita->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($berita) {
            if ($berita->isDirty('judul') && !$berita->isDirty('slug')) {
                $berita->slug = Str::slug($berita->judul);
                
                // Check for duplicate slug
                $originalSlug = $berita->slug;
                $count = 1;
                while (static::where('slug', $berita->slug)->where('id', '!=', $berita->id)->exists()) {
                    $berita->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    // Scope untuk berita published
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // Scope untuk latest news
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}