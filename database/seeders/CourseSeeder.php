<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::with('user')->get();
        $categories = Category::all();

        // Daftar materi kursus nyata, diperbanyak sesuai banyaknya data course
        $materiList = [
            'Pemrograman Web dengan Laravel – Dasar hingga Lanjutan',
            'Fundamental Data Science – Statistik dan Python',
            'Machine Learning untuk Pemula – Teori dan Praktik',
            'Desain Grafis dengan Photoshop – Teknik Dasar',
            'Manajemen Proyek Agile – Scrum dan Kanban',
            'Pengenalan Cybersecurity – Keamanan Dasar',
            'Pengembangan Aplikasi Android – Kotlin dan UI',
            'Database MySQL untuk Pemula – CRUD dan Query',
            'Digital Marketing dan SEO – Strategi Praktis',
            'JavaScript Lanjutan – ES6 dan Frameworks',
            'React JS untuk Pemula – Component dan State',
            'Vue JS untuk Pemula – Directive dan Lifecycle',
            'Python untuk Pemula – Dasar dan Praktik',
            'UI/UX Design – Wireframe dan Prototyping',
            'Business Analytics – Tools dan Dashboard',
            'WordPress Development – Theme dan Plugin',
            'Graphic Design dengan Illustrator – Teknik Dasar',
            'Data Visualization – Tableau dan Power BI',
            'Cloud Computing – AWS dan Azure',
            'DevOps Basics – CI/CD dan Docker',
        ];

        $materiIndex = 0;

        foreach ($teachers as $teacher) {
            for ($i = 0; $i < 5; $i++) { // 5 course per guru
                $materi = $materiList[$materiIndex];
                $materiIndex++;

                Course::create([
                    'id' => (string) Str::uuid(),
                    'teacher_id' => $teacher->id,
                    'category_id' => 1, // bisa diganti sesuai kategori
                    'thumbnail_path' => null,
                    'hero_path' => 'hero_path',
                    'title' => $materi,
                    'description' => "Kursus ini dirancang oleh {$teacher->user->name} untuk membantu peserta memahami materi secara mendalam melalui pendekatan praktis, studi kasus, dan pembelajaran terstruktur.",
                    'price' => rand(100000, 500000),
                    'video_url' => 'dQw4w9WgXcQ', // dummy youtube id
                    'status' => 'approved',
                    'enrollments_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
