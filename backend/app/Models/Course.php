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
        'code',
        'category',
        'duration_months',
        'fee',
        'description',
        'syllabus',
        'feature_image_url',
        'icon',
        'status',
        'show_on_website',
    ];

    protected $casts = [
        'syllabus' => 'array',
        'show_on_website' => 'boolean',
    ];

    // Relationships
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeWebsite($query)
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

    public function getDurationTextAttribute()
    {
        return $this->duration_months . ' months';
    }

    public function getActiveBatchesAttribute()
    {
        return $this->batches()->where('status', 'active')->get();
    }

    public function getTotalEnrolmentsAttribute()
    {
        return $this->enrolments()->count();
    }
}