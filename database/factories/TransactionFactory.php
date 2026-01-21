<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'course_id' => fn() => \App\Models\Course::factory(),
            'amount' => $this->faker->randomFloat(2, 10000, 1000000),
            'payment_proof_path' => $this->faker->optional()->imageUrl(),
            'status' => $this->faker->randomElement(['approved', 'pending', 'rejected']),
            'payment_token' => $this->faker->optional()->uuid(),
            'payment_token_expires_at' => $this->faker->optional()->dateTimeBetween('now', '+15 minutes'),
        ];
    }
}
