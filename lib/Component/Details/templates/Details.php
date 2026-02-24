<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Details\Details;
use Yakamara\Roadie\Component\Details\DetailsAppearance;
use Yakamara\Roadie\Component\Details\DetailsIconPlacement;

/** @var Details $this */
?>

<wa-details <?= $this->attributes->with([
    'summary' => $this->summary,
    'appearance' => DetailsAppearance::Outlined !== $this->appearance ? $this->appearance : null,
    'open' => $this->open,
    'disabled' => $this->disabled,
    'icon-placement' => DetailsIconPlacement::End !== $this->iconPlacement ? $this->iconPlacement : null,
    'name' => $this->name,
])->toString() ?>>
    <?= Component::slot($this->summarySlot, 'summary') ?>
    <?= Component::slot($this->expandIcon, 'expand-icon') ?>
    <?= Component::slot($this->collapseIcon, 'collapse-icon') ?>
    <?= Component::slot($this->content) ?>
</wa-details>
