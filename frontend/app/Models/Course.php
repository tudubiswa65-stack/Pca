<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'duration_months',
        'fee',
        'icon',
        'syllabus',
        'status',
        'show_on_website',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'duration_months' => 'integer',
        'show_on_website' => 'boolean',
        'syllabus' => 'json',
    ];

    // Relationships
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeShowOnWebsite($query)
    {
        return $query->where('show_on_website', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessors
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published';
    }

    public function getFormattedFeeAttribute()
    {
        return '₹' . number_format($this->fee);
    }
}