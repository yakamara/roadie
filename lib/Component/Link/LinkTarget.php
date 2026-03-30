<?php

namespace Yakamara\Roadie\Component\Link;

enum LinkTarget: string
{
    case Blank = '_blank';
    case Parent = '_parent';
    case Self = '_self';
    case Top = '_top';
}
