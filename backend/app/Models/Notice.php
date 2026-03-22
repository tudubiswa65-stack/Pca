<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'content',
        'target_type',
        'target_id',
        'attachment_url',
        'publish_at',
        'archived_at',
        'created_by',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targetCourse()
    {
        return $this->belongsTo(Course::class, 'target_id')->where('target_type', 'course');
    }

    public function targetBatch()
    {
        return $this->belongsTo(Batch::class, 'target_id')->where('target_type', 'batch');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('publish_at', '<=', now());
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeUrgent($query)
    {
        return $query->where('type', 'urgent');
    }

    public function scopeForAll($query)
    {
        return $query->where('target_type', 'all');
    }

    // Accessors
    public function getIsPublishedAttribute()
    {
        return $this->publish_at <= now();
    }

    public function getIsArchivedAttribute()
    {
        return !is_null($this->archived_at);
    }

    public function getIsUrgentAttribute()
    {
        return $this->type === 'urgent';
    }

    public function getTargetNameAttribute()
    {
        return match($this->target_type) {
            'course' => $this->targetCourse?->name ?? 'Unknown Course',
            'batch' => $this->targetBatch?->name ?? 'Unknown Batch',
            default => 'All Students'
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'urgent' => 'red',
            'exam' => 'orange',
            'event' => 'blue',
            'holiday' => 'green',
            default => 'gray'
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'urgent' => '⚠️',
            'exam' => '📝',
            'event' => '🎉',
            'holiday' => '🎊',
            default => 'ℹ️'
        };
    }

    public function getCreatedByNameAttribute()
    {
        return $this->createdBy->name;
    }

    public function getHasAttachmentAttribute()
    {
        return !empty($this->attachment_url);
    }
}