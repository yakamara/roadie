<?php

namespace Yakamara\Roadie\Component\Badge;

enum BadgeAppearance: string
{
    case Accent = 'accent';
    case Filled = 'filled';
    case Outlined = 'outlined';
    case FilledOutlined = 'filled-outlined';
}
