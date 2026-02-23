<?php

namespace Yakamara\Roadie\Component\HtmlAttribute;

enum Autocapitalize: string
{
    case Off = 'off';
    case Sentences = 'sentences';
    case Words = 'words';
    case Characters = 'characters';
}
