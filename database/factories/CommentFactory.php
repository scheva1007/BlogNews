<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content' => $this->faker->paragraph,
            'news_id' => News::factory(),
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'countLikes' => $this->faker->numberBetween(0, 20),
            'countDisLikes' => $this->faker->numberBetween(0, 10),
        ];
    }
}
