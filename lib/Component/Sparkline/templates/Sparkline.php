<?php

use Yakamara\Roadie\Component\Sparkline\Sparkline;
use Yakamara\Roadie\Component\Sparkline\SparklineAppearance;
use Yakamara\Roadie\Component\Sparkline\SparklineCurve;

/** @var Sparkline $this */
?>

<wa-sparkline <?= $this->attributes->with([
    'data' => $this->data,
    'label' => $this->label,
    'appearance' => $this->appearance !== SparklineAppearance::Solid ? $this->appearance : null,
    'curve' => $this->curve !== SparklineCurve::Linear ? $this->curve : null,
    'trend' => $this->trend,
])->toString() ?>></wa-sparkline>
