<?php

namespace Yakamara\Roadie\Component\Image;

use function array_key_exists;

class ImageBreakpointValues
{
    private static array $breakpoints = [
        ImageBreakpoint::Xs->name => 0,
        ImageBreakpoint::Sm->name => 320,
        ImageBreakpoint::Md->name => 768,
        ImageBreakpoint::Lg->name => 1024,
        ImageBreakpoint::Xl->name => 1280,
    ];

    public static function setValues(array $values): void
    {
        foreach ($values as $name => $value) {
            if (array_key_exists($name, self::$breakpoints)) {
                self::$breakpoints[$name] = $value;
            }
        }
    }

    public static function getValue(ImageBreakpoint $breakpoint): int
    {
        return self::$breakpoints[$breakpoint->name];
    }
}
