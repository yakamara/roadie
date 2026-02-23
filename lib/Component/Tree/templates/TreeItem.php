<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Tree\TreeItem;

/** @var TreeItem $this */
?>

<wa-tree-item <?= $this->attributes->with([
    'expanded' => $this->expanded,
    'selected' => $this->selected,
    'disabled' => $this->disabled,
    'lazy' => $this->lazy,
])->toString() ?>>
    <?= Component::slot($this->expandIcon, 'expand-icon') ?>
    <?= Component::slot($this->collapseIcon, 'collapse-icon') ?>
    <?= Component::slot($this->label) ?>
    <?php foreach ($this->children as $child): ?>
        <?= $child ?>
    <?php endforeach ?>
</wa-tree-item>
