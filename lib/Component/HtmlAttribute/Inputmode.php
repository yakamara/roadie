<?php

namespace Yakamara\Roadie\Component\HtmlAttribute;

enum Inputmode: string
{
    case None = 'none';
    case Text = 'text';
    case Decimal = 'decimal';
    case Numeric = 'numeric';
    case Tel = 'tel';
    case Search = 'search';
    case Email = 'email';
    case Url = 'url';
}
