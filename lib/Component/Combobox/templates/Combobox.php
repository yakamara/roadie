<?php

use Yakamara\Roadie\Component\Combobox\Combobox;
use Yakamara\Roadie\Component\Combobox\ComboboxAppearance;
use Yakamara\Roadie\Component\Combobox\ComboboxAutocomplete;
use Yakamara\Roadie\Component\Combobox\ComboboxPlacement;
use Yakamara\Roadie\Component\Combobox\ComboboxSize;
use Yakamara\Roadie\Component\Component;

/** @var Combobox $this */
?>

<wa-combobox <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'hint' => $this->hint ?: null,
    'name' => $this->name,
    'value' => $this->value,
    'placeholder' => $this->placeholder,
    'size' => ComboboxSize::Medium !== $this->size ? $this->size : null,
    'appearance' => ComboboxAppearance::Outlined !== $this->appearance ? $this->appearance : null,
    'autocomplete' => ComboboxAutocomplete::List !== $this->autocomplete ? $this->autocomplete : null,
    'allow-custom-value' => $this->allowCustomValue,
    'multiple' => $this->multiple,
    'max-options-visible' => 3 !== $this->maxOptionsVisible ? $this->maxOptionsVisible : null,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'pill' => $this->pill,
    'with-clear' => $this->withClear,
    'open' => $this->open,
    'placement' => ComboboxPlacement::Bottom !== $this->placement ? $this->placement : null,
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
</wa-combobox>
