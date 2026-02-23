<?php

namespace Yakamara\Roadie\Component\Button;

enum ButtonTarget: string
{
    case Blank = '_blank';
    case Parent = '_parent';
    case Self = '_self';
    case Top = '_top';
}
