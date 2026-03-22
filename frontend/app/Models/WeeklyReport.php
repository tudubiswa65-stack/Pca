<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'week_start',
        'week_end',
        'attendance_days',
        'total_days',
        'performance_rating',
        'topics_covered',
        'strengths',
        'areas_for_improvement',
        'homework_completed',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'week_start' => 'date',
        'week_end' => 'date',
        'attendance_days' => 'integer',
        'total_days' => 'integer',
        'performance_rating' => 'decimal:1',
        'topics_covered' => 'json',
        'homework_completed' => 'boolean',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getAttendancePercentageAttribute()
    {
        return $this->total_days > 0 ? round(($this->attendance_days / $this->total_days) * 100) : 0;
    }

    public function getWeekDisplayAttribute()
    {
        return $this->week_start->format('d M') . ' - ' . $this->week_end->format('d M Y');
    }
}