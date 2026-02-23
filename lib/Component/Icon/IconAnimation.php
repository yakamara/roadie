<?php

namespace Yakamara\Roadie\Component\Icon;

enum IconAnimation: string
{
    case Beat = 'beat';
    case Fade = 'fade';
    case BeatFade = 'beat-fade';
    case Bounce = 'bounce';
    case Flip = 'flip';
    case Shake = 'shake';
    case Spin = 'spin';
    case SpinPulse = 'spin-pulse';
    case SpinReverse = 'spin-reverse';
}
