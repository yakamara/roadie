<?php

namespace Yakamara\Roadie\Component\FormatDate;

enum FormatDateHourFormat: string
{
    case Auto = 'auto';
    case H12 = '12';
    case H24 = '24';
}
