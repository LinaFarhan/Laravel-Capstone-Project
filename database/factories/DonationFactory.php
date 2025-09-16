<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'donor_name' => $this->faker->name(),
            'type' => $this->faker->randomElement(['food', 'clothes', 'money', 'medical']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(['pending', 'approved', 'denied']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
