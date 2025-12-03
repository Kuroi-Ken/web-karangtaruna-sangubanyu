<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'activity' => $this->faker->randomElement([
                'Kegiatan Desa A',
                'Kegiatan Desa B',
                'Kegiatan Desa C',
                'Kegiatan Desa D',
            ]),
            'slug' => Str::slug(fake()->sentence(rand(1,2),false))
        ];
    }
}