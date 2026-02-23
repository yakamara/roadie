<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Combobox\Combobox;
use Yakamara\Roadie\Component\Combobox\ComboboxAppearance;
use Yakamara\Roadie\Component\Combobox\ComboboxAutocomplete;
use Yakamara\Roadie\Component\Combobox\ComboboxPlacement;
use Yakamara\Roadie\Component\Combobox\ComboboxSize;

/** @var Combobox $this */
?>

<wa-combobox <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'hint' => $this->hint ?: null,
    'name' => $this->name,
    'value' => $this->value,
    'placeholder' => $this->placeholder,
    'size' => $this->size !== ComboboxSize::Medium ? $this->size : null,
    'appearance' => $this->appearance !== ComboboxAppearance::Outlined ? $this->appearance : null,
    'autocomplete' => $this->autocomplete !== ComboboxAutocomplete::List ? $this->autocomplete : null,
    'allow-custom-value' => $this->allowCustomValue,
    'multiple' => $this->multiple,
    'max-options-visible' => $this->maxOptionsVisible !== 3 ? $this->maxOptionsVisible : null,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'pill' => $this->pill,
    'with-clear' => $this->withClear,
    'open' => $this->open,
    'placement' => $this->placement !== ComboboxPlacement::Bottom ? $this->placement : null,
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
</wa-combobox>
