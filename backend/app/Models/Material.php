<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'course_id',
        'module_name',
        'file_url',
        'storage_path',
        'file_type',
        'download_count',
        'created_by',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    public function scopeByModule($query, $moduleName)
    {
        return $query->where('module_name', $moduleName);
    }

    public function scopeByFileType($query, $fileType)
    {
        return $query->where('file_type', $fileType);
    }

    // Accessors
    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }

    public function getCreatedByNameAttribute()
    {
        return $this->createdBy->name;
    }

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file_url, PATHINFO_EXTENSION);
    }

    public function getFileSizeAttribute()
    {
        if (file_exists($this->storage_path)) {
            $bytes = filesize($this->storage_path);
            return $this->formatFileSize($bytes);
        }
        return 'Unknown';
    }

    public function getFileIconAttribute()
    {
        return match($this->file_type) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            'ppt', 'pptx' => '📋',
            'jpg', 'jpeg', 'png', 'gif' => '🖼️',
            'mp4', 'avi', 'mov' => '🎥',
            'mp3', 'wav' => '🎵',
            'zip', 'rar' => '📦',
            default => '📎'
        };
    }

    // Helper Methods
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Mutators
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}