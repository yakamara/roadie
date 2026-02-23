<?php

namespace Yakamara\Roadie\Component\Sparkline;

enum SparklineTrend: string
{
    case Positive = 'positive';
    case Negative = 'negative';
    case Neutral = 'neutral';
}
