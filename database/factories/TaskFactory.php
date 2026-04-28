<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>fake()->sentence(),
            'description'=>fake()->paragraph(),
            'status'=>fake()->randomElement(['todo','in_progress','done']),
            'due_date'=>fake()->optional()->dateTimeBetween('-3 days','+7 days'),
            'user_id'=>User::inRandomOrder()->first()->id,
            'category_id'=>Category::inRandomOrder()->first()->id,
        ];
    }
}