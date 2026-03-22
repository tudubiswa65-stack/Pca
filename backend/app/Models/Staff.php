<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'designation',
        'qualification',
        'subjects',
        'join_date',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'faculty_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getSubjectsArrayAttribute()
    {
        return $this->subjects ? explode(',', $this->subjects) : [];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('status', 'active');
        });
    }
}