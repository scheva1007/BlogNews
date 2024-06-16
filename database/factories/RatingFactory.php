<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Rating::class;

    public function definition()
    {
        return [
            'news_id' => News::factory(),
            'grade' => $this->faker->numberBetween(1, 5),
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
