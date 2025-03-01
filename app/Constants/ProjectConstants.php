<?php

namespace App\Constants;

class ProjectConstants
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    public static function getStatus()
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE
        ];
    }

    public static function getStatusLable()
    {
        return [
            self::STATUS_ACTIVE => __('general.active'),
            self::STATUS_INACTIVE => __('general.inactive'),
        ];
    }
}
