<?php

namespace Yakamara\Roadie\Component\RelativeTime;

enum RelativeTimeFormat: string
{
    case Long = 'long';
    case Short = 'short';
    case Narrow = 'narrow';
}
