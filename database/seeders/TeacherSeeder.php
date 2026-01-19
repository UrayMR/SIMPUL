<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = DB::table('users')->where('role', 'teacher')->get(['id', 'name']);

        foreach ($teachers as $t) {
            DB::table('teachers')->updateOrInsert(
                ['user_id' => $t->id],
                [
                    'bio' => 'Experienced instructor in various subjects.',
                    'expertise' => 'General',
                    'phone_number' => '0800000000',
                    'profile_image' => null,
                    'approved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
