<?php

namespace Yakamara\Roadie\Component\Tag;

enum TagVariant: string
{
    case Brand = 'brand';
    case Neutral = 'neutral';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
}
