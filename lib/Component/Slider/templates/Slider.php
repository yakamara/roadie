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
    'min' => $this->min !== 0.0 ? $this->min : null,
    'max' => $this->max !== 100.0 ? $this->max : null,
    'step' => $this->step !== 1.0 ? $this->step : null,
    'orientation' => $this->orientation !== SliderOrientation::Horizontal ? $this->orientation : null,
    'size' => $this->size !== SliderSize::Medium ? $this->size : null,
    'name' => $this->name,
    'autofocus' => $this->autofocus,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
    'required' => $this->required,
    'range' => $this->range,
    'with-markers' => $this->withMarkers,
    'with-tooltip' => $this->withTooltip,
    'indicator-offset' => $this->indicatorOffset,
    'tooltip-distance' => $this->tooltipDistance !== 8 ? $this->tooltipDistance : null,
    'tooltip-placement' => $this->tooltipPlacement !== SliderTooltipPlacement::Top ? $this->tooltipPlacement : null,
    'hint' => $this->hint ?: null,
    'with-label' => $this->label !== null,
    'with-hint' => $this->hint !== null,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->reference, 'reference') ?>
</wa-slider>
