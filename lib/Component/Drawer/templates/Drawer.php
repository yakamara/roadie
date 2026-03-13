<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Drawer\Drawer;
use Yakamara\Roadie\Component\Drawer\DrawerPlacement;

/** @var Drawer $this */
?>

<wa-drawer <?= $this->attributes->with([
    'label' => is_string($this->label) ? $this->label : null,
    'placement' => DrawerPlacement::End !== $this->placement ? $this->placement : null,
    'open' => $this->open,
    'light-dismiss' => $this->lightDismiss,
    'without-header' => $this->withoutHeader,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= Component::slot($this->headerActions, 'header-actions') ?>
    <?= Component::slot($this->content) ?>
    <?= Component::slot($this->footer, 'footer') ?>
</wa-drawer>
