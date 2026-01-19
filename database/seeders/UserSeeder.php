<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\StaffGereja;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

  public function run(): void
  {
    User::firstOrCreate([
      'name' => 'Admin',
      'email' => 'admin@gmail.com',
      'password' => bcrypt('Admin123'),
      'role' => 'admin',
      'status' => 'aktif',
    ]);
  }
}
