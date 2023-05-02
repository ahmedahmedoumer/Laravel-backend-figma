<?php

namespace Database\Factories;

use App\Models\designLibrary;
use App\Models\User;
use App\Models\brands;
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
         $user_id=User::where('title','designner')->pluck('id')->toArray();
         $brand_id=brands::pluck('id')->toArray();
        return [
            //
            'designer_id' => $this->faker->randomElement($user_id),
            'brands_id' => $this->faker->randomElement($brand_id),
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
