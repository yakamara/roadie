<?php

namespace Yakamara\Roadie\Slice;

use Yakamara\Roadie\Trait\EnumToArrayTrait;

enum SliceType: string
{
    use EnumToArrayTrait;

    case NEW_SECTION = 'NEW_SECTION';
    case SUB_SECTION = 'SUB_SECTION';
    case CONTINUATION = 'CONTINUATION';

    public function getTranslation(): string
    {
        return match ($this) {
            self::NEW_SECTION => 'Neuen Abschnitt starten',
            self::SUB_SECTION => 'Unterabschnitt erstellen',
            self::CONTINUATION => 'Vorherigen Abschnitt fortsetzen',
            default => '',
        };
    }
}
