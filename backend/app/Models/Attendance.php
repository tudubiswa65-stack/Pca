<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'batch_id',
        'date',
        'status',
        'marked_by',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
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

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    // Scopes
    public function scopeByBatch($query, $batchId)
    {
        return $query->where('batch_id', $batchId);
    }

    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    // Accessors
    public function getIsPresentAttribute()
    {
        return $this->status === 'present';
    }

    public function getIsAbsentAttribute()
    {
        return $this->status === 'absent';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'green',
            'absent' => 'red',
            'leave' => 'orange',
            'holiday' => 'blue',
            default => 'gray'
        };
    }

    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }
}