<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\NumberInput\NumberInput;
use Yakamara\Roadie\Component\NumberInput\NumberInputAppearance;
use Yakamara\Roadie\Component\NumberInput\NumberInputSize;

/** @var NumberInput $this */
?>

<wa-number-input <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'placeholder' => $this->placeholder ?: null,
    'size' => NumberInputSize::Medium !== $this->size ? $this->size : null,
    'appearance' => NumberInputAppearance::Outlined !== $this->appearance ? $this->appearance : null,
    'name' => $this->name,
    'min' => $this->min,
    'max' => $this->max,
    'step' => $this->step,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
    'required' => $this->required,
    'pill' => $this->pill,
    'without-steppers' => $this->withoutSteppers,
    'autocomplete' => $this->autocomplete,
    'autofocus' => $this->autofocus,
    'enterkeyhint' => $this->enterkeyhint,
    'inputmode' => $this->inputmode,
    'hint' => $this->hint ?: null,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->incrementIcon, 'increment-icon') ?>
    <?= Component::slot($this->decrementIcon, 'decrement-icon') ?>
</wa-number-input>
