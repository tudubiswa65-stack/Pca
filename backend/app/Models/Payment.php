<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrolment_id',
        'amount',
        'mode',
        'receipt_no',
        'date',
        'recorded_by',
        'receipt_url',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function enrolment()
    {
        return $this->belongsTo(Enrolment::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    // Scopes
    public function scopeByMode($query, $mode)
    {
        return $query->where('mode', $mode);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return '₹' . number_format($this->amount);
    }

    public function getStudentNameAttribute()
    {
        return $this->enrolment->student->user->name;
    }

    public function getCourseNameAttribute()
    {
        return $this->enrolment->course->name;
    }

    public function getModeTextAttribute()
    {
        return ucfirst($this->mode);
    }

    public function getRecordedByNameAttribute()
    {
        return $this->recordedBy ? $this->recordedBy->name : 'System';
    }
}