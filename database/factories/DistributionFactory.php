<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distribution>
 */
class DistributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // نحتاج التأكد من وجود متطوعين في قاعدة البيانات أولاً
        // نستخدم User::inRandomOrder()->first()?->id للحصول على ID موجود
        // أو ننشئ مستخدم جديد إذا لم يوجد
        $volunteer = User::factory()->create();

        return [
            'volunteer_id' => $volunteer->id,
            'title' => $this->faker->sentence(3),
            'location' => $this->faker->address(),
            'distribution_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['scheduled', 'in_progress', 'completed']),
        ];
    }
}
