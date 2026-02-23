<?php

namespace Yakamara\Roadie\Component\Textarea;

enum TextareaResize: string
{
    case None = 'none';
    case Vertical = 'vertical';
    case Horizontal = 'horizontal';
    case Both = 'both';
    case Auto = 'auto';
}
