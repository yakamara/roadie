<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Slider\Slider;
use Yakamara\Roadie\Component\Slider\SliderOrientation;
use Yakamara\Roadie\Component\Slider\SliderSize;
use Yakamara\Roadie\Component\Slider\SliderTooltipPlacement;

/** @var Slider $this */
?>

<wa-slider <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'min' => 0.0 !== $this->min ? $this->min : null,
    'max' => 100.0 !== $this->max ? $this->max : null,
    'step' => 1.0 !== $this->step ? $this->step : null,
    'orientation' => SliderOrientation::Horizontal !== $this->orientation ? $this->orientation : null,
    'size' => SliderSize::Medium !== $this->size ? $this->size : null,
    'name' => $this->name,
    'autofocus' => $this->autofocus,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
    'required' => $this->required,
    'range' => $this->range,
    'with-markers' => $this->withMarkers,
    'with-tooltip' => $this->withTooltip,
    'indicator-offset' => $this->indicatorOffset,
    'tooltip-distance' => 8 !== $this->tooltipDistance ? $this->tooltipDistance : null,
    'tooltip-placement' => SliderTooltipPlacement::Top !== $this->tooltipPlacement ? $this->tooltipPlacement : null,
    'hint' => $this->hint ?: null,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->reference, 'reference') ?>
</wa-slider>
