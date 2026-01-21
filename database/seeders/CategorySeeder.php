<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Teknologi Informasi',
                'slug' => 'teknologi-informasi',
                'description' => 'Kursus dan pelatihan seputar teknologi, pemrograman, dan IT.',
            ],
            [
                'name' => 'Bisnis & Manajemen',
                'slug' => 'bisnis-manajemen',
                'description' => 'Materi bisnis, manajemen, pemasaran, dan kewirausahaan.',
            ],
            [
                'name' => 'Bahasa',
                'slug' => 'bahasa',
                'description' => 'Pembelajaran bahasa asing dan lokal.',
            ],
            [
                'name' => 'Desain & Kreatif',
                'slug' => 'desain-kreatif',
                'description' => 'Desain grafis, UI/UX, fotografi, dan seni kreatif.',
            ],
            [
                'name' => 'Pengembangan Diri',
                'slug' => 'pengembangan-diri',
                'description' => 'Soft skill, motivasi, dan pengembangan kepribadian.',
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Materi pendidikan formal dan non-formal.',
            ],
            [
                'name' => 'Keuangan & Akuntansi',
                'slug' => 'keuangan-akuntansi',
                'description' => 'Akuntansi, keuangan, dan investasi.',
            ],
            [
                'name' => 'Kesehatan & Kesejahteraan',
                'slug' => 'kesehatan-kesejahteraan',
                'description' => 'Kesehatan, kebugaran, dan kesejahteraan.',
            ],
            [
                'name' => 'Pemasaran Digital',
                'slug' => 'pemasaran-digital',
                'description' => 'Digital marketing, SEO, dan media sosial.',
            ],
            [
                'name' => 'Hobi & Gaya Hidup',
                'slug' => 'hobi-gaya-hidup',
                'description' => 'Hobi, kerajinan, dan gaya hidup.',
            ],
            [
                'name' => 'Pertanian & Peternakan',
                'slug' => 'pertanian-peternakan',
                'description' => 'Ilmu dan praktik pertanian, peternakan, dan agribisnis.',
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'description' => 'Kategori lainnya yang tidak tercakup.',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate([
                'slug' => $category['slug'],
            ], $category);
        }
    }
}
