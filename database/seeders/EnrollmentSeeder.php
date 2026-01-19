<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = \App\Models\User::where('role', 'student')->pluck('id')->all();
        $courseIds = \App\Models\Course::pluck('id')->all();
        foreach ($students as $studentId) {
            $enrollCount = rand(1, min(3, count($courseIds)));
            $selected = collect($courseIds)->shuffle()->take($enrollCount);
            foreach ($selected as $courseId) {
                \App\Models\Enrollment::factory()->create([
                    'user_id' => $studentId,
                    'course_id' => $courseId,
                ]);
            }
        }
    }
}
