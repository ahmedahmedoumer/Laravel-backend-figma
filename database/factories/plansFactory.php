<?php

namespace Database\Factories;
use App\Models\brands;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\plans>
 */
class plansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands_id=brands::pluck('id')->toArray();
        $planner_id=User::pluck('id')->where('title','planner')->toArray();
        return [
            //
            'brands_id'=>$this->faker->unique()->randomElement($brands_id),
            'planner'=>function(){ return User::where('title','planner')->pluck('id')->unique()->random(); },
            'textOnPost'=>$this->faker->unique()->sentence($maxChars=30),
            'caption'=>$this->faker->text(),
            'hashTag'=>$this->faker->text(),
            'status'=>$this->faker->randomElement(['pending','Need Edit','new']),
        ];
    }
}
