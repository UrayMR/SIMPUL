<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Transaction;
use App\Models\Course;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            $course = Course::find($enrollment->course_id);
            if (!$course) {
                continue; // skip kalau course tidak ditemukan
            }

            Transaction::factory()->create([
                'user_id' => $enrollment->user_id,
                'course_id' => $enrollment->course_id,
                'amount' => $course->price,
            ]);
        }
    }
}
