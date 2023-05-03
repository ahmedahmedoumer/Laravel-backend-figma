<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\brandsCompany;
use App\Models\brands;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\brandsCompany>
 */
class brandsCompanyFactory extends Factory
{
    protected $model = brandsCompany::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $user_id=brands::pluck('id')->toArray();
        return [
            'brands_id' =>$this->faker->unique()->randomElement($user_id),
            'companyName' => $this->faker->name(),
            'companyWebsite' => $this->faker->url(),
            'companyNumber' => $this->faker->unique()->phoneNumber(),
            'companyDescription' => $this->faker->unique()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
