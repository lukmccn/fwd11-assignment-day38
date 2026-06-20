<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InstructorProfile;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ----------------
        // USERS
        // ----------------
        $instructor1 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        $instructor2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'instructor',
        ]);

        $student1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // ----------------
        // INSTRUCTOR PROFILES
        // ----------------
        InstructorProfile::create([
            'user_id' => $instructor1->id,
            'bio' => 'Senior Web Developer dengan pengalaman 10 tahun di Laravel.',
            'expertise' => 'Laravel, PHP, Vue.js',
            'phone' => '08123456789',
        ]);

        InstructorProfile::create([
            'user_id' => $instructor2->id,
            'bio' => 'Data Scientist dan Mobile Developer.',
            'expertise' => 'Python, Flutter, Machine Learning',
            'phone' => '08987654321',
        ]);

        // ----------------
        // COURSE CATEGORIES
        // ----------------
        $webCategory = CourseCategory::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Semua tentang pengembangan web modern.',
            'icon' => 'globe',
        ]);

        $mobileCategory = CourseCategory::create([
            'name' => 'Mobile Development',
            'slug' => 'mobile-development',
            'description' => 'Membangun aplikasi Android dan iOS.',
            'icon' => 'smartphone',
        ]);

        $dataCategory = CourseCategory::create([
            'name' => 'Data Science',
            'slug' => 'data-science',
            'description' => 'Analisis data, machine learning, dan AI.',
            'icon' => 'bar-chart',
        ]);

        // ----------------
        // COURSES
        // ----------------
        $course1 = Course::create([
            'title' => 'Mastering Laravel 11',
            'description' => 'Panduan lengkap Laravel 11 dari dasar hingga mahir. Membahas routing, eloquent, blade, API, dan deployment.',
            'category_id' => $webCategory->id,
            'instructor_id' => $instructor1->id,
            'rating' => 4.5,
            'thumbnail' => 'https://via.placeholder.com/640x480.png/0077be?text=Laravel+11',
            'level' => 'intermediate',
            'duration' => 480, // menit
            'status' => 'published',
            'enrolled_count' => 2,
        ]);

        $course2 = Course::create([
            'title' => 'Vue.js for Beginners',
            'description' => 'Mulai belajar Vue.js dari nol. Cocok untuk pemula yang ingin menguasai frontend framework.',
            'category_id' => $webCategory->id,
            'instructor_id' => $instructor1->id,
            'rating' => 4.0,
            'thumbnail' => 'https://via.placeholder.com/640x480.png/42b883?text=Vue.js',
            'level' => 'beginner',
            'duration' => 240,
            'status' => 'published',
            'enrolled_count' => 1,
        ]);

        $course3 = Course::create([
            'title' => 'Flutter Mobile App Development',
            'description' => 'Buat aplikasi mobile cross-platform dengan Flutter dan Dart.',
            'category_id' => $mobileCategory->id,
            'instructor_id' => $instructor2->id,
            'rating' => 4.8,
            'thumbnail' => 'https://via.placeholder.com/640x480.png/02569B?text=Flutter',
            'level' => 'intermediate',
            'duration' => 600,
            'status' => 'published',
            'enrolled_count' => 1,
        ]);

        // ----------------
        // ENROLLMENTS
        // ----------------
        Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course1->id,
            'enrolled_at' => now()->subDays(7),
            'progress' => 60.00,
            'status' => 'active',
            'updated_at' => now()->subDays(1),
        ]);

        Enrollment::create([
            'user_id' => $student1->id,
            'course_id' => $course2->id,
            'enrolled_at' => now()->subDays(3),
            'progress' => 20.00,
            'status' => 'active',
            'updated_at' => now()->subHours(5),
        ]);

        Enrollment::create([
            'user_id' => $student2->id,
            'course_id' => $course1->id,
            'enrolled_at' => now()->subDays(2),
            'progress' => 10.00,
            'status' => 'active',
            'updated_at' => now(),
        ]);

        Enrollment::create([
            'user_id' => $student2->id,
            'course_id' => $course3->id,
            'enrolled_at' => now()->subDays(1),
            'progress' => 0.00,
            'status' => 'active',
            'updated_at' => now(),
        ]);

        $this->command->info('Data dummy LMS berhasil dibuat!');
        $this->command->table(
            ['Tabel', 'Jumlah'],
            [
                ['Users', '4'],
                ['Instructor Profiles', '2'],
                ['Course Categories', '3'],
                ['Courses', '3'],
                ['Enrollments', '4'],
            ]
        );
    }
}