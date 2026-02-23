<?php

namespace Yakamara\Roadie\Component\Callout;

enum CalloutVariant: string
{
    case Brand = 'brand';
    case Neutral = 'neutral';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
}
