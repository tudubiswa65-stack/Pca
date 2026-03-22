<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = [
        'caption',
        'category',
        'file_url',
        'storage_path',
        'is_public',
        'sort_order',
        'uploaded_by',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Relationships
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getUploadedByNameAttribute()
    {
        return $this->uploadedBy ? $this->uploadedBy->name : 'System';
    }

    public function getFileTypeAttribute()
    {
        $extension = strtolower(pathinfo($this->file_url, PATHINFO_EXTENSION));
        
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return 'image';
        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv'])) {
            return 'video';
        }
        
        return 'other';
    }

    public function getIsImageAttribute()
    {
        return $this->file_type === 'image';
    }

    public function getIsVideoAttribute()
    {
        return $this->file_type === 'video';
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->is_image) {
            // You could implement thumbnail generation logic here
            return $this->file_url;
        } elseif ($this->is_video) {
            // Return a default video thumbnail
            return '/images/video-thumbnail.png';
        }
        
        return '/images/file-icon.png';
    }

    public function getDisplayCaptionAttribute()
    {
        return $this->caption ?: 'Untitled';
    }

    public function getCategoryDisplayAttribute()
    {
        return $this->category ? ucwords(str_replace('_', ' ', $this->category)) : 'General';
    }

    // Static methods for categories
    public static function getCategories()
    {
        return self::distinct('category')
                  ->whereNotNull('category')
                  ->pluck('category')
                  ->sort()
                  ->values();
    }

    public static function getCategoryCount($category = null)
    {
        $query = self::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        return $query->count();
    }
}