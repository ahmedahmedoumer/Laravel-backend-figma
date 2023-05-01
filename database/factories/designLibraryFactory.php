<?php

namespace Database\Factories;

use App\Models\designLibrary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\designLibrary>
 */
class designLibraryFactory extends Factory
{
    protected $model = designLibrary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designer_id' => $this->faker->numberBetween(1, 3),
            'brands_id' => $this->faker->unique()->numberBetween(1, 50),
            'designTitle' => $this->faker->unique()->sentence(),
            'image' => $this->faker->imageUrl(640, 400),
            'sourceFile' => 'public/storage/File',
            'image' => 'public/storage/File',
            'status' => $this->faker->randomElement(['approved', 'pending', 'not active', 'needEdit']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
