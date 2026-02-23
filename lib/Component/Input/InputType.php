<?php

namespace Yakamara\Roadie\Component\Input;

use Yakamara\Roadie\Component\HtmlAttribute\Inputmode;

enum InputType: string
{
    case Color = 'color';
    case Date = 'date';
    case DatetimeLocal = 'datetime-local';
    case Email = 'email';
    case Hidden = 'hidden';
    case Month = 'month';
    case Number = 'number';
    case Password = 'password';
    case Search = 'search';
    case Tel = 'tel';
    case Text = 'text';
    case Time = 'time';
    case Url = 'url';
    case Week = 'week';

    public function toInputmode(): ?Inputmode
    {
        return match ($this) {
            self::Email => Inputmode::Email,
            self::Search => Inputmode::Search,
            self::Tel => Inputmode::Tel,
            self::Url => Inputmode::Url,
            default => null,
        };
    }

    public function supportsMinMaxStep(): bool
    {
        return match ($this) {
            self::Date,
            self::DatetimeLocal,
            self::Number,
            self::Time => true,
            default => false,
        };
    }
}
