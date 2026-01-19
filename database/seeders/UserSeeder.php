<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    // Admin user
    DB::table('users')->updateOrInsert(
      ['email' => 'admin@example.com'],
      [
        'name' => 'Admin',
        'password' => Hash::make('Admin123'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
        'remember_token' => null,
        'updated_at' => now(),
        'created_at' => now(),
      ]
    );

    // Seed teachers
    foreach (range(1, 3) as $i) {
      DB::table('users')->updateOrInsert(
        ['email' => "teacher{$i}@example.com"],
        [
          'name' => "Teacher {$i}",
          'password' => Hash::make('Teacher123'),
          'role' => 'teacher',
          'status' => 'active',
          'email_verified_at' => now(),
          'remember_token' => null,
          'updated_at' => now(),
          'created_at' => now(),
        ]
      );
    }

    // Seed students
    foreach (range(1, 10) as $i) {
      DB::table('users')->updateOrInsert(
        ['email' => "student{$i}@example.com"],
        [
          'name' => "Student {$i}",
          'password' => Hash::make('Student123'),
          'role' => 'student',
          'status' => 'active',
          'email_verified_at' => now(),
          'remember_token' => null,
          'updated_at' => now(),
          'created_at' => now(),
        ]
      );
    }
  }
}
