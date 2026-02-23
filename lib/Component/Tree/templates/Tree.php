<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Tree\Tree;
use Yakamara\Roadie\Component\Tree\TreeSelection;

/** @var Tree $this */
?>

<wa-tree <?= $this->attributes->with([
    'selection' => $this->selection !== TreeSelection::Single ? $this->selection : null,
])->toString() ?>>
    <?= Component::slot($this->expandIcon, 'expand-icon') ?>
    <?= Component::slot($this->collapseIcon, 'collapse-icon') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item ?>
    <?php endforeach ?>
</wa-tree>
