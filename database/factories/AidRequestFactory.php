<?php
 
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AidRequestFactory extends Factory
{
    public function definition(): array
    {
        $types = ['food', 'clothing', 'medical', 'financial', 'other'];
        $statuses = ['pending', 'approved', 'denied'];
        
        return [
            'beneficiary_id' => User::factory()->beneficiary(),
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'document_url' => $this->faker->optional(0.7)->url(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    public function denied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'denied',
        ]);
    }

    public function food(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'food',
        ]);
    }

    public function medical(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'medical',
        ]);
    }
}