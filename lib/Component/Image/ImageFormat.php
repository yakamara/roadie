<?php

namespace Yakamara\Roadie\Component\Image;

use Yakamara\Roadie\Trait\EnumToArrayTrait;

enum ImageFormat: string
{
    use EnumToArrayTrait;
    case Avif = 'image/avif';
    case Jpg = 'image/jpeg';
    case Png = 'image/png';
    case Webp = 'image/webp';

    public static function getExtensions(): array
    {
        return [
            'avif' => ImageFormat::Avif,
            'jpg' => ImageFormat::Jpg,
            'jpeg' => ImageFormat::Jpg,
            'png' => ImageFormat::Png,
            'webp' => ImageFormat::Webp,
        ];
    }
}
