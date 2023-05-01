<?php

namespace Database\Factories;

use App\Models\planLibrary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\planLibrary>
 */
class planLibraryFactory extends Factory
{
    protected $model=planLibrary::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'planner_id' => $this->faker->numberBetween(1, 3),
            'brands_id' => $this->faker->unique()->numberBetween(1, 50),
            'planTitle' => $this->faker->unique()->sentence(),
            'planDescription' => $this->faker->text(),
            'planPrompt' => $this->faker->text(),
            'sourceFile' => 'public/storage/File',
            'status' => $this->faker->randomElement(['approved', 'pending', 'not active', 'needEdit']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
