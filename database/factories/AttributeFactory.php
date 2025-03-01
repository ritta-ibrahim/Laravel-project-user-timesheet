<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Enums\AttributeTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'type' => $this->faker->randomElement(AttributeTypes::cases())->value,
        ];
    }
}
