<?php

namespace Yakamara\Roadie\Component\FormatNumber;

enum FormatNumberType: string
{
    case Currency = 'currency';
    case Decimal = 'decimal';
    case Percent = 'percent';
}
