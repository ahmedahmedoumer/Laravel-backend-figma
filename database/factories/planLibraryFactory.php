<?php

namespace Database\Factories;

use App\Models\planLibrary;
use App\Models\User;
use App\Models\brands;
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
