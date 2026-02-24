<?php

use Yakamara\Roadie\Component\Checkbox\Checkbox;
use Yakamara\Roadie\Component\Checkbox\CheckboxSize;
use Yakamara\Roadie\Component\Component;

/** @var Checkbox $this */
?>

<wa-checkbox <?= $this->attributes->with([
    'name' => $this->name ?: null,
    'value' => $this->value,
    'checked' => $this->checked,
    'default-checked' => $this->defaultChecked,
    'indeterminate' => $this->indeterminate,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'size' => CheckboxSize::Medium !== $this->size ? $this->size : null,
    'hint' => $this->hint ?: null,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->label) ?>
</wa-checkbox>
