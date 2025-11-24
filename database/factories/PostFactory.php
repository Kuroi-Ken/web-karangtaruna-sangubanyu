<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // protected $model = Post::class;
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10, false), 
            'author_id' => User::factory(),
            'body' => fake()->text(10000),
            'cate_id' => Category::factory(),
        ];
    }
};