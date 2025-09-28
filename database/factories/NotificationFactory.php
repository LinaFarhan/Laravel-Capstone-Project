<?php
 
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;

class NotificationFactory extends Factory
{
   protected $model = \App\Models\Notification::class;


    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'type' => $this->faker->randomElement([
                'App\Notifications\AidRequestApprovedNotification',
                'App\Notifications\AidRequestDeniedNotification',
                'App\Notifications\DistributionAssignedNotification',
                'App\Notifications\DonationReceivedNotification'
            ]),
            'notifiable_type' => 'App\Models\User',
            'notifiable_id' => \App\Models\User::factory(),
            'data' => json_encode([
                'message' => $this->faker->sentence,
                'action_url' => $this->faker->url,
                'type' => $this->faker->randomElement(['success', 'warning', 'info', 'error'])
            ]),
            'read_at' => $this->faker->optional()->dateTime(),
        ];
    }

    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now(),
        ]);
    }
}