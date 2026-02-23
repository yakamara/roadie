<?php

namespace Yakamara\Roadie\Trait;

trait EnumToArrayTrait
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function arrayByValues(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function arrayByNames(): array
    {
        return array_combine(self::names(), self::values());
    }
}
