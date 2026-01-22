<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->pluck('id')->all();
        $courseIds = Course::pluck('id')->all();

        foreach ($students as $studentId) {
            // Pastikan student mendapatkan 4 course (atau sebanyak course yang tersedia jika kurang dari 4)
            $enrollCount = min(4, count($courseIds));
            $selectedCourses = collect($courseIds)->shuffle()->take($enrollCount);

            foreach ($selectedCourses as $courseId) {
                Enrollment::factory()->create([
                    'user_id' => $studentId,
                    'course_id' => $courseId,
                ]);
            }
        }
    }
}
