<?php

namespace Yakamara\Roadie\Component\FormatBytes;

enum FormatBytesDisplay: string
{
    case Long = 'long';
    case Short = 'short';
    case Narrow = 'narrow';
}
