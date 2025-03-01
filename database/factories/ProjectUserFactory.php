<?php

namespace Database\Factories;

use App\Models\ProjectUser;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectUserFactory extends Factory
{
    protected $model = ProjectUser::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
        ];
    }
}
