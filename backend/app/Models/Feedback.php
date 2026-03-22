<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'student_id',
        'type',
        'category',
        'rating',
        'comment',
        'is_anonymous',
        'status',
        'reply',
        'replied_by',
        'replied_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    public function scopeWithRating($query)
    {
        return $query->whereNotNull('rating');
    }

    // Accessors
    public function getStudentNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }
        return $this->student ? $this->student->user->name : 'Guest';
    }

    public function getIsResolvedAttribute()
    {
        return $this->status === 'resolved';
    }

    public function getIsOpenAttribute()
    {
        return $this->status === 'open';
    }

    public function getHasReplyAttribute()
    {
        return !empty($this->reply);
    }

    public function getRepliedByNameAttribute()
    {
        return $this->repliedBy ? $this->repliedBy->name : null;
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'general' => 'ℹ️',
            'faculty' => '👨‍🏫',
            'course' => '📚',
            'complaint' => '⚠️',
            'suggestion' => '💡',
            default => '📝'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'open' => 'red',
            'in_progress' => 'orange',
            'resolved' => 'green',
            default => 'gray'
        };
    }

    public function getRatingStarsAttribute()
    {
        if (!$this->rating) return '';
        return str_repeat('⭐', $this->rating);
    }

    public function getAverageRatingAttribute()
    {
        return $this->rating ?? 0;
    }
}