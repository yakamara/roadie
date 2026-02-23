<?php

namespace Yakamara\Roadie\Component\Button;

enum ButtonVariant: string
{
    case Neutral = 'neutral';
    case Primary = 'brand';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
}
