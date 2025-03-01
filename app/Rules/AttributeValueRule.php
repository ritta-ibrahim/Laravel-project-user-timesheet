<?php

namespace App\Rules;

use Illuminate\Validation\Rule;
use App\Models\Attribute;

class AttributeValueRule extends Rule
{
    protected $attributeId;

    public function __construct($attributeId)
    {
        $this->attributeId = $attributeId;
    }

    public function passes($attribute, $value)
    {
        $attributeModel = Attribute::find($this->attributeId);

        if (!$attributeModel) {
            return false;
        }

        return match ($attributeModel->type) {
            'text' => is_string($value) && strlen($value) <= 255,
            'number' => is_numeric($value),
            'date' => strtotime($value) !== false,
            'select' => is_array($value),
            default => false
        };
    }

    public function message()
    {
        return 'The :attribute field is invalid for its attribute type.';
    }
}
