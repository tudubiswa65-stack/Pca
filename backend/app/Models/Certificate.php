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
        'cert_no',
        'issue_date',
        'status',
        'file_url',
        'qr_token',
    ];

    protected $casts = [
        'issue_date' => 'date',
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

    // Scopes
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    public function scopeRevoked($query)
    {
        return $query->where('status', 'revoked');
    }

    public function scopeByYear($query, $year)
    {
        return $query->whereYear('issue_date', $year);
    }

    public function scopeByMonth($query, $month, $year = null)
    {
        $query = $query->whereMonth('issue_date', $month);
        
        if ($year) {
            $query->whereYear('issue_date', $year);
        }
        
        return $query;
    }

    // Accessors
    public function getStudentNameAttribute()
    {
        return $this->student->user->name;
    }

    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }

    public function getIsIssuedAttribute()
    {
        return $this->status === 'issued';
    }

    public function getIsRevokedAttribute()
    {
        return $this->status === 'revoked';
    }

    public function getQrCodeUrlAttribute()
    {
        // This would generate QR code URL for verification
        return url("/verify-certificate/{$this->qr_token}");
    }

    public function getVerificationUrlAttribute()
    {
        return url("/certificates/verify/{$this->cert_no}");
    }

    public function getFormattedIssueDateAttribute()
    {
        return $this->issue_date->format('F j, Y');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'issued' => ['text' => 'Issued', 'color' => 'green'],
            'revoked' => ['text' => 'Revoked', 'color' => 'red'],
            default => ['text' => 'Unknown', 'color' => 'gray']
        };
    }

    public function getDisplayNameAttribute()
    {
        return "Certificate - {$this->course_name} - {$this->student_name}";
    }

    // Methods
    public function revoke()
    {
        $this->update(['status' => 'revoked']);
    }

    public function reissue()
    {
        $this->update(['status' => 'issued']);
    }

    // Static methods
    public static function generateCertNumber($courseCode = null)
    {
        $year = date('Y');
        $month = date('m');
        
        $prefix = $courseCode ? strtoupper($courseCode) : 'CERT';
        
        $lastCert = self::where('cert_no', 'like', "{$prefix}-{$year}{$month}%")
                       ->orderBy('cert_no', 'desc')
                       ->first();
        
        if ($lastCert) {
            $lastNumber = (int) substr($lastCert->cert_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "{$prefix}-{$year}{$month}{$newNumber}";
    }

    public static function generateQrToken()
    {
        do {
            $token = bin2hex(random_bytes(16));
        } while (self::where('qr_token', $token)->exists());
        
        return $token;
    }
}