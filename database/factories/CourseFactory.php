<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'teacher_id' => fn() => \App\Models\Teacher::factory(),
            'category_id' => fn() => \App\Models\Category::factory(),
            'thumbnail_path' => $this->faker->optional()->imageUrl(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'price' => $this->faker->randomFloat(2, 0, 1000000),
            'video_url' => $this->faker->optional()->url(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'enrollments_count' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
