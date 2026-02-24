<?php

use Yakamara\Roadie\Component\Sparkline\Sparkline;
use Yakamara\Roadie\Component\Sparkline\SparklineAppearance;
use Yakamara\Roadie\Component\Sparkline\SparklineCurve;

/** @var Sparkline $this */
?>

<wa-sparkline <?= $this->attributes->with([
    'data' => $this->data,
    'label' => $this->label,
    'appearance' => SparklineAppearance::Solid !== $this->appearance ? $this->appearance : null,
    'curve' => SparklineCurve::Linear !== $this->curve ? $this->curve : null,
    'trend' => $this->trend,
])->toString() ?>></wa-sparkline>
