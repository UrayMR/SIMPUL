<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            $course = Course::find($enrollment->course_id);
            if (! $course) {
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
