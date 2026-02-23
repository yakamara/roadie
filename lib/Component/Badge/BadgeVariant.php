<?php

namespace Yakamara\Roadie\Component\Badge;

enum BadgeVariant: string
{
    case Brand = 'brand';
    case Neutral = 'neutral';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
}
