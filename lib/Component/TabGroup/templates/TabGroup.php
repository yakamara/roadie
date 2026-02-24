<?php

use Yakamara\Roadie\Component\TabGroup\TabGroup;
use Yakamara\Roadie\Component\TabGroup\TabGroupActivation;
use Yakamara\Roadie\Component\TabGroup\TabGroupPlacement;

/** @var TabGroup $this */
?>

<wa-tab-group <?= $this->attributes->with([
    'placement' => TabGroupPlacement::Top !== $this->placement ? $this->placement : null,
    'activation' => TabGroupActivation::Auto !== $this->activation ? $this->activation : null,
    'active' => $this->active ?: null,
    'without-scroll-controls' => $this->withoutScrollControls,
])->toString() ?>>
    <?php foreach ($this->tabs as $tab): ?>
        <?php $tab->attributes->set('slot', 'nav') ?>
        <?= $tab ?>
    <?php endforeach ?>
    <?php foreach ($this->panels as $panel): ?>
        <?= $panel ?>
    <?php endforeach ?>
</wa-tab-group>
