<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Dialog\Dialog;

/** @var Dialog $this */
?>

<wa-dialog <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'open' => $this->open,
    'light-dismiss' => $this->lightDismiss,
    'without-header' => $this->withoutHeader,
])->toString() ?>>
    <?= Component::slot($this->labelSlot, 'label') ?>
    <?= Component::slot($this->headerActions, 'header-actions') ?>
    <?= Component::slot($this->content) ?>
    <?= Component::slot($this->footer, 'footer') ?>
</wa-dialog>
