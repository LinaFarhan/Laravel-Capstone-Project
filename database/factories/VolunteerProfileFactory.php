<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteerProfile>
 */
class VolunteerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // database/factories/VolunteerProfileFactory.php
public function definition(): array
{
    $faker= \Faker\Factory::create('ar _SA');
    return [
        'user_id' => User::factory(), // سيُنشئ user تلقائياً
        'phone' =>'04'. $faker->numerify('###########'),
        'address' =>$faker->city().'،حي '. $faker->word(),
        'skills' =>$faker->randomElement(['إدارة', 'اتصال', 'إسعافات أولية','لوجستيات']),
    ];
}
}
