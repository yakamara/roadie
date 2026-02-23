<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Select\Option;

/** @var Option $this */
?>

<wa-option <?= $this->attributes->with([
    'value' => $this->value ?: null,
    'disabled' => $this->disabled,
    'default-selected' => $this->defaultSelected,
])->toString() ?>>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->label) ?>
</wa-option>
