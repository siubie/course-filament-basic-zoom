<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Hero;
use App\Models\HeroSubTitle;

class HeroSubTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HeroSubTitle::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->word(),
            'hero_id' => Hero::factory(),
        ];
    }
}
