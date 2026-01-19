<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teacherUsers = \App\Models\User::where('role', 'teacher')->get();
        foreach ($teacherUsers as $user) {
            \App\Models\Teacher::factory()->create(['user_id' => $user->id]);
        }
    }
}
