<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\TabGroup\TabGroup;
use Yakamara\Roadie\Component\TabGroup\TabGroupActivation;
use Yakamara\Roadie\Component\TabGroup\TabGroupPlacement;

/** @var TabGroup $this */
?>

<wa-tab-group <?= $this->attributes->with([
    'placement' => $this->placement !== TabGroupPlacement::Top ? $this->placement : null,
    'activation' => $this->activation !== TabGroupActivation::Auto ? $this->activation : null,
    'active' => $this->active ?: null,
    'without-scroll-controls' => $this->withoutScrollControls,
])->toString() ?>>
    <?php foreach ($this->tabs as $tab): ?>
        <?php $tab->attributes->set('slot', 'nav'); ?>
        <?= $tab ?>
    <?php endforeach ?>
    <?php foreach ($this->panels as $panel): ?>
        <?= $panel ?>
    <?php endforeach ?>
</wa-tab-group>
