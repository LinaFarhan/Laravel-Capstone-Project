<?php
 
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $roles = ['admin', 'volunteer', 'beneficiary'];
        $role = $this->faker->randomElement($roles);
        
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => $role,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'document_path' => $role === 'beneficiary' ? 'documents/' . $this->faker->uuid() . '.pdf' : null,
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'document_path' => null,
        ]);
    }

    public function volunteer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'volunteer',
            'document_path' => null,
        ]);
    }

    public function beneficiary(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'beneficiary',
            'document_path' => 'documents/' . $this->faker->uuid() . '.pdf',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}