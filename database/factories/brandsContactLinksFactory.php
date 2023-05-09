<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\brands;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\brandsContactLinks>
 */
class brandsContactLinksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = brands::pluck('id')->toArray();
        return [
            'brands_id' =>$this->faker->unique()->randomElement($user_id),
            'tiktok' => $this->faker->unique->url(),
            'facebook' => $this->faker->unique->url(),
            'twitter' => $this->faker->unique()->url(),
            'instagram' => $this->faker->unique()->url(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
