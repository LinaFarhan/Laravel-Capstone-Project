<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Donation;

class DistributionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'volunteer_id' => User::factory(),   // سينشئ متطوع جديد
            'beneficiary_id' => User::factory(), // سينشئ مستفيد جديد
            'donation_id' => Donation::factory(),
            'delivery_status' => $this->faker->randomElement(['pending', 'delivered']),
            'proof_file' => 'proofs/' . $this->faker->word() . '.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
