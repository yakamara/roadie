<?php

use Yakamara\Roadie\Component\Card\Card;
use Yakamara\Roadie\Component\Card\CardAppearance;
use Yakamara\Roadie\Component\Card\CardOrientation;
use Yakamara\Roadie\Component\Component;

/** @var Card $this */
?>

<wa-card <?= $this->attributes->with([
    'appearance' => $this->appearance !== CardAppearance::Outlined ? $this->appearance : null,
    'orientation' => $this->orientation !== CardOrientation::Vertical ? $this->orientation : null,
    'with-header' => $this->header !== null,
    'with-footer' => $this->footer !== null,
    'with-media' => $this->media !== null,
])->toString() ?>>
    <?= Component::slot($this->media, 'media') ?>
    <?= Component::slot($this->header, 'header') ?>
    <?= Component::slot($this->headerActions, 'header-actions') ?>
    <?= Component::slot($this->content) ?>
    <?= Component::slot($this->footer, 'footer') ?>
    <?= Component::slot($this->footerActions, 'footer-actions') ?>
    <?= Component::slot($this->actions, 'actions') ?>
</wa-card>
