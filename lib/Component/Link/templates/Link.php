<?php

use Yakamara\Roadie\Component\Link\Link;
use Yakamara\Roadie\Component\Component;

/** @var Link $this */

?>

<a <?= $this->attributes->with([
    'href' => $this->href,
    'target' => $this->target?->value,
    'rel' => $this->rel,
])->toString() ?>><?= Component::slot($this->start, 'start') ?><?= Component::slot($this->label) ?><?= Component::slot($this->end, 'end') ?></a>
