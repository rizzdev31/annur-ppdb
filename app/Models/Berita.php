<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'content',
        'status',
        'kategori',
        'author',
        'is_featured',
        'image',
        'image_alt',
        'meta_description',
        'keywords',
        'published_at',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug from title
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
            
            // Auto generate excerpt from content if not provided
            if (empty($berita->excerpt) && !empty($berita->content)) {
                $berita->excerpt = Str::limit(strip_tags($berita->content), 255);
            }
            
            // Set published_at if status is published and not set
            if ($berita->status === 'published' && empty($berita->published_at)) {
                $berita->published_at = now();
            }
        });

        static::updating(function ($berita) {
            // Update slug if title changed
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
            }
            
            // Auto generate excerpt from content if not provided
            if (empty($berita->excerpt) && !empty($berita->content)) {
                $berita->excerpt = Str::limit(strip_tags($berita->content), 255);
            }
            
            // Set published_at if status changed to published
            if ($berita->isDirty('status') && $berita->status === 'published' && empty($berita->published_at)) {
                $berita->published_at = now();
            }
        });
    }

    /**
     * Scope for published beritas
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope for draft beritas
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for featured beritas
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for specific category
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get formatted published date
     */
    public function getFormattedDateAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('d M Y');
        }
        return $this->created_at->format('d M Y');
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Check if berita is published
     */
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && $this->published_at && $this->published_at <= now();
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}