<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    \App\Models\User::firstOrCreate(
      ['email' => 'admin@example.com'],
      [
        'name' => 'Admin',
        'password' => bcrypt('Admin123'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
        'remember_token' => null,
      ]
    );

    \App\Models\User::factory(3)->state(['role' => 'teacher'])->create();
    \App\Models\User::factory(10)->state(['role' => 'student'])->create();
  }
}
