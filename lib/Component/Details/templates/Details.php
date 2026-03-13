<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Details\Details;
use Yakamara\Roadie\Component\Details\DetailsAppearance;
use Yakamara\Roadie\Component\Details\DetailsIconPlacement;

/** @var Details $this */
?>

<wa-details <?= $this->attributes->with([
    'summary' => is_string($this->summary) ? $this->summary : null,
    'appearance' => DetailsAppearance::Outlined !== $this->appearance ? $this->appearance : null,
    'open' => $this->open,
    'disabled' => $this->disabled,
    'icon-placement' => DetailsIconPlacement::End !== $this->iconPlacement ? $this->iconPlacement : null,
    'name' => $this->name,
])->toString() ?>>
    <?= $this->summary instanceof Component ? Component::slot($this->summary, 'summary') : '' ?>
    <?= Component::slot($this->expandIcon, 'expand-icon') ?>
    <?= Component::slot($this->collapseIcon, 'collapse-icon') ?>
    <?= Component::slot($this->content) ?>
</wa-details>
