<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Tag\Tag;

/** @var Tag $this */
?>

<wa-tag <?= $this->attributes->with([
    'appearance' => $this->appearance,
    'variant' => $this->variant,
    'size' => $this->size,
    'pill' => $this->pill,
    'with-remove' => $this->withRemove,
])->toString() ?>><?= Component::slot($this->label) ?></wa-tag>
