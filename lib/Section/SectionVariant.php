<?php

namespace Yakamara\Roadie\Section;

enum SectionVariant: string
{
    case Plain = 'plain';
    case Brand = 'brand';
    case Neutral = 'neutral';

    public function getLabel(): string
    {
        return match ($this) {
            self::Plain   => 'Standard',
            self::Brand   => 'Markenfarbe',
            self::Neutral => 'Neutral',
        };
    }
}
