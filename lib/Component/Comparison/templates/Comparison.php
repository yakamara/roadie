<?php

use Yakamara\Roadie\Component\Comparison\Comparison;
use Yakamara\Roadie\Component\Component;

/** @var Comparison $this */
?>

<wa-comparison <?= $this->attributes->with([
    'position' => 50 !== $this->position ? $this->position : null,
])->toString() ?>>
    <?= Component::slot($this->before, 'before') ?>
    <?= Component::slot($this->after, 'after') ?>
    <?= Component::slot($this->handle, 'handle') ?>
</wa-comparison>
