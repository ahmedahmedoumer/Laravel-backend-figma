<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\notification>
 */
class notificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id=User::pluck('id')->toArray();
        return [
            //
            'users_id'=>$this->faker->randomElement($user_id),
            'title'=>$this->faker->unique->text(),
            'detail'=>$this->faker->unique->text(),
            'status'=>$this->faker->randomElement(['new','seen']),
        ];
    }
}
