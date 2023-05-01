<?php

namespace Database\Seeders;

use App\Models\brands;
use App\Models\company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class brandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        company::factory(50)->create();
    }
}
