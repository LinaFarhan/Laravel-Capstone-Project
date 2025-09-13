<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
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
           $faker= FakerFactory::create('ar _SA');
        $cities=['تعز','صنعاء', 'عدن','المكلا','مارب','سقطرى','الجوف'];
        return [
            'volunteer_id' => User::factory(),
            'title' =>$faker->sentence(2),
            'location' =>$faker->address(),
            'distribution_date' =>$faker->dateTimeBetween('now', '+1 month'),
            'status' => $this->faker->randomElement(['scheduled', 'in_progress', 'completed']),
        ];
    }
}
