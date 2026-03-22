<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrolment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'batch_id',
        'enrolment_date',
        'fee_total',
        'fee_paid',
        'status',
        'progress',
        'completed_modules',
        'completion_date',
        'notes',
    ];

    protected $casts = [
        'enrolment_date' => 'date',
        'completion_date' => 'date',
        'fee_total' => 'decimal:2',
        'fee_paid' => 'decimal:2',
        'progress' => 'decimal:2',
        'completed_modules' => 'json',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    // Accessors
    public function getFeeBalanceAttribute()
    {
        return $this->fee_total - $this->fee_paid;
    }

    public function getProgressPercentageAttribute()
    {
        return round($this->progress * 100);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}