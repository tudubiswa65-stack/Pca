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
        'enrol_date',
        'fee_total',
        'fee_paid',
        'status',
        'cert_issued',
        'cert_issue_date',
    ];

    protected $casts = [
        'enrol_date' => 'date',
        'cert_issue_date' => 'date',
        'cert_issued' => 'boolean',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    // Accessors
    public function getFeePendingAttribute()
    {
        return $this->fee_total - $this->fee_paid;
    }

    public function getFeePercentagePaidAttribute()
    {
        return $this->fee_total > 0 ? round(($this->fee_paid / $this->fee_total) * 100, 2) : 0;
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->fee_paid >= $this->fee_total;
    }

    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }

    public function getBatchNameAttribute()
    {
        return $this->batch->name;
    }
}