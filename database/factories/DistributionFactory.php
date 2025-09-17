<?php
 
namespace Database\Factories;

use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributionFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['assigned', 'in_progress', 'delivered', 'cancelled'];
        
        return [
            'volunteer_id' => User::factory()->volunteer(),
            'beneficiary_id' => User::factory()->beneficiary(),
            'donation_id' => Donation::factory(),
            'aid_request_id' => AidRequest::factory(),
            'delivery_status' => $this->faker->randomElement($statuses),
            'proof_file' => $this->faker->optional(0.6)->url(),
            'notes' => $this->faker->optional(0.4)->sentence(),
        ];
    }

    public function assigned(): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_status' => 'assigned',
            'proof_file' => null,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_status' => 'in_progress',
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_status' => 'delivered',
            'proof_file' => 'proofs/' . $this->faker->uuid() . '.jpg',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_status' => 'cancelled',
            'notes' => $this->faker->sentence(),
        ]);
    }
}