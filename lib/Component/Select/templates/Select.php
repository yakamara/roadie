<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Select\Select;
use Yakamara\Roadie\Component\Select\SelectAppearance;
use Yakamara\Roadie\Component\Select\SelectPlacement;
use Yakamara\Roadie\Component\Select\SelectSize;

/** @var Select $this */
?>

<wa-select <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'name' => $this->name,
    'value' => $this->value,
    'placeholder' => $this->placeholder ?: null,
    'size' => $this->size !== SelectSize::Medium ? $this->size : null,
    'appearance' => $this->appearance !== SelectAppearance::Outlined ? $this->appearance : null,
    'multiple' => $this->multiple,
    'max-options-visible' => $this->maxOptionsVisible !== 3 ? $this->maxOptionsVisible : null,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'pill' => $this->pill,
    'with-clear' => $this->withClear,
    'open' => $this->open,
    'placement' => $this->placement !== SelectPlacement::Bottom ? $this->placement : null,
    'hint' => $this->hint ?: null,
    'with-label' => $this->label !== null,
    'with-hint' => $this->hint !== null,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->clearIcon, 'clear-icon') ?>
    <?= Component::slot($this->expandIcon, 'expand-icon') ?>
    <?php foreach ($this->options as $option): ?>
        <?= $option ?>
    <?php endforeach ?>
</wa-select>
