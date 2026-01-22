<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = \App\Models\Enrollment::all();
        foreach ($enrollments as $enrollment) {
            $course = \App\Models\Course::find($enrollment->course_id);
            if (! $course) {
                continue;
            }
            \App\Models\Transaction::factory()->create([
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
                'amount' => $course->price,
            ]);
        }
    }
}
