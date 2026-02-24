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
    'size' => SelectSize::Medium !== $this->size ? $this->size : null,
    'appearance' => SelectAppearance::Outlined !== $this->appearance ? $this->appearance : null,
    'multiple' => $this->multiple,
    'max-options-visible' => 3 !== $this->maxOptionsVisible ? $this->maxOptionsVisible : null,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'pill' => $this->pill,
    'with-clear' => $this->withClear,
    'open' => $this->open,
    'placement' => SelectPlacement::Bottom !== $this->placement ? $this->placement : null,
    'hint' => $this->hint ?: null,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
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
