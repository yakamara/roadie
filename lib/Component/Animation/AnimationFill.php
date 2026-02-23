<?php

namespace Yakamara\Roadie\Component\Animation;

enum AnimationFill: string
{
    case Auto = 'auto';
    case None = 'none';
    case Forwards = 'forwards';
    case Backwards = 'backwards';
    case Both = 'both';
}
