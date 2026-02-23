<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\RadioGroup\RadioGroup;
use Yakamara\Roadie\Component\RadioGroup\RadioGroupOrientation;

/** @var RadioGroup $this */
?>

<wa-radio-group <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'name' => $this->name,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'orientation' => $this->orientation !== RadioGroupOrientation::Vertical ? $this->orientation : null,
    'size' => $this->size,
    'disabled' => $this->disabled,
    'required' => $this->required,
    'hint' => $this->hint ?: null,
    'with-label' => $this->label !== null,
    'with-hint' => $this->hint !== null,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?php foreach ($this->radios as $radio): ?>
        <?= $radio ?>
    <?php endforeach ?>
</wa-radio-group>
