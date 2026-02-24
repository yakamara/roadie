<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Switch\SwitchSize;
use Yakamara\Roadie\Component\Switch\SwitchToggle;

/** @var SwitchToggle $this */
?>

<wa-switch <?= $this->attributes->with([
    'name' => $this->name,
    'value' => $this->value,
    'checked' => $this->checked,
    'default-checked' => $this->defaultChecked,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'size' => SwitchSize::Medium !== $this->size ? $this->size : null,
    'hint' => $this->hint ?: null,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->label) ?>
</wa-switch>
