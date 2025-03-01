<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeValueFactory extends Factory
{
    protected $model = AttributeValue::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word,
            'attribute_id' => Attribute::inRandomOrder()->first()?->id,
            'project_id' => Project::inRandomOrder()->first()?->id,
        ];
    }
}
