<?php

namespace Yakamara\Roadie\Component\Animation;

enum AnimationDirection: string
{
    case Normal = 'normal';
    case Reverse = 'reverse';
    case Alternate = 'alternate';
    case AlternateReverse = 'alternate-reverse';
}
