<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id',
        'batch_id',
        'date',
        'max_marks',
        'pass_marks',
        'published_at',
    ];

    protected $casts = [
        'date' => 'date',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>', now()->toDateString());
    }

    public function scopeCompleted($query)
    {
        return $query->where('date', '<=', now()->toDateString());
    }

    // Accessors
    public function getIsPublishedAttribute()
    {
        return !is_null($this->published_at);
    }

    public function getPassPercentageAttribute()
    {
        return round(($this->pass_marks / $this->max_marks) * 100, 2);
    }

    public function getTotalStudentsAttribute()
    {
        return $this->marks()->count();
    }

    public function getPassedStudentsAttribute()
    {
        return $this->marks()->where('marks_obtained', '>=', $this->pass_marks)->count();
    }

    public function getFailedStudentsAttribute()
    {
        return $this->marks()->where('marks_obtained', '<', $this->pass_marks)->count();
    }

    public function getPassRateAttribute()
    {
        $total = $this->total_students;
        return $total > 0 ? round(($this->passed_students / $total) * 100, 2) : 0;
    }

    public function getAverageMarksAttribute()
    {
        return $this->marks()->avg('marks_obtained') ?? 0;
    }

    public function getHighestMarksAttribute()
    {
        return $this->marks()->max('marks_obtained') ?? 0;
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