<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = DB::table('teachers')->get(['id']);
        $categoryIds = DB::table('categories')->pluck('id')->all();

        if (empty($categoryIds)) {
            return; // Ensure categories exist before seeding courses
        }

        $baseTitles = [
            'Intro to', 'Advanced', 'Mastering', 'Practical', 'Fundamentals of'
        ];
        $subjects = ['PHP', 'Laravel', 'Design', 'Marketing', 'Photography', 'Business'];

        foreach ($teachers as $teacher) {
            foreach (range(1, 2) as $i) {
                $subject = $subjects[array_rand($subjects)];
                $title = $baseTitles[array_rand($baseTitles)] . ' ' . $subject;

                DB::table('courses')->updateOrInsert(
                    ['title' => $title, 'teacher_id' => $teacher->id],
                    [
                        'id' => (string) Str::uuid(),
                        'teacher_id' => $teacher->id,
                        'category_id' => $categoryIds[array_rand($categoryIds)],
                        'thumbnail_image' => null,
                        'title' => $title,
                        'description' => 'A comprehensive course on ' . $subject . '.',
                        'price' => rand(10, 50) * 10000, // in IDR-like numbers
                        'video_url' => null,
                        'status' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
