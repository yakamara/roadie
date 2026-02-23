<?php

namespace Yakamara\Roadie\Component\Image;

class ImageLowQualityPlaceholder
{
    public function __construct(
        public string $mediaManagerType,

        public bool $preload = false,
    ) {}
}
