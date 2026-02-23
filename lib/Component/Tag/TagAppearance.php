<?php

namespace Yakamara\Roadie\Component\Tag;

enum TagAppearance: string
{
    case Accent = 'accent';
    case Filled = 'filled';
    case Outlined = 'outlined';
    case FilledOutlined = 'filled-outlined';
}
