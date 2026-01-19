<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = DB::table('users')->where('role', 'student')->pluck('id')->all();
        $courseIds = DB::table('courses')->pluck('id')->all();

        if (empty($students) || empty($courseIds)) {
            return; // Require users and courses first
        }

        foreach ($students as $studentId) {
            $enrollCount = rand(1, min(3, count($courseIds)));
            $selected = collect($courseIds)->shuffle()->take($enrollCount);
            foreach ($selected as $courseId) {
                DB::table('enrollments')->updateOrInsert(
                    ['user_id' => $studentId, 'course_id' => $courseId],
                    [
                        'user_id' => $studentId,
                        'course_id' => $courseId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
