<?php

namespace App\Enums;

enum AttributeTypes: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case SELECT = 'select';
    case DATE = 'date';
}
