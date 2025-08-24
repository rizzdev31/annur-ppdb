<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'content',
        'status',
        'kategori',
        'author',
        'is_featured',
        'is_highlighted',
        'image',
        'image_alt',
        'meta_description',
        'keywords',
        'published_at',
        'views'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_highlighted' => 'boolean',
        'views' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug from title when creating
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
                
                // Make sure slug is unique
                $count = static::whereRaw("slug RLIKE '^{$berita->slug}(-[0-9]+)?$'")->count();
                if ($count > 0) {
                    $berita->slug = $berita->slug . '-' . ($count + 1);
                }
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

        // Handle updates
        static::updating(function ($berita) {
            // Update slug if title changed
            if ($berita->isDirty('judul') && !$berita->isDirty('slug')) {
                $berita->slug = Str::slug($berita->judul);
                
                // Make sure slug is unique
                $count = static::where('id', '!=', $berita->id)
                              ->whereRaw("slug RLIKE '^{$berita->slug}(-[0-9]+)?$'")->count();
                if ($count > 0) {
                    $berita->slug = $berita->slug . '-' . ($count + 1);
                }
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
     * Scope for highlighted berita (hero section)
     */
    public function scopeHighlighted($query)
    {
        return $query->where('is_highlighted', true);
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
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Set as highlighted (only one can be highlighted at a time)
     */
    public function setAsHighlighted()
    {
        // Remove highlight from all other beritas
        static::where('is_highlighted', true)->update(['is_highlighted' => false]);
        
        // Set this berita as highlighted
        $this->update(['is_highlighted' => true]);
    }

    /**
     * Remove highlight from this berita
     */
    public function removeHighlight()
    {
        $this->update(['is_highlighted' => false]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured()
    {
        $this->update(['is_featured' => !$this->is_featured]);
    }

    /**
     * Check if this berita is highlighted
     */
    public function isHighlighted()
    {
        return $this->is_highlighted;
    }

    /**
     * Check if this berita is featured
     */
    public function isFeatured()
    {
        return $this->is_featured;
    }
}