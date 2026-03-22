<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'exam_type',
        'exam_name',
        'subject',
        'max_marks',
        'obtained_marks',
        'exam_date',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'max_marks' => 'decimal:2',
        'obtained_marks' => 'decimal:2',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getPercentageAttribute()
    {
        return $this->max_marks > 0 ? round(($this->obtained_marks / $this->max_marks) * 100, 2) : 0;
    }

    public function getGradeAttribute()
    {
        $percentage = $this->percentage;
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }
}