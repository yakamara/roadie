<?php

use Yakamara\Roadie\Component\Rating\Rating;
use Yakamara\Roadie\Component\Rating\RatingSize;

/** @var Rating $this */
?>

<wa-rating <?= $this->attributes->with([
    'value' => $this->value ?: null,
    'max' => $this->max !== 5 ? $this->max : null,
    'precision' => $this->precision !== 1.0 ? $this->precision : null,
    'size' => $this->size !== RatingSize::Medium ? $this->size : null,
    'label' => $this->label ?: null,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
])->toString() ?>></wa-rating>
