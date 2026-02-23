<?php

namespace Yakamara\Roadie\Component\FormatNumber;

enum FormatNumberCurrencyDisplay: string
{
    case Symbol = 'symbol';
    case NarrowSymbol = 'narrowSymbol';
    case Code = 'code';
    case Name = 'name';
}
