<?php

namespace Yakamara\Roadie\Component\FormatDate;

enum FormatDateMonth: string
{
    case Numeric = 'numeric';
    case TwoDigit = '2-digit';
    case Narrow = 'narrow';
    case Short = 'short';
    case Long = 'long';
}
