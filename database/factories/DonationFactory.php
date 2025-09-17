<?php
 
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    public function definition(): array
    {
        $types = ['food', 'clothing', 'medical', 'financial', 'other'];
        $statuses = ['pending', 'received', 'distributed', 'expired'];
        
        return [
            'donor_name' => $this->faker->company(),
            'type' => $this->faker->randomElement($types),
            'quantity' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement($statuses),
            'description' => $this->faker->sentence(),
        ];
    }

    public function food(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'food',
            'quantity' => $this->faker->numberBetween(10, 1000),
        ]);
    }

    public function clothing(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'clothing',
            'quantity' => $this->faker->numberBetween(5, 500),
        ]);
    }

    public function medical(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'medical',
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
    }

    public function financial(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'financial',
            'quantity' => $this->faker->numberBetween(100, 10000),
        ]);
    }
}