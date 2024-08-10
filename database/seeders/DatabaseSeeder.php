<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\PortfolioCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        //call database seeder
        $this->call([
            HeroSeeder::class,
            HeroSubTitleSeeder::class,
            ClientSeeder::class,
            ServiceSeeder::class,
            PortfolioSeeder::class,
            PortfolioCategorySeeder::class,
            ContactSeeder::class,
            TeamSeeder::class,
            TeamSocialSeeder::class
        ]);
    }
}
