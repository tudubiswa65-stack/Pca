<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'batch_id',
        'week_no',
        'week_start',
        'topics_covered',
        'assignments_done',
        'assignments_total',
        'quiz_score',
        'remarks',
        'rating',
        'created_by',
    ];

    protected $casts = [
        'week_start' => 'date',
        'quiz_score' => 'decimal:2',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeByBatch($query, $batchId)
    {
        return $query->where('batch_id', $batchId);
    }

    public function scopeByWeek($query, $weekNo)
    {
        return $query->where('week_no', $weekNo);
    }

    // Accessors
    public function getAssignmentPercentageAttribute()
    {
        return $this->assignments_total > 0 ? 
            round(($this->assignments_done / $this->assignments_total) * 100, 2) : 0;
    }

    public function getWeekEndAttribute()
    {
        return $this->week_start ? $this->week_start->addDays(6) : null;
    }

    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getBatchNameAttribute()
    {
        return $this->batch->name;
    }

    public function getRatingTextAttribute()
    {
        if (!$this->rating) return 'Not Rated';
        
        return match($this->rating) {
            5 => 'Excellent',
            4 => 'Good',
            3 => 'Average',
            2 => 'Below Average',
            1 => 'Poor',
            default => 'Not Rated'
        };
    }

    public function getRatingColorAttribute()
    {
        return match($this->rating) {
            5 => 'green',
            4 => 'blue',
            3 => 'orange',
            2 => 'red',
            1 => 'red',
            default => 'gray'
        };
    }

    public function getCreatedByNameAttribute()
    {
        return $this->createdBy ? $this->createdBy->name : 'System';
    }
}