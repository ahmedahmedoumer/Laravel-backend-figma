<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return [
            'firstName' => fake()->name(),
            'lastName' => fake()->name(),
            'phone'=>fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'title'=>$this->faker->randomElement(['manager','admin','designner','planner']),
            'password'=>Hash::make('password'),
            'status'=>$this->faker->randomElement(['pending','approved','needEdit','not active']),
           'joiningDate'=>$this->faker->date(),
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
}
