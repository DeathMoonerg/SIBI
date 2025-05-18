<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'parent',
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin SIBI',
            'email' => 'admin@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
        ]);
    }

    public function parent(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Orang Tua SIBI',
            'email' => 'ortu@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'parent',
            'phone' => '081234567891',
            'address' => 'Jl. Orang Tua No. 1',
        ]);
    }

    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Guru SIBI',
            'email' => 'guru@bimbelalfarizqi.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'phone' => '081234567892',
            'address' => 'Jl. Guru No. 1',
        ]);
    }
}
