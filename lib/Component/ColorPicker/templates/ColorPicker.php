<?php

use Yakamara\Roadie\Component\ColorPicker\ColorPicker;
use Yakamara\Roadie\Component\ColorPicker\ColorPickerFormat;
use Yakamara\Roadie\Component\ColorPicker\ColorPickerSize;
use Yakamara\Roadie\Component\Component;

/** @var ColorPicker $this */
?>

<wa-color-picker <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'name' => $this->name,
    'format' => ColorPickerFormat::Hex !== $this->format ? $this->format : null,
    'size' => ColorPickerSize::Medium !== $this->size ? $this->size : null,
    'opacity' => $this->opacity,
    'open' => $this->open,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'uppercase' => $this->uppercase,
    'without-format-toggle' => $this->withoutFormatToggle,
    'swatches' => $this->swatches,
    'hint' => $this->hint ?: null,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
</wa-color-picker>
