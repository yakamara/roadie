<?php

namespace Yakamara\Roadie\Component\Callout;

enum CalloutAppearance: string
{
    case Accent = 'accent';
    case Filled = 'filled';
    case Outlined = 'outlined';
    case Plain = 'plain';
    case FilledOutlined = 'filled-outlined';
}
