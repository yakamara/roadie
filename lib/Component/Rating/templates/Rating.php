<?php

use Yakamara\Roadie\Component\Rating\Rating;
use Yakamara\Roadie\Component\Rating\RatingSize;

/** @var Rating $this */
?>

<wa-rating <?= $this->attributes->with([
    'value' => $this->value ?: null,
    'max' => 5 !== $this->max ? $this->max : null,
    'precision' => 1.0 !== $this->precision ? $this->precision : null,
    'size' => RatingSize::Medium !== $this->size ? $this->size : null,
    'label' => $this->label ?: null,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
])->toString() ?>></wa-rating>
