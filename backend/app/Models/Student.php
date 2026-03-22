<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'student_code',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'address',
        'aadhaar_encrypted',
        'photo_url',
        'qualification',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function enquiry()
    {
        return $this->hasOne(Enquiry::class, 'converted_student_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeByBatch($query, $batchId)
    {
        return $query->whereHas('enrolments', function($q) use ($batchId) {
            $q->where('batch_id', $batchId);
        });
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getAgeAttribute()
    {
        return $this->dob ? $this->dob->age : null;
    }

    public function getActiveEnrolmentAttribute()
    {
        return $this->enrolments()->where('status', 'active')->first();
    }
}