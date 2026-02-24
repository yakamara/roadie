<?php

namespace Yakamara\Roadie\Component\Button;

enum ButtonVariant: string
{
    case Brand = 'brand';
    case Danger = 'danger';
    case Neutral = 'neutral';
    case Success = 'success';
    case Warning = 'warning';
}
