<?php

namespace Database\Seeders;

use App\Models\notification;
use App\Models\brands;
use App\Models\User;
use App\Models\plans;
use App\Models\designs;
use App\Models\brandsCompany;
use App\Models\brandsContactLinks;
use App\Models\company;
use App\Models\designLibrary;
use App\Models\planLibrary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('users')->insert([
        //     'firstName' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        User::factory(50)->create(); //generate 50 rows of data for User model
        brands::factory(50)->create();//generate 50 rows of data for brands model;
        brandsCompany::factory(40)->create(); //generate 50 rows of data for brandsCompany model;
        planLibrary::factory(30)->create(); //generate 30 rows of data for planLibrary model;
        designLibrary::factory(20)->create(); //generate 20 rows of data for designLibrary model;
        notification::factory(10)->create();   //generate 10 rows of data for notification model;
        plans::factory(10)->create();   //generate 10 rows of data for plans model;
        designs::factory(10)->create();   //generate 10 rows of data for design model;





    }
}
