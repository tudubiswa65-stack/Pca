<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'student_id',
        'marks_obtained',
        'grade',
        'rank',
        'published',
    ];

    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'published' => 'boolean',
    ];

    // Relationships
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopePassed($query)
    {
        return $query->whereRaw('marks_obtained >= (SELECT pass_marks FROM assessments WHERE assessments.id = marks.assessment_id)');
    }

    public function scopeFailed($query)
    {
        return $query->whereRaw('marks_obtained < (SELECT pass_marks FROM assessments WHERE assessments.id = marks.assessment_id)');
    }

    // Accessors
    public function getPercentageAttribute()
    {
        $maxMarks = $this->assessment->max_marks;
        return $maxMarks > 0 ? round(($this->marks_obtained / $maxMarks) * 100, 2) : 0;
    }

    public function getIsPassedAttribute()
    {
        return $this->marks_obtained >= $this->assessment->pass_marks;
    }

    public function getGradeTextAttribute()
    {
        if ($this->grade) {
            return $this->grade;
        }

        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C';
        return 'F';
    }

    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getAssessmentNameAttribute()
    {
        return $this->assessment->name;
    }

    public function getStatusAttribute()
    {
        return $this->is_passed ? 'Pass' : 'Fail';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_passed ? 'green' : 'red';
    }
}