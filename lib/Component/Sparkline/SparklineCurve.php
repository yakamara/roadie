<?php

namespace Yakamara\Roadie\Component\Sparkline;

enum SparklineCurve: string
{
    case Linear = 'linear';
    case Natural = 'natural';
    case Step = 'step';
}
