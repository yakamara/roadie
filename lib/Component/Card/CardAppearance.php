<?php

namespace Yakamara\Roadie\Component\Card;

enum CardAppearance: string
{
    case Accent = 'accent';
    case Filled = 'filled';
    case Outlined = 'outlined';
    case FilledOutlined = 'filled-outlined';
    case Plain = 'plain';
}
