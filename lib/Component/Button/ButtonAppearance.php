<?php

namespace Yakamara\Roadie\Component\Button;

enum ButtonAppearance: string
{
    case Accent = 'accent';
    case Filled = 'filled';
    case FilledOutlined = 'filled-outlined';
    case Outlined = 'outlined';
    case Plain = 'plain';
}
