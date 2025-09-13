<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Factory as FakerFactory;
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
     $faker= FakerFactory::create('ar _SA');
     $cities=['تعز','صنعاء', 'عدن','المكلا','مارب','سقطرى','الجوف'];
    return [
        'beneficiary_id' => User::factory(), // ينشئ مستفيد (user) تلقائياً
        'title' => fake()->sentence(3),
        'description' => fake()->paragraph(),
        'quantity' => fake()->numberBetween(1, 5),
        'id_card_path' => 'ids/' . fake()->word() . '.jpg',
        'address' => fake()->address(),
        'city' => $faker->randomElement($cities),
        'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
        'rejection_reason'=>$faker->optional()->sentence()
    ];
}
}
