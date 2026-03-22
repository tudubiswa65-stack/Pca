<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'certificate_number',
        'qr_token',
        'issued_at',
        'grade',
        'issued_by',
        'template_data',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'template_data' => 'json',
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

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Scopes
    public function scopeByToken($query, $token)
    {
        return $query->where('qr_token', $token);
    }

    // Accessors
    public function getVerificationUrlAttribute()
    {
        return route('certificate.verify', $this->qr_token);
    }

    public function getIsValidAttribute()
    {
        return !empty($this->qr_token) && !empty($this->certificate_number);
    }
}