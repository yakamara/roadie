<?php

namespace Yakamara\Roadie\Component\Image;

use function array_key_exists;

class ImageResolutionValues
{
    private static array $resolutions = [
        ImageResolution::Small->name => [200, 400, 800],
        ImageResolution::Medium->name => [1200, 1600],
        ImageResolution::Large->name => [1920, 2400],
        ImageResolution::All->name => [
            ...[200, 400, 800],
            ...[1200, 1600],
            ...[1920, 2400],
        ],
    ];

    public static function setValues(array $values): void
    {
        foreach ($values as $name => $value) {
            if (array_key_exists($name, self::$resolutions)) {
                self::$resolutions[$name] = $value;
            }
        }
        self::$resolutions[ImageResolution::All->name] = [
            ...self::$resolutions[ImageResolution::Small->name],
            ...self::$resolutions[ImageResolution::Medium->name],
            ...self::$resolutions[ImageResolution::Large->name],
        ];
    }

    public static function getValue(ImageResolution $resolution): array
    {
        return self::$resolutions[$resolution->name];
    }
}
