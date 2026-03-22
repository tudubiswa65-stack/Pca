<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin user
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'admin@padmabatiacademy.in',
            'phone' => '9000000000',
            'password' => Hash::make('Admin@1234'),
            'role' => 'super_admin',
            'status' => 'active',
            'phone_verified_at' => now(),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create 3 sample courses
        $dcaId = DB::table('courses')->insertGetId([
            'name' => 'Diploma in Computer Applications',
            'slug' => 'dca',
            'code' => 'DCA001',
            'category' => 'professional',
            'duration_months' => 12,
            'fee' => 8000,
            'description' => 'Comprehensive course covering computer basics, MS Office, internet, and accounting.',
            'syllabus' => json_encode([
                ['module' => 'Computer Fundamentals', 'topics' => ['Hardware', 'Software', 'OS']],
                ['module' => 'MS Office', 'topics' => ['Word', 'Excel', 'PowerPoint']],
                ['module' => 'Internet & Email', 'topics' => ['Browsing', 'Email', 'Security']],
                ['module' => 'Tally', 'topics' => ['Basic Accounting', 'GST', 'Payroll']],
            ]),
            'icon' => '💻',
            'status' => 'published',
            'show_on_website' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('courses')->insert([
            [
                'name' => 'Tally with GST',
                'slug' => 'tally-gst',
                'code' => 'TLY001',
                'category' => 'professional',
                'duration_months' => 3,
                'fee' => 3500,
                'description' => 'Complete Tally ERP 9 and TallyPrime with GST filing.',
                'syllabus' => json_encode([
                    ['module' => 'Basic Accounting', 'topics' => ['Ledger', 'Vouchers', 'Reports']],
                    ['module' => 'GST in Tally', 'topics' => ['GSTR-1', 'GSTR-3B', 'Filing']],
                ]),
                'icon' => '📊',
                'status' => 'published',
                'show_on_website' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MS Office Complete',
                'slug' => 'ms-office',
                'code' => 'MSO001',
                'category' => 'basic',
                'duration_months' => 3,
                'fee' => 2500,
                'description' => 'Word, Excel, PowerPoint and Outlook for office productivity.',
                'syllabus' => json_encode([
                    ['module' => 'MS Word', 'topics' => ['Formatting', 'Tables', 'Mail Merge']],
                    ['module' => 'MS Excel', 'topics' => ['Formulas', 'Charts', 'Pivot Tables']],
                    ['module' => 'MS PowerPoint', 'topics' => ['Presentations', 'Animations']],
                ]),
                'icon' => '📝',
                'status' => 'published',
                'show_on_website' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create 1 active batch for DCA
        $staffId = DB::table('staff')->insertGetId([
            'user_id' => $adminId,
            'designation' => 'Faculty',
            'qualification' => 'MCA',
            'subjects' => 'Computer Science, Programming',
            'join_date' => '2020-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $batchId = DB::table('batches')->insertGetId([
            'name' => 'DCA Batch 2024-A',
            'course_id' => $dcaId,
            'faculty_id' => $staffId,
            'start_date' => '2024-01-15',
            'end_date' => '2025-01-14',
            'schedule' => json_encode(['days' => ['Mon', 'Wed', 'Fri'], 'time' => '10:00 AM - 12:00 PM']),
            'capacity' => 20,
            'room' => 'Lab 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create 5 sample student users with enrolments
        $students = [
            ['name' => 'Rahul Kumar', 'phone' => '9111111111', 'email' => 'rahul@example.com'],
            ['name' => 'Priya Sharma', 'phone' => '9222222222', 'email' => 'priya@example.com'],
            ['name' => 'Amit Patel', 'phone' => '9333333333', 'email' => 'amit@example.com'],
            ['name' => 'Sunita Devi', 'phone' => '9444444444', 'email' => 'sunita@example.com'],
            ['name' => 'Rajesh Nayak', 'phone' => '9555555555', 'email' => 'rajesh@example.com'],
        ];

        foreach ($students as $i => $student) {
            $userId = DB::table('users')->insertGetId([
                'name' => $student['name'],
                'email' => $student['email'],
                'phone' => $student['phone'],
                'password' => Hash::make('Student@1234'),
                'role' => 'student',
                'status' => 'active',
                'phone_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $studentId = DB::table('students')->insertGetId([
                'user_id' => $userId,
                'student_code' => 'PCA' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'father_name' => 'Father of ' . $student['name'],
                'dob' => '2000-0' . ($i + 1) . '-15',
                'gender' => $i % 2 === 0 ? 'male' : 'female',
                'address' => 'Bhadrak, Odisha',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('enrolments')->insert([
                'student_id' => $studentId,
                'course_id' => $dcaId,
                'batch_id' => $batchId,
                'enrol_date' => '2024-01-15',
                'fee_total' => 8000,
                'fee_paid' => $i * 2000,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed site_settings
        $settings = [
            ['key' => 'academy_name', 'value' => 'Padmabati Computer Academy'],
            ['key' => 'tagline', 'value' => 'Your Gateway to Digital Success'],
            ['key' => 'address', 'value' => 'Bonth Chhak, Bhadrak, Odisha - 756100'],
            ['key' => 'phone', 'value' => '+91 9000000000'],
            ['key' => 'email', 'value' => 'info@padmabatiacademy.in'],
            ['key' => 'whatsapp', 'value' => '+91 9000000000'],
            ['key' => 'google_map_url', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3730.xxx'],
            ['key' => 'justdial_rating', 'value' => '4.9'],
            ['key' => 'hero_title', 'value' => 'Start Your Digital Career Today'],
            ['key' => 'hero_desc', 'value' => 'Join Odisha\'s most trusted computer education center with certified courses'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/padmabatiacademy'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/padmabatiacademy'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@padmabatiacademy'],
            ['key' => 'stats_total_students', 'value' => '500'],
            ['key' => 'stats_years', 'value' => '5'],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}