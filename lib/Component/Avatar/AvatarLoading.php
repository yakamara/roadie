<?php

namespace Yakamara\Roadie\Component\Avatar;

enum AvatarLoading: string
{
    case Eager = 'eager';
    case Lazy = 'lazy';
}
