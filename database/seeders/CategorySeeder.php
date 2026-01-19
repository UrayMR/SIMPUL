<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Programming', 'description' => 'Learn to code with modern languages.'],
            ['name' => 'Design', 'description' => 'UI/UX and graphic design fundamentals.'],
            ['name' => 'Marketing', 'description' => 'Digital marketing strategies and tools.'],
            ['name' => 'Photography', 'description' => 'Master camera basics and editing.'],
            ['name' => 'Business', 'description' => 'Entrepreneurship, finance, and operations.'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'slug' => Str::slug($cat['name']),
                    'description' => $cat['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
