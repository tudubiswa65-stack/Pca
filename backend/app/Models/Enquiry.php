<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'course_interest',
        'message',
        'status',
        'notes',
        'follow_up_date',
        'converted_student_id',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    // Relationships
    public function convertedStudent()
    {
        return $this->belongsTo(Student::class, 'converted_student_id');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeAdmitted($query)
    {
        return $query->where('status', 'admitted');
    }

    public function scopeNotInterested($query)
    {
        return $query->where('status', 'not_interested');
    }

    public function scopeNeedFollowUp($query)
    {
        return $query->whereNotNull('follow_up_date')
                   ->where('follow_up_date', '<=', now()->toDateString());
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Accessors
    public function getIsConvertedAttribute()
    {
        return $this->status === 'admitted' && !is_null($this->converted_student_id);
    }

    public function getNeedsFollowUpAttribute()
    {
        return $this->follow_up_date && $this->follow_up_date <= now()->toDate();
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'blue',
            'contacted' => 'orange',
            'admitted' => 'green',
            'not_interested' => 'red',
            default => 'gray'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'new' => '🆕',
            'contacted' => '📞',
            'admitted' => '✅',
            'not_interested' => '❌',
            default => '❓'
        };
    }

    public function getSourceAttribute()
    {
        // This could be extended to track actual sources
        return 'Website';
    }

    public function getConvertedStudentNameAttribute()
    {
        return $this->convertedStudent ? $this->convertedStudent->user->name : null;
    }

    public function getDaysOldAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    public function getFollowUpStatusAttribute()
    {
        if (!$this->follow_up_date) return 'No follow-up scheduled';
        
        if ($this->follow_up_date < now()->toDate()) {
            return 'Overdue';
        } elseif ($this->follow_up_date == now()->toDate()) {
            return 'Due today';
        } else {
            return 'Scheduled for ' . $this->follow_up_date->format('M j, Y');
        }
    }
}