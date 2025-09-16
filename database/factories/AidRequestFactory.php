<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AidRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'beneficiary_id' => User::factory(), // سينشئ مستفيد جديد
            'type' => $this->faker->randomElement(['medical', 'financial', 'food', 'shelter']),
            'description' => $this->faker->sentence(10),
            'status' => $this->faker->randomElement(['pending', 'approved', 'denied']),
            'document_url' => 'documents/' . $this->faker->word() . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
