<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'recorded_by');
    }

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class, 'created_by');
    }

    public function notices()
    {
        return $this->hasMany(Notice::class, 'created_by');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'created_by');
    }

    public function feedbackReplies()
    {
        return $this->hasMany(Feedback::class, 'replied_by');
    }

    public function galleryUploads()
    {
        return $this->hasMany(Gallery::class, 'uploaded_by');
    }

    public function siteSettingsUpdates()
    {
        return $this->hasMany(SiteSetting::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsStudentAttribute()
    {
        return $this->role === 'student';
    }

    public function getIsAdminAttribute()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }
}