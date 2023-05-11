<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\brands;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\designs>
 */
class designsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands_id=brands::pluck('id')->toArray();
        $designner_id=User::pluck('id')->where('title','designner')->toArray();
        return [
            //
            'brands_id'=>$this->faker->unique()->randomElement($brands_id),
            'designner'=>function(){ return User::where('title','designner')->pluck('id')->unique()->random(); },
             'textOnPost'=>$this->faker->sentence($maxChars=30),
             'status'=>$this->faker->randomElement(['Need Edit','pending','New']),
        ];
    }
}
