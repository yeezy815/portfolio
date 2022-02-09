<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class DairyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'score' => $this->faker->word,
            'experience' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'album_id'  => Album::inRandomOrder()->first()->id
        ];
    }
}
