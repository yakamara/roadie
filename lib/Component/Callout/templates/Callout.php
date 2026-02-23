<?php

use Yakamara\Roadie\Component\Callout\Callout;
use Yakamara\Roadie\Component\Component;

/** @var Callout $this */
?>

<wa-callout <?= $this->attributes->with([
    'appearance' => $this->appearance,
    'variant' => $this->variant,
    'size' => $this->size,
])->toString() ?>>
    <?= Component::slot($this->icon, 'icon') ?>
    <?= Component::slot($this->content) ?>
</wa-callout>
