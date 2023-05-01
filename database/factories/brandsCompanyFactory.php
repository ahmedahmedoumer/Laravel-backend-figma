<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\brandsCompany;

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
        return [
            'brands_id' => $this->faker->unique()->numberBetween(1, 50),
            'companyName' => $this->faker->name(),
            'companyWebsite' => $this->faker->url(),
            'companyNumber' => $this->faker->unique()->phoneNumber(),
            'companyDescription' => $this->faker->unique()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
