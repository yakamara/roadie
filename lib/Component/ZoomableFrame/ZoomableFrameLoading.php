<?php

namespace Yakamara\Roadie\Component\ZoomableFrame;

enum ZoomableFrameLoading: string
{
    case Eager = 'eager';
    case Lazy = 'lazy';
}
