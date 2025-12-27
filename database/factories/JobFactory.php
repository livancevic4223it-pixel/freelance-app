<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'budget' => fake()->numberBetween(-10000, 10000),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
