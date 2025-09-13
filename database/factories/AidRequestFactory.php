<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AidRequest>
 */
class AidRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
  // database/factories/AidRequestFactory.php
public function definition(): array
{
    return [
        'beneficiary_id' => User::factory(), // ينشئ مستفيد (user) تلقائياً
        'title' => fake()->sentence(),
        'description' => fake()->paragraph(),
        'quantity' => fake()->numberBetween(1, 5),
        'id_card_path' => 'ids/' . fake()->word() . '.jpg',
        'address' => fake()->address(),
        'city' => fake()->city(),
        'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
    ];
}
}
