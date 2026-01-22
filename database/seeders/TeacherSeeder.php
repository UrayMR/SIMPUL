<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = User::where('role', User::ROLE_TEACHER)->get();

        foreach ($teachers as $user) {
            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $this->getBioByName($user->name),
                    'expertise' => $this->getExpertiseByName($user->name),
                    'profile_picture_path' => null,
                    'approved_at' => now(),
                ]
            );
        }
    }

    private function getBioByName(string $name): string
    {
        return match ($name) {
            'Ahmad Fauzi' => 'Pengajar berpengalaman di bidang Matematika dan Logika Dasar dengan lebih dari 7 tahun pengalaman mengajar di berbagai institusi pendidikan. Ia memiliki pendekatan pembelajaran yang sistematis, mudah dipahami, dan berfokus pada pemahaman konsep secara mendalam.',

            'Siti Aisyah' => 'Pengajar profesional di bidang Teknologi Informasi dan Web Development. Berpengalaman dalam pengembangan aplikasi berbasis web menggunakan Laravel dan JavaScript, ia aktif membimbing peserta didik untuk siap menghadapi dunia industri.',

            'Budi Santoso' => 'Praktisi dan pengajar di bidang Desain Grafis dan UI/UX. Dengan pengalaman lebih dari 5 tahun di industri kreatif, ia berfokus pada pembelajaran berbasis proyek dan studi kasus nyata.',

            default => 'Pengajar berpengalaman dengan dedikasi tinggi dalam dunia pendidikan dan pengembangan kompetensi peserta didik.',
        };
    }

    private function getExpertiseByName(string $name): string
    {
        return match ($name) {
            'Ahmad Fauzi' => 'Matematika, Logika, Aljabar',
            'Siti Aisyah' => 'Web Development, Laravel, JavaScript',
            'Budi Santoso' => 'UI/UX Design, Graphic Design',
            default => 'General Teaching',
        };
    }
}
