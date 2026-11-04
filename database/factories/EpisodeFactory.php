<?php

namespace Database\Factories;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->numberBetween(1, 100000),
            'name' => fake()->sentence(3),
            'air_date' => fake()->date('F j, Y'),
            'episode' => 'S01E'.fake()->unique()->numberBetween(1, 99),
        ];
    }
}
