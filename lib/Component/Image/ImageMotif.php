<?php

namespace Yakamara\Roadie\Component\Image;

class ImageMotif
{
    public function __construct(
        public string $mediaManagerType,

        public ImageBreakpoint $fromBreakpoint,

        public ?string $sizes = null,
    ) {}
}
