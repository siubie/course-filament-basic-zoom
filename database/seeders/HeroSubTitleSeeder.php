<?php

namespace Database\Seeders;

use App\Models\HeroSubTitle;
use Illuminate\Database\Seeder;

class HeroSubTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSubTitle::factory()->count(5)->create();
    }
}
