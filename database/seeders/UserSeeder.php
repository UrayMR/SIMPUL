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

    \App\Models\User::factory(25)->state(['role' => 'teacher'])->create();
    \App\Models\User::factory(15)->state(['role' => 'student'])->create();
  }
}
