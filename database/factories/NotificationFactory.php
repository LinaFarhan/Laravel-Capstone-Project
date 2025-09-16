<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // إنشاء مستخدم جديد مرتبط
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['unread', 'read']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
