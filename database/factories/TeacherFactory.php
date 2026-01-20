<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn() => \App\Models\User::factory(),
            'bio' => $this->faker->optional()->paragraph(),
            'expertise' => $this->faker->optional()->word(),
            'profile_image_path' => $this->faker->optional()->imageUrl(),
            'approved_at' => $this->faker->optional()->dateTime(),
        ];
    }
}
