<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'batch_id',
        'date',
        'status',
        'remarks',
        'marked_by',
        'marked_at',
    ];

    protected $casts = [
        'date' => 'date',
        'marked_at' => 'datetime',
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
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLeave($query)
    {
        return $query->where('status', 'leave');
    }

    public function scopeForMonth($query, $month, $year)
    {
        return $query->whereMonth('date', $month)
                    ->whereYear('date', $year);
    }
}