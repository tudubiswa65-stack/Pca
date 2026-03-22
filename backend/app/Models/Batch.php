<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'course_id',
        'faculty_id',
        'start_date',
        'end_date',
        'schedule',
        'capacity',
        'room',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'schedule' => 'array',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Staff::class, 'faculty_id');
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getEnrolledStudentsAttribute()
    {
        return $this->enrolments()->with('student.user')->get();
    }

    public function getCurrentEnrolmentCountAttribute()
    {
        return $this->enrolments()->where('status', 'active')->count();
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->current_enrolment_count;
    }

    public function getIsFullAttribute()
    {
        return $this->current_enrolment_count >= $this->capacity;
    }

    public function getScheduleTextAttribute()
    {
        if (!$this->schedule) return '';
        
        $days = $this->schedule['days'] ?? [];
        $time = $this->schedule['time'] ?? '';
        
        return implode(', ', $days) . ($time ? ' at ' . $time : '');
    }

    public function getFacultyNameAttribute()
    {
        return $this->faculty ? $this->faculty->user->name : 'Not Assigned';
    }
}