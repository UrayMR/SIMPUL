<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = \App\Models\Teacher::all();
        $categories = \App\Models\Category::pluck('id')->all();
        foreach ($teachers as $teacher) {
            \App\Models\Course::factory(2)->create([
                'teacher_id' => $teacher->id,
                'category_id' => $categories[array_rand($categories)],
            ]);
        }
    }
}
