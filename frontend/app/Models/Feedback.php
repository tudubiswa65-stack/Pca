<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'rating',
        'message',
        'course_taken',
        'is_verified',
        'is_public',
        'status',
        'replied_by',
        'reply_message',
        'replied_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'is_public' => 'boolean',
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_taken');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true)->where('status', 'approved');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Accessors
    public function getStarsArrayAttribute()
    {
        return range(1, 5);
    }

    public function getIsPositiveAttribute()
    {
        return $this->rating >= 4;
    }
}