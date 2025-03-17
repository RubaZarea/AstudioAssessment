<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
        $projects = Project::inRandomOrder()->take(rand(1, 3))->pluck('id');

        return [
            'user_id' => fake()->randomElement($users),
            'project_id' => fake()->randomElement($projects),
            'task_name' => 'task ' . fake()->unique()->randomNumber(),
            'date' => fake()->date(),
            'hours' => fake()->numberBetween(0, 24)
        ];
    }
}
