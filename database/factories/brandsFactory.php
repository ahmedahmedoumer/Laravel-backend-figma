<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Str;
use App\Models\brands;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\brands>
 */
class brandsFactory extends Factory
{
    protected $model = brands::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => $this->faker->name(),
            'lastname' => $this->faker->name(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => $this->faker->phoneNumber(),
            'location' => $this->faker->text($maxNbChars = 10),
            'title' => $this->faker->unique()->sentence(),
            'creationStatus' => $this->faker->text(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'planners_id'=>function(){$user=User::where('title','planner')->inRandomOrder()->First();  return $user ? $user->id : null;  },
            'designers_id' =>function(){$user=User::where('title','designner')->inRandomOrder()->First();  return $user ? $user->id : null;  },
        ];
    }
    public function configure(){
        return $this->afterCreating(function (brands $brands) {
            while($brands->planners_id==$brands->designers_id){
                $brands->designers_id=$this->faker->unique()->numberBetween(1,50);
                $project->save();
            }
        });
    }
}
