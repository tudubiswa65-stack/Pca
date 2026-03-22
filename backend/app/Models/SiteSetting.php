<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'updated_by',
    ];

    // Relationships
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    // Accessors
    public function getUpdatedByNameAttribute()
    {
        return $this->updatedBy ? $this->updatedBy->name : 'System';
    }

    // Static methods for easy access
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $userId = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'updated_by' => $userId]
        );
    }

    public static function getMultiple(array $keys)
    {
        return self::whereIn('key', $keys)
                  ->get()
                  ->pluck('value', 'key')
                  ->toArray();
    }

    public static function getAllSettings()
    {
        return self::all()->pluck('value', 'key')->toArray();
    }

    // Predefined setting keys and their defaults
    public static function getDefaultSettings()
    {
        return [
            'academy_name' => 'Padmabati Computer Academy',
            'tagline' => 'Your Gateway to Digital Success',
            'address' => '',
            'phone' => '',
            'email' => '',
            'whatsapp' => '',
            'google_map_url' => '',
            'justdial_rating' => '4.5',
            'hero_title' => 'Start Your Digital Career Today',
            'hero_desc' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'twitter_url' => '',
            'linkedin_url' => '',
            'stats_total_students' => '0',
            'stats_years' => '1',
            'stats_courses' => '0',
            'stats_success_rate' => '95',
            'about_academy' => '',
            'vision' => '',
            'mission' => '',
            'logo_url' => '',
            'favicon_url' => '',
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'accent_color' => '#28a745',
            'site_mode' => 'live', // live, maintenance
            'maintenance_message' => 'Site is under maintenance. Please check back later.',
            'analytics_code' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'contact_form_email' => '',
            'notification_email' => '',
            'sms_enabled' => 'false',
            'email_enabled' => 'true',
            'registration_enabled' => 'true',
            'online_payment_enabled' => 'false',
            'razorpay_key_id' => '',
            'razorpay_key_secret' => '',
            'timezone' => 'Asia/Kolkata',
            'date_format' => 'd/m/Y',
            'time_format' => 'h:i A',
            'currency_symbol' => '₹',
            'default_batch_capacity' => '30',
            'certificate_template' => 'default',
            'auto_backup_enabled' => 'false',
            'backup_frequency' => 'weekly',
        ];
    }

    // Type casting helpers
    public function getBoolValue()
    {
        return in_array(strtolower($this->value), ['true', '1', 'yes', 'on']);
    }

    public function getIntValue()
    {
        return (int) $this->value;
    }

    public function getFloatValue()
    {
        return (float) $this->value;
    }

    public function getArrayValue()
    {
        return json_decode($this->value, true) ?? [];
    }
}