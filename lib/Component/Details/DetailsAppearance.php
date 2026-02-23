<?php

namespace Yakamara\Roadie\Component\Details;

enum DetailsAppearance: string
{
    case Filled = 'filled';
    case Outlined = 'outlined';
    case FilledOutlined = 'filled-outlined';
    case Plain = 'plain';
}
