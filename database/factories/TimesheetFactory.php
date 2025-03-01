<?php

namespace Database\Factories;

use App\Models\Timesheet;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimesheetFactory extends Factory
{
    protected $model = Timesheet::class;

    public function definition(): array
    {
        return [
            'task_name' => $this->faker->sentence(4),
            'hours' => $this->faker->randomFloat(2, 1, 8),
            'user_id' => User::inRandomOrder()->first()?->id,
            'project_id' => Project::inRandomOrder()->first()?->id,
            'created_by' => User::inRandomOrder()->first()?->id,
            'updated_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
