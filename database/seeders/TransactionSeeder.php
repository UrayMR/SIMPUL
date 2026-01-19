<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = DB::table('enrollments')->get(['user_id', 'course_id']);

        foreach ($enrollments as $enrollment) {
            $course = DB::table('courses')->where('id', $enrollment->course_id)->first(['price']);
            if (!$course) {
                continue;
            }

            DB::table('transactions')->updateOrInsert(
                [
                    'user_id' => $enrollment->user_id,
                    'course_id' => $enrollment->course_id,
                ],
                [
                    'amount' => $course->price,
                    'payment_proof_image' => null,
                    'status' => rand(0, 1) ? 'approved' : 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
