<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = News::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1,5),
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
