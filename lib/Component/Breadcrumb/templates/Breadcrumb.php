<?php

use Yakamara\Roadie\Component\Breadcrumb\Breadcrumb;
use Yakamara\Roadie\Component\Component;

/** @var Breadcrumb $this */
?>

<wa-breadcrumb <?= $this->attributes->with([
    'label' => $this->label ?: null,
])->toString() ?>>
    <?= Component::slot($this->separator, 'separator') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item ?>
    <?php endforeach ?>
</wa-breadcrumb>
