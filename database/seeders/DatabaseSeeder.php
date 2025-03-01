<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Attribute;
use App\Models\Timesheet;
use App\Models\ProjectUser;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@gmail.com'
        ]);
        User::factory()->create([
            'first_name' => 'Ritta',
            'last_name' => 'Ibrahim',
            'email' => 'ritta.m.ibrahim@gmail.com'
        ]);


        Project::factory()->create([
            'name' => 'ASTUDIO test'
        ]);
        Project::factory()->create([
            'name' => 'User managment system'
        ]);


        Attribute::factory()->create([
            'name' => 'department',
            'type' => 'text'
        ]);
        Attribute::factory()->create([
            'name' => 'start_date',
            'type' => 'date'
        ]);
        Attribute::factory()->create([
            'name' => 'end_date',
            'type' => 'date'
        ]);
        Attribute::factory()->create([
            'name' => 'design_color',
            'type' => 'select'
        ]);
        Attribute::factory()->create([
            'name' => 'team',
            'type' => 'number'
        ]);
    }
}
