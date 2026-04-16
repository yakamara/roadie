<?php

namespace Yakamara\Roadie\Component\Image;

class ImageMotif
{
    public function __construct(
        public string $mediaManagerType,

        public ImageBreakpoint $fromBreakpoint,

        public ?string $sizes = null,

        /** Resolutions for this breakpoint; null falls back to the global resolutions of the Image component. */
        public array|ImageResolution|null $resolutions = null,
    ) {}
}
