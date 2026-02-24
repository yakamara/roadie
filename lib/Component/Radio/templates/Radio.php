<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Radio\Radio;
use Yakamara\Roadie\Component\Radio\RadioAppearance;

/** @var Radio $this */
?>

<wa-radio <?= $this->attributes->with([
    'value' => $this->value,
    'appearance' => RadioAppearance::Default !== $this->appearance ? $this->appearance : null,
    'size' => $this->size,
    'disabled' => $this->disabled,
])->toString() ?>>
    <?= Component::slot($this->label) ?>
</wa-radio>
