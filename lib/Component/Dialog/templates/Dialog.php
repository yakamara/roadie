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
    'data-custom-close' => $this->closeIcon ? true : null,
])->toString() ?>>
    <?= Component::slot($this->labelSlot, 'label') ?>
    <?php if ($this->closeIcon): ?>
        <wa-button slot="header-actions" appearance="plain" onclick="this.closest('wa-dialog').requestClose()">
            <?= $this->closeIcon ?>
        </wa-button>
    <?php endif ?>
    <?= Component::slot($this->headerActions, 'header-actions') ?>
    <?= Component::slot($this->content) ?>
    <?= Component::slot($this->footer, 'footer') ?>
</wa-dialog>
