<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'course_interest',
        'source',
        'status',
        'replied_by',
        'reply_message',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_interest');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Accessors
    public function getIsRepliedAttribute()
    {
        return $this->status === 'replied';
    }
}