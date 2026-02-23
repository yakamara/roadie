<?php

namespace Yakamara\Roadie\Component\HtmlAttribute;

enum Enterkeyhint: string
{
    case Enter = 'enter';
    case Done = 'done';
    case Go = 'go';
    case Next = 'next';
    case Previous = 'previous';
    case Search = 'search';
    case Send = 'send';
}
