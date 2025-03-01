<?php

namespace App\Enums;

use App\Constants\ProjectConstants;

enum ProjectStatus: int
{
    case ACTIVE = ProjectConstants::STATUS_ACTIVE;
    case INACTIVE = ProjectConstants::STATUS_INACTIVE;
}
